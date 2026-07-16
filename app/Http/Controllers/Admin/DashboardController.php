<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Pengaduan;
use App\Models\Perangkat;
use App\Models\Potensi;
class DashboardController extends Controller {
    public function index() {
        $totalBerita    = Berita::count();
        $totalPotensi   = Potensi::count();
        $totalPerangkat = Perangkat::count();
        $totalPengaduan = Pengaduan::where('status','baru')->count();
        $beritaTerbaru  = Berita::latest()->take(5)->get();
        $pengaduanBaru  = Pengaduan::where('status','baru')->latest()->take(5)->get();
        return view('admin.dashboard', compact('totalBerita','totalPotensi','totalPerangkat','totalPengaduan','beritaTerbaru','pengaduanBaru'));
    }
}
