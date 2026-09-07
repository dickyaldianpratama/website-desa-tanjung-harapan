<?php
namespace App\Http\Controllers;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Berita;
use App\Models\Potensi;
use App\Models\Perangkat;
use App\Models\AbsensiPerangkat;

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

        // Absensi hari ini beserta data perangkat
        $perangkats = Perangkat::orderBy('urutan')->get();
        $absensiHariIni = AbsensiPerangkat::hariIni()->get()->keyBy('perangkat_id');

        return view('pages.home', compact('settings', 'sliders', 'beritas', 'potensis', 'kades', 'perangkats', 'absensiHariIni'));
    }

    /**
     * Public JSON endpoint: data absensi hari ini untuk widget publik.
     */
    public function absensiHariIni()
    {
        $perangkats = Perangkat::orderBy('urutan')->get();
        $absensiMap = AbsensiPerangkat::hariIni()->get()->keyBy('perangkat_id');

        $data = $perangkats->map(function ($p) use ($absensiMap) {
            $a = $absensiMap->get($p->id);
            return [
                'id'      => $p->id,
                'nama'    => $p->nama,
                'jabatan' => $p->jabatan,
                'foto'    => $p->foto ? \Storage::disk('s3')->url('images/perangkat/' . $p->foto) : null,
                'status'  => $a ? $a->status : 'belum',
            ];
        });

        return response()->json([
            'tanggal' => now()->translatedFormat('l, d F Y'),
            'hadir'   => $data->where('status', 'hadir')->count(),
            'izin'    => $data->where('status', 'izin')->count(),
            'belum'   => $data->where('status', 'belum')->count(),
            'data'    => $data->values(),
        ]);
    }
}

