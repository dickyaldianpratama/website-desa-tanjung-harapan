<?php
namespace App\Http\Controllers;
use App\Models\Apbdes;
use App\Models\Setting;
class TransparansiController extends Controller {
    public function index() {
        $settings  = Setting::all()->pluck('value', 'key');
        // Ambil daftar tahun yang ada di database
        $tahunList = Apbdes::select('tahun')->distinct()->orderBy('tahun','desc')->pluck('tahun');
        
        // Default ke tahun request, atau tahun terbaru di DB, atau tahun ini jika kosong
        $latestYearInDb = $tahunList->first() ?? date('Y');
        $tahun     = request('tahun', $latestYearInDb);
        
        // Data APBDes dari Database
        $apbdes    = Apbdes::where('tahun', $tahun)->get();

        // Data Dummy Kependudukan (Sesuai PRD, untuk Dashboard)
        $kependudukan = [
            'total' => 3250,
            'pria' => 1650,
            'wanita' => 1600,
            'kelompok_umur' => [
                '0-14 Tahun' => ['pria' => 350, 'wanita' => 320],
                '15-24 Tahun' => ['pria' => 280, 'wanita' => 260],
                '25-54 Tahun' => ['pria' => 750, 'wanita' => 720],
                '55+ Tahun' => ['pria' => 270, 'wanita' => 300],
            ],
            'pendidikan' => [
                'Belum/Tidak Sekolah' => 250,
                'SD Sederajat' => 800,
                'SMP Sederajat' => 950,
                'SMA Sederajat' => 1050,
                'Diploma/Sarjana' => 200,
            ],
            'pekerjaan' => [
                'Petani/Pekebun' => 850,
                'Wiraswasta/Pedagang' => 450,
                'Karyawan Swasta' => 350,
                'PNS/TNI/Polri' => 150,
                'Pelajar/Mahasiswa' => 650,
                'Lainnya/Belum Bekerja' => 800,
            ]
        ];

        // Data Dummy BLT
        $blt = [
            'penerima_kk' => 150,
            'total_dana' => 54000000,
            'persentase_tersalurkan' => 85
        ];

        // Data Dummy Realisasi Program (Timeline)
        $program = [
            ['nama' => 'Pembangunan Jalan Poros Desa', 'progress' => 100, 'status' => 'Selesai'],
            ['nama' => 'Penyaluran BLT Dana Desa', 'progress' => 100, 'status' => 'Selesai'],
            ['nama' => 'Renovasi Posyandu Mawar', 'progress' => 75, 'status' => 'Berjalan'],
            ['nama' => 'Pelatihan Kewirausahaan UMKM', 'progress' => 40, 'status' => 'Berjalan'],
            ['nama' => 'Pembuatan Sumur Bor Dusun 3', 'progress' => 0, 'status' => 'Belum Mulai'],
        ];

        return view('pages.transparansi', compact('settings', 'apbdes', 'tahun', 'tahunList', 'kependudukan', 'program', 'blt'));
    }
}
