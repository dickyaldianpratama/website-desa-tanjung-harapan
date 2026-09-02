<?php
namespace App\Http\Controllers;
use App\Models\Setting;
use App\Models\Perangkat;
use App\Models\Lembaga;
use App\Models\BaganStruktur;

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
        
        $bagans = BaganStruktur::orderBy('urutan', 'asc')->get();

        return view('pages.profil', compact('settings', 'perangkats', 'kades', 'bpd', 'pkk', 'bagans'));
    }

    public function downloadBagan($id) {
        $bagan = BaganStruktur::findOrFail($id);
        
        if (!$bagan->gambar) {
            abort(404, 'Gambar bagan tidak ditemukan.');
        }

        $fileUrl = \Illuminate\Support\Facades\Storage::disk('s3')->url('images/struktur/' . $bagan->gambar);
        $fileContent = @file_get_contents($fileUrl);

        if ($fileContent === false) {
            abort(404, 'File tidak dapat diunduh dari server.');
        }

        $ext = pathinfo($bagan->gambar, PATHINFO_EXTENSION) ?: 'jpg';
        $mimeMap = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp'];
        $mimeType = $mimeMap[strtolower($ext)] ?? 'application/octet-stream';

        $downloadName = \Illuminate\Support\Str::slug($bagan->nama) . '.' . $ext;

        return response($fileContent, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'attachment; filename="' . $downloadName . '"')
            ->header('Content-Length', strlen($fileContent));
    }
}
