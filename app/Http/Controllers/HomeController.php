<?php
namespace App\Http\Controllers;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Berita;
use App\Models\Potensi;
class HomeController extends Controller {
    public function index() {
        $settings = Setting::all()->pluck('value', 'key');
        $sliders  = Slider::aktif()->get();
        $beritas  = Berita::publish()->latest('published_at')->take(3)->get();
        $potensis = Potensi::latest()->take(3)->get();
        return view('pages.home', compact('settings', 'sliders', 'beritas', 'potensis'));
    }
}
