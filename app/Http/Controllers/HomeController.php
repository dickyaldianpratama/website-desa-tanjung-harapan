<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Slider;
use App\Models\Berita;
use App\Models\Potensi;
use App\Models\Perangkat;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key');
        $sliders = Slider::active()->orderBy('urutan')->get();
        $beritas = Berita::published()->latest()->take(3)->get();
        $potensis = Potensi::latest()->take(4)->get();
        
        // Ambil kades
        $kades = Perangkat::whereRaw('LOWER(jabatan) = ?', ['kepala desa'])->first();

        // Ambil sisa perangkat untuk slider (termasuk kades)
        $perangkats = Perangkat::orderBy('urutan')->get();

        return view('pages.home', compact('settings', 'sliders', 'beritas', 'potensis', 'kades', 'perangkats'));
    }
}
