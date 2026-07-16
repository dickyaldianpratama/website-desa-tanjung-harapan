<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        
        DB::table('users')->insert([
            'name'       => 'Admin Desa',
            'email'      => 'admin.master_x7@desa.id',
            'password'   => Hash::make('Admin#Desa123!Secure'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        
        $settings = [
            ['key' => 'nama_desa',        'value' => 'Desa Nusantara'],
            ['key' => 'nama_kecamatan',   'value' => 'Kecamatan Sukamaju'],
            ['key' => 'nama_kabupaten',   'value' => 'Kabupaten Jawa Tengah'],
            ['key' => 'nama_provinsi',    'value' => 'Jawa Tengah'],
            ['key' => 'kode_pos',         'value' => '12345'],
            ['key' => 'alamat',           'value' => 'Jl. Raya Desa No. 1, Desa Nusantara'],
            ['key' => 'telepon',          'value' => '(0123) 456789'],
            ['key' => 'email',            'value' => 'info@desanusantara.id'],
            ['key' => 'website',          'value' => 'http://desanusantara.id'],
            ['key' => 'jam_pelayanan',    'value' => 'Senin - Jumat, 08.00 - 16.00 WIB'],
            ['key' => 'visi',             'value' => 'Terwujudnya Desa Nusantara yang Maju, Mandiri, dan Sejahtera Berlandaskan Nilai-nilai Kebersamaan.'],
            ['key' => 'misi',             'value' => "1. Meningkatkan kualitas pelayanan publik yang transparan dan akuntabel.\n2. Mendorong pertumbuhan ekonomi masyarakat melalui pemberdayaan UMKM.\n3. Mengembangkan potensi wisata dan budaya lokal desa.\n4. Meningkatkan kualitas infrastruktur dan fasilitas desa.\n5. Mewujudkan tata kelola pemerintahan desa yang baik dan bersih."],
            ['key' => 'sejarah',          'value' => 'Desa Nusantara merupakan desa yang berdiri sejak tahun 1945. Dengan kekayaan alam dan budaya yang dimilikinya, desa ini terus berkembang menjadi desa yang mandiri dan sejahtera.'],
            ['key' => 'sambutan_kades',   'value' => 'Selamat datang di Website Resmi Desa Nusantara. Melalui website ini, kami berkomitmen untuk memberikan informasi yang transparan dan akurat kepada seluruh masyarakat. Mari bersama-sama membangun desa kita tercinta menuju kemajuan yang berkelanjutan.'],
            ['key' => 'nama_kades',       'value' => 'H. Ahmad Suryadi, S.E.'],
            ['key' => 'jabatan_kades',    'value' => 'Kepala Desa Nusantara'],
            ['key' => 'jumlah_penduduk',  'value' => '2.450'],
            ['key' => 'jumlah_kk',        'value' => '745'],
            ['key' => 'jumlah_rw',        'value' => '5'],
            ['key' => 'jumlah_rt',        'value' => '18'],
            ['key' => 'luas_wilayah',     'value' => '12,5 Ha'],
            ['key' => 'maps_embed',       'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.51865068861!2d106.6894572!3d-6.2297468!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x5371bf0fdad786a2!2sJakarta!5e0!3m2!1sid!2sid!4v1625000000000!5m2!1sid!2sid'],
            ['key' => 'facebook',         'value' => '#'],
            ['key' => 'instagram',        'value' => '#'],
            ['key' => 'youtube',          'value' => '#'],
            ['key' => 'foto_kades',       'value' => ''],
            ['key' => 'logo_desa',        'value' => ''],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->insert(array_merge($setting, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Sliders
        $sliders = [
            ['judul' => 'Selamat Datang di Desa Nusantara', 'subtitle' => 'Sumber informasi resmi pemerintahan desa', 'gambar' => 'slider1.jpg', 'urutan' => 1],
            ['judul' => 'Potensi Wisata Alam', 'subtitle' => 'Keindahan alam yang memukau di Desa Nusantara', 'gambar' => 'slider2.jpg', 'urutan' => 2],
            ['judul' => 'Menuju Desa Digital', 'subtitle' => 'Transformasi pelayanan publik yang modern dan transparan', 'gambar' => 'slider3.jpg', 'urutan' => 3],
        ];
        foreach ($sliders as $slider) {
            DB::table('sliders')->insert(array_merge($slider, ['aktif' => true, 'created_at' => now(), 'updated_at' => now()]));
        }

        // Perangkat desa
        $perangkats = [
            ['nama' => 'H. Ahmad Suryadi, S.E.',   'jabatan' => 'Kepala Desa',          'urutan' => 1],
            ['nama' => 'Siti Rahayu, S.Sos.',      'jabatan' => 'Sekretaris Desa',      'urutan' => 2],
            ['nama' => 'Budi Santoso',              'jabatan' => 'Kaur Keuangan',        'urutan' => 3],
            ['nama' => 'Dewi Kurniawati',           'jabatan' => 'Kaur Perencanaan',     'urutan' => 4],
            ['nama' => 'Eko Prasetyo',              'jabatan' => 'Kasi Pemerintahan',    'urutan' => 5],
            ['nama' => 'Fitri Handayani',           'jabatan' => 'Kasi Kesejahteraan',   'urutan' => 6],
            ['nama' => 'Gunawan Wibowo',            'jabatan' => 'Kasi Pelayanan',       'urutan' => 7],
            ['nama' => 'Hendra Kusuma',             'jabatan' => 'Kadus Dusun I',        'urutan' => 8],
            ['nama' => 'Indah Permata',             'jabatan' => 'Kadus Dusun II',       'urutan' => 9],
        ];
        foreach ($perangkats as $perangkat) {
            DB::table('perangkats')->insert(array_merge($perangkat, ['foto' => null, 'nip' => null, 'created_at' => now(), 'updated_at' => now()]));
        }

        // Berita
        $beritas = [
            [
                'judul'        => 'Musyawarah Desa Penetapan APBDes Tahun 2025',
                'slug'         => 'musyawarah-desa-penetapan-apbdes-2025',
                'isi'          => '<p>Pemerintah Desa Nusantara telah menyelenggarakan Musyawarah Desa (Musdes) dalam rangka penetapan Anggaran Pendapatan dan Belanja Desa (APBDes) Tahun Anggaran 2025. Kegiatan ini dihadiri oleh seluruh perangkat desa, BPD, tokoh masyarakat, dan perwakilan warga.</p><p>Dalam musyawarah tersebut, telah disepakati berbagai program pembangunan yang akan dilaksanakan sepanjang tahun 2025 demi kemajuan dan kesejahteraan masyarakat desa.</p>',
                'kategori'     => 'kegiatan',
                'status'       => 'publish',
                'published_at' => now()->subDays(2),
            ],
            [
                'judul'        => 'Pengumuman: Pendaftaran BLT Dana Desa 2025',
                'slug'         => 'pengumuman-pendaftaran-blt-dana-desa-2025',
                'isi'          => '<p>Diberitahukan kepada seluruh warga Desa Nusantara bahwa pendaftaran Bantuan Langsung Tunai (BLT) Dana Desa Tahun 2025 akan dibuka mulai tanggal 15 Januari 2025.</p><p>Warga yang memenuhi syarat dapat mendaftarkan diri ke kantor desa dengan membawa KTP dan KK. Informasi lebih lanjut dapat menghubungi kantor desa pada jam pelayanan.</p>',
                'kategori'     => 'pengumuman',
                'status'       => 'publish',
                'published_at' => now()->subDays(5),
            ],
            [
                'judul'        => 'Pembangunan Jalan Desa Sepanjang 2 KM Dimulai',
                'slug'         => 'pembangunan-jalan-desa-sepanjang-2-km',
                'isi'          => '<p>Pemerintah Desa Nusantara memulai proyek pembangunan jalan desa sepanjang 2 kilometer yang menghubungkan Dusun I dan Dusun II. Proyek ini merupakan bagian dari program pembangunan infrastruktur yang telah direncanakan dalam APBDes 2025.</p><p>Diharapkan pembangunan ini dapat memperlancar akses masyarakat dan mendukung perekonomian warga desa.</p>',
                'kategori'     => 'pembangunan',
                'status'       => 'publish',
                'published_at' => now()->subDays(7),
            ],
        ];
        foreach ($beritas as $berita) {
            DB::table('beritas')->insert(array_merge($berita, ['gambar' => null, 'created_at' => now(), 'updated_at' => now()]));
        }

        // Potensi desa
        $potensis = [
            ['judul' => 'Wisata Alam Sungai Bening', 'slug' => 'wisata-alam-sungai-bening', 'deskripsi' => 'Sungai Bening merupakan destinasi wisata alam yang memukau dengan air jernih dan pemandangan alam yang asri. Cocok untuk keluarga yang ingin menikmati alam terbuka.', 'kategori' => 'wisata'],
            ['judul' => 'Kerajinan Anyaman Bambu', 'slug' => 'kerajinan-anyaman-bambu', 'deskripsi' => 'Produk unggulan UMKM Desa Nusantara berupa kerajinan anyaman bambu berkualitas tinggi. Dipasarkan hingga ke luar daerah dan menjadi sumber penghasilan utama warga.', 'kategori' => 'umkm'],
            ['judul' => 'Lahan Pertanian Organik', 'slug' => 'pertanian-organik-desa', 'deskripsi' => 'Desa Nusantara memiliki lahan pertanian organik seluas 50 hektar yang menghasilkan berbagai komoditas unggulan seperti padi, sayuran, dan buah-buahan organik.', 'kategori' => 'pertanian'],
        ];
        foreach ($potensis as $potensi) {
            DB::table('potensis')->insert(array_merge($potensi, ['gambar' => null, 'created_at' => now(), 'updated_at' => now()]));
        }

        // APBDes
        $apbdes = [
            ['tahun' => 2025, 'uraian' => 'Dana Desa',                 'jenis' => 'pendapatan', 'anggaran' => 850000000, 'realisasi' => 850000000],
            ['tahun' => 2025, 'uraian' => 'Alokasi Dana Desa (ADD)',   'jenis' => 'pendapatan', 'anggaran' => 350000000, 'realisasi' => 320000000],
            ['tahun' => 2025, 'uraian' => 'PAD Desa',                  'jenis' => 'pendapatan', 'anggaran' => 50000000,  'realisasi' => 45000000],
            ['tahun' => 2025, 'uraian' => 'Belanja Pembangunan',       'jenis' => 'belanja',    'anggaran' => 700000000, 'realisasi' => 650000000],
            ['tahun' => 2025, 'uraian' => 'Belanja Pemberdayaan',      'jenis' => 'belanja',    'anggaran' => 200000000, 'realisasi' => 180000000],
            ['tahun' => 2025, 'uraian' => 'Belanja Penyelenggaraan',   'jenis' => 'belanja',    'anggaran' => 250000000, 'realisasi' => 230000000],
            ['tahun' => 2025, 'uraian' => 'Belanja Penanggulangan',    'jenis' => 'belanja',    'anggaran' => 100000000, 'realisasi' => 95000000],
        ];
        foreach ($apbdes as $item) {
            DB::table('apbdes')->insert(array_merge($item, ['created_at' => now(), 'updated_at' => now()]));
        }
    }
}
