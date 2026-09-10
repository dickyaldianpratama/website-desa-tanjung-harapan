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

        // ---------------------------------------------------------
        // Fitur "Today in History" / Hari Peringatan Nasional & Internasional
        // ---------------------------------------------------------
        $today = date('m-d');
        $holidays = [
            '01-01' => ['name' => 'Tahun Baru Masehi', 'icon' => 'bi-calendar-event', 'color' => 'primary'],
            '01-10' => ['name' => 'Hari Gerakan Satu Juta Pohon', 'icon' => 'bi-tree', 'color' => 'success'],
            '02-21' => ['name' => 'Hari Peduli Sampah Nasional', 'icon' => 'bi-recycle', 'color' => 'success'],
            '02-28' => ['name' => 'Hari Gizi Nasional', 'icon' => 'bi-heart-pulse', 'color' => 'danger'],
            '03-08' => ['name' => 'Hari Perempuan Internasional', 'icon' => 'bi-gender-female', 'color' => 'info'],
            '03-22' => ['name' => 'Hari Air Sedunia', 'icon' => 'bi-droplet', 'color' => 'info'],
            '04-21' => ['name' => 'Hari Kartini', 'icon' => 'bi-person-hearts', 'color' => 'danger'],
            '04-22' => ['name' => 'Hari Bumi', 'icon' => 'bi-globe-americas', 'color' => 'success'],
            '04-25' => ['name' => 'Hari Otonomi Daerah', 'icon' => 'bi-building', 'color' => 'primary'],
            '05-01' => ['name' => 'Hari Buruh Internasional', 'icon' => 'bi-tools', 'color' => 'secondary'],
            '05-02' => ['name' => 'Hari Pendidikan Nasional', 'icon' => 'bi-book', 'color' => 'primary'],
            '05-20' => ['name' => 'Hari Kebangkitan Nasional', 'icon' => 'bi-flag', 'color' => 'danger'],
            '06-01' => ['name' => 'Hari Lahir Pancasila', 'icon' => 'bi-star-fill', 'color' => 'warning'],
            '06-05' => ['name' => 'Hari Lingkungan Hidup Sedunia', 'icon' => 'bi-globe-europe-africa', 'color' => 'success'],
            '07-12' => ['name' => 'Hari Koperasi Nasional', 'icon' => 'bi-people', 'color' => 'primary'],
            '07-23' => ['name' => 'Hari Anak Nasional', 'icon' => 'bi-emoji-smile', 'color' => 'warning'],
            '08-14' => ['name' => 'Hari Pramuka', 'icon' => 'bi-compass', 'color' => 'success'],
            '08-17' => ['name' => 'Hari Kemerdekaan Republik Indonesia', 'icon' => 'bi-flag-fill', 'color' => 'danger'],
            '09-09' => ['name' => 'Hari Olahraga Nasional', 'icon' => 'bi-bicycle', 'color' => 'primary'],
            '09-24' => ['name' => 'Hari Tani Nasional', 'icon' => 'bi-flower1', 'color' => 'success'],
            '10-01' => ['name' => 'Hari Kesaktian Pancasila', 'icon' => 'bi-shield-check', 'color' => 'danger'],
            '10-02' => ['name' => 'Hari Batik Nasional', 'icon' => 'bi-palette', 'color' => 'warning'],
            '10-28' => ['name' => 'Hari Sumpah Pemuda', 'icon' => 'bi-megaphone', 'color' => 'primary'],
            '11-10' => ['name' => 'Hari Pahlawan', 'icon' => 'bi-award', 'color' => 'danger'],
            '11-25' => ['name' => 'Hari Guru Nasional', 'icon' => 'bi-mortarboard', 'color' => 'primary'],
            '12-01' => ['name' => 'Hari AIDS Sedunia', 'icon' => 'bi-bandaid', 'color' => 'danger'],
            '12-22' => ['name' => 'Hari Ibu', 'icon' => 'bi-heart-fill', 'color' => 'danger'],
            // Testing fallback if today has no holiday (uncomment for testing)
            // date('m-d') => ['name' => 'Hari Uji Coba Sistem', 'icon' => 'bi-gear', 'color' => 'info'], 
        ];
        $specialDay = $holidays[$today] ?? null;

        return view('admin.dashboard', compact('totalBerita','totalPotensi','totalPerangkat','totalPengaduan','beritaTerbaru','pengaduanBaru', 'specialDay'));
    }
}
