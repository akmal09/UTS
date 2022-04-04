<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DalamProdi;
use App\Models\LuarProdi;

class MatkulProdiController extends Controller
{
    // Pembuatan method untuk get mata kuliah dalam prodi
    public function get_matakuliah_dalam_prodi(){
        $dalamProdi = DalamProdi::all();
        return response()->json($dalamProdi);
    }

    // Pembuatan method untuk get mata kuliah luar prodi yang dijadikan ke dalam json
    public function get_matakuliah_luar_prodi(){
        $luarProdi = LuarProdi::all();
        return response()->json($luarProdi);
    }

    // Pembuatan method untuk Landing Page yang dijadikan ke dalam json
    public function portallaravel(){
        return view('portallaravel');
    }
}
