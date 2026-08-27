<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HolidayTheme;
use Carbon\Carbon;

class HolidayThemeSeeder extends Seeder
{
    /**
     * 5 template tema hari besar siap pakai.
     * Admin bisa mengaktifkan, mengedit tanggal, dan memodifikasi warna sesuai kebutuhan.
     */
    public function run(): void
    {
        $currentYear = Carbon::now()->year;

        $themes = [
            [
                'nama'           => 'Hari Kemerdekaan Republik Indonesia',
                'emoji'          => '🇮🇩',
                'teks_banner'    => "🇮🇩 Dirgahayu Republik Indonesia ke-" . ($currentYear - 1945) . "! Merdeka!",
                'tanggal_mulai'  => "$currentYear-08-14",
                'tanggal_selesai'=> "$currentYear-08-17",
                'warna_primer'   => '#8B0000',   // Merah gelap
                'warna_sekunder' => '#CC0000',   // Merah terang
                'warna_aksen'    => '#FFD700',   // Kuning emas bendera
                'gaya_ornamen'   => 'konfeti',
                'is_active'      => false,
                'prioritas'      => 10,
            ],
            [
                'nama'           => 'Hari Raya Idul Fitri',
                'emoji'          => '🌙',
                'teks_banner'    => '🌙 Selamat Hari Raya Idul Fitri 1 Syawal! Mohon Maaf Lahir dan Batin 🤲',
                'tanggal_mulai'  => "$currentYear-03-30",
                'tanggal_selesai'=> "$currentYear-04-07",
                'warna_primer'   => '#1A5C38',   // Hijau tua islami
                'warna_sekunder' => '#2D7B4F',   // Hijau medium
                'warna_aksen'    => '#F0C040',   // Kuning emas
                'gaya_ornamen'   => 'gelembung',
                'is_active'      => false,
                'prioritas'      => 9,
            ],
            [
                'nama'           => 'Maulid Nabi Muhammad SAW',
                'emoji'          => '🕌',
                'teks_banner'    => '🕌 Selamat Hari Maulid Nabi Muhammad SAW. Semoga kita senantiasa meneladani beliau. ☪️',
                'tanggal_mulai'  => "$currentYear-09-04",
                'tanggal_selesai'=> "$currentYear-09-05",
                'warna_primer'   => '#1A3A5C',   // Biru tua islami
                'warna_sekunder' => '#1F5080',   // Biru medium
                'warna_aksen'    => '#C8A92B',   // Emas kecoklatan
                'gaya_ornamen'   => 'none',
                'is_active'      => false,
                'prioritas'      => 8,
            ],
            [
                'nama'           => 'Hari Raya Idul Adha',
                'emoji'          => '🐑',
                'teks_banner'    => '🐑 Selamat Hari Raya Idul Adha! Semoga ibadah qurban kita diterima Allah SWT 🤲',
                'tanggal_mulai'  => "$currentYear-06-06",
                'tanggal_selesai'=> "$currentYear-06-08",
                'warna_primer'   => '#2D5016',   // Hijau tua
                'warna_sekunder' => '#4A7C25',   // Hijau medium
                'warna_aksen'    => '#E8A020',   // Oranye emas
                'gaya_ornamen'   => 'none',
                'is_active'      => false,
                'prioritas'      => 9,
            ],
            [
                'nama'           => 'Tahun Baru Masehi',
                'emoji'          => '🎆',
                'teks_banner'    => '🎆 Selamat Tahun Baru ' . ($currentYear + 1) . '! Semoga desa kita semakin maju dan sejahtera! 🎉',
                'tanggal_mulai'  => "$currentYear-12-31",
                'tanggal_selesai'=> ($currentYear + 1) . "-01-01",
                'warna_primer'   => '#2C0B5E',   // Ungu tua
                'warna_sekunder' => '#4A1980',   // Ungu medium
                'warna_aksen'    => '#FF6B35',   // Oranye meriah
                'gaya_ornamen'   => 'konfeti',
                'is_active'      => false,
                'prioritas'      => 7,
            ],
        ];

        foreach ($themes as $theme) {
            // Jangan duplikat jika seeder dijalankan ulang
            HolidayTheme::firstOrCreate(
                ['nama' => $theme['nama']],
                $theme
            );
        }
    }
}
