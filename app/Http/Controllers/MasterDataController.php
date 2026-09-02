<?php

namespace App\Http\Controllers;

use App\Models\MasterData;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectedModel = $request->query('model_name');

        $masterDataList = MasterData::query()
            ->when($selectedModel, fn ($query) => $query->where('model_name', $selectedModel))
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();

        $modelNames = MasterData::query()
            ->select('model_name')
            ->distinct()
            ->orderBy('model_name')
            ->pluck('model_name');

        return view('master-data.index', compact('masterDataList', 'modelNames', 'selectedModel'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master-data.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'model_name' => 'required|string|max:255',
            'item_name' => 'required|string|max:255',
        ]);

        MasterData::create($validated);

        return redirect()->route('master-data.index')->with('success', 'Master Data created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterData $masterData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterData $masterDatum)
    {
        return view('master-data.edit', ['masterData' => $masterDatum]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterData $masterDatum)
    {
        $validated = $request->validate([
            'model_name' => 'required|string|max:255',
            'item_name' => 'required|string|max:255',
        ]);

        $masterDatum->update($validated);

        return redirect()->route('master-data.index')->with('success', 'Master Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterData $masterDatum)
    {
        $masterDatum->delete();

        return redirect()->route('master-data.index')->with('success', 'Master Data berhasil dihapus dari database.');
    }
}
