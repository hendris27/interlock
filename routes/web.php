<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
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
