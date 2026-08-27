<?php
namespace App\Http\Controllers;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Berita;
use App\Models\Potensi;
use App\Models\Perangkat;

class HomeController extends Controller {
    public function index() {
        $settings = Setting::all()->pluck('value', 'key');
        $sliders  = Slider::aktif()->get();
        $beritas  = Berita::publish()->latest('published_at')->take(3)->get();
        $potensis = Potensi::latest()->take(3)->get();
        
        // Ambil data Kepala Desa dari tabel Perangkat (biasanya urutan 1 atau jabatan Kepala Desa)
        $kades = Perangkat::where('urutan', 1)
                    ->orWhere('jabatan', 'like', '%Kepala Desa%')
                    ->orderBy('urutan', 'asc')
                    ->first();

        return view('pages.home', compact('settings', 'sliders', 'beritas', 'potensis', 'kades'));
    }
}
