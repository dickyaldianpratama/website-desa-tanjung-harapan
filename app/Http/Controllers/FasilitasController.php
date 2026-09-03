<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fasilitas;

class FasilitasController extends Controller
{
    public function index()
    {
        // Get all unique categories dynamically to build the filter tabs
        $kategoriList = Fasilitas::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
        
        // Get all facilities
        $fasilitas = Fasilitas::latest()->get();

        return view('pages.fasilitas.index', compact('fasilitas', 'kategoriList'));
    }
}
