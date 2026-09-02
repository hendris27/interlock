<?php

namespace App\Http\Controllers;

use App\Models\MasterData;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $masterDataList = MasterData::all();
        return view('dashboard', compact('masterDataList'));
    }
}
