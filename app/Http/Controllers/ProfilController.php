<?php
namespace App\Http\Controllers;
use App\Models\Setting;
use App\Models\Perangkat;
class ProfilController extends Controller {
    public function index() {
        $settings  = Setting::all()->pluck('value', 'key');
        $perangkats = Perangkat::urut()->get();
        return view('pages.profil', compact('settings', 'perangkats'));
    }
}
