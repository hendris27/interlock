<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterDataController;
use App\Models\MasterData;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

Route::get('/', function () {
    $modelNames = MasterData::query()
        ->select('model_name')
        ->distinct()
        ->orderBy('model_name')
        ->pluck('model_name');

    return view('home', compact('modelNames'));
})->name('home');

Route::post('/scan', function (Request $request) {
    $validated = $request->validate([
        'model_name' => ['required', 'string', 'max:1000'],
        'component_scan' => ['nullable', 'string', 'max:1000'],
    ], [
        'model_name.required' => 'Nama model wajib diisi.',

    ]);

    return to_route('home')->with('success', "Komponen " . ($validated['component_scan'] ?? '-') . " berhasil divalidasi untuk model {$validated['model_name']}.");
})->name('scan');

Route::get('/api/model-names', function () {
    $modelNames = \App\Models\MasterData::query()
        ->select('model_name')
        ->distinct()
        ->orderBy('model_name')
        ->pluck('model_name');

    return response()->json($modelNames);
});

Route::get('/api/model-items/{modelName}', function ($modelName) {
    $items = \App\Models\MasterData::where('model_name', $modelName)->get();
    return response()->json($items);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('master-data', MasterDataController::class);
Route::post('/interlock/machine-status', function (Request $request) {
    $validated = $request->validate([
        'status' => ['required', 'string', Rule::in(['Locked', 'Running'])],
    ]);

    $status = $validated['status'];

    $mqttCommand = $status === 'Running' ? 'ON' : 'OFF';

    try {
        $response = Http::timeout(5)->post(config('services.node_red.interlock_url'), [
            'status' => $status,
            'command' => $mqttCommand,
        ]);
    } catch (ConnectionException) {
        return response()->json([
            'success' => false,
            'message' => 'Node-RED tidak dapat dihubungi.',
            'status' => $status,
            'command' => $mqttCommand,
        ], 503);
    }

    return response()->json([
        'success' => $response->successful(),
        'status' => $status,
        'command' => $mqttCommand,
        'nodered_status' => $response->status(),
        'nodered_body' => $response->body(),
    ], $response->successful() ? 200 : 502);
});
