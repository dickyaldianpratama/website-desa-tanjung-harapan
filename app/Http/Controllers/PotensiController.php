<?php
namespace App\Http\Controllers;
use App\Models\Potensi;
use App\Models\Setting;
class PotensiController extends Controller {
    public function index() {
        $settings = Setting::all()->pluck('value', 'key');
        
        // Fetch all and group by category
        $groupedPotensi = Potensi::latest()->get()->groupBy(function($item) {
            return strtolower($item->kategori);
        });

        return view('pages.potensi.index', compact('settings', 'groupedPotensi'));
    }
    public function show($slug) {
        $settings = Setting::all()->pluck('value', 'key');
        $potensi  = Potensi::where('slug', $slug)->firstOrFail();
        return view('pages.potensi.show', compact('settings', 'potensi'));
    }
}
