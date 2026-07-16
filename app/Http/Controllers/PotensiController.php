<?php
namespace App\Http\Controllers;
use App\Models\Potensi;
use App\Models\Setting;
class PotensiController extends Controller {
    public function index() {
        $settings = Setting::all()->pluck('value', 'key');
        
        $wisata = Potensi::where('kategori', 'wisata')->latest()->get();
        $umkm = Potensi::where('kategori', 'umkm')->latest()->get();
        $pertanian = Potensi::where('kategori', 'pertanian')->latest()->get();
        $budaya = Potensi::where('kategori', 'budaya')->latest()->get();

        return view('pages.potensi.index', compact('settings', 'wisata', 'umkm', 'pertanian', 'budaya'));
    }
    public function show($slug) {
        $settings = Setting::all()->pluck('value', 'key');
        $potensi  = Potensi::where('slug', $slug)->firstOrFail();
        return view('pages.potensi.show', compact('settings', 'potensi'));
    }
}
