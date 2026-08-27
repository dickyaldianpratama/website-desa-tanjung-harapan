<?php
namespace App\Http\Controllers;
use App\Models\Setting;
use App\Models\Perangkat;
use App\Models\Lembaga;

class ProfilController extends Controller {
    public function index() {
        $settings  = Setting::all()->pluck('value', 'key');
        $perangkats = Perangkat::urut()->get();
        
        $kades = Perangkat::where('urutan', 1)
                    ->orWhere('jabatan', 'like', '%Kepala Desa%')
                    ->orderBy('urutan', 'asc')
                    ->first();

        $bpd = Lembaga::where('tipe', 'BPD')->urut()->get();
        $pkk = Lembaga::where('tipe', 'PKK')->urut()->get();

        return view('pages.profil', compact('settings', 'perangkats', 'kades', 'bpd', 'pkk'));
    }
}
