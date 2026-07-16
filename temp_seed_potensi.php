<?php
use Illuminate\Support\Str;

// Clear table
\App\Models\Potensi::truncate();

$dummy = [
    [
        'judul' => 'Air Terjun Bidadari tersembunyi',
        'kategori' => 'wisata',
        'deskripsi' => 'Nikmati kesejukan alam yang belum terjamah. Air Terjun Bidadari menawarkan pemandangan memukau dengan tebing batu eksotis dan kolam alami yang menyegarkan. Sangat cocok untuk wisata keluarga dan pecinta alam.',
    ],
    [
        'judul' => 'Kerajinan Anyaman Bambu Lestari',
        'kategori' => 'umkm',
        'deskripsi' => 'Keranjang, tikar, dan hiasan rumah yang dianyam langsung oleh tangan-tangan terampil pengrajin desa. Menggunakan bambu pilihan yang kuat dan ramah lingkungan. Dapatkan harga khusus untuk pemesanan massal.',
    ],
    [
        'judul' => 'Kopi Robusta Asli Desa',
        'kategori' => 'umkm',
        'deskripsi' => 'Biji kopi pilihan yang dipetik langsung dari kebun warga di lereng bukit. Memiliki aroma khas dan rasa yang tebal. Dikemas modern siap seduh. Varian: Bubuk & Biji Sangrai (Roastbean).',
    ],
    [
        'judul' => 'Keripik Singkong Renyah Bu Ani',
        'kategori' => 'umkm',
        'deskripsi' => 'Camilan favorit khas desa! Renyah, gurih, dan bebas bahan pengawet. Tersedia dalam rasa Original, Balado, dan Jagung Bakar. Menerima pesanan kiloan.',
    ],
    [
        'judul' => 'Kain Tenun Tradisional',
        'kategori' => 'umkm',
        'deskripsi' => 'Kain tenun dengan motif khas desa kami. Proses pengerjaan 100% manual tanpa mesin (ATBM), pewarnaan alami. Elegan untuk dijadikan pakaian, selendang, atau pajangan dinding.',
    ],
    [
        'judul' => 'Perkebunan Kelapa Sawit Koperasi',
        'kategori' => 'pertanian',
        'deskripsi' => 'Desa kami mengelola puluhan hektar kebun kelapa sawit secara kolektif melalui koperasi desa. Memberikan kontribusi nyata terhadap PADes dan kesejahteraan para petani lokal.',
    ],
    [
        'judul' => 'Budidaya Ikan Nila Kolam Deras',
        'kategori' => 'pertanian',
        'deskripsi' => 'Memanfaatkan aliran sungai desa yang bersih, kelompok tani membudidayakan ikan Nila merah berkualitas tinggi. Siap menyuplai kebutuhan pasar dan rumah makan terdekat.',
    ],
    [
        'judul' => 'Pertanian Sayur Organik',
        'kategori' => 'pertanian',
        'deskripsi' => 'Bekerja sama dengan penyuluh pertanian, kami menanam sayur-sayuran sehat bebas pestisida kimia. Tomat, sawi, dan cabai merah selalu segar langsung dari kebun.',
    ],
    [
        'judul' => 'Festival Panen Raya Tahunan',
        'kategori' => 'budaya',
        'deskripsi' => 'Acara kebudayaan rutin setiap tahun yang diisi dengan arak-arakan hasil bumi, tarian daerah, dan pesta rakyat sebagai bentuk syukur atas hasil panen yang melimpah.',
    ]
];

foreach($dummy as $item) {
    \App\Models\Potensi::create([
        'judul' => $item['judul'],
        'slug' => Str::slug($item['judul'] . '-' . uniqid()),
        'kategori' => $item['kategori'],
        'deskripsi' => $item['deskripsi'],
        'gambar' => null, // fallback will be handled by blade
    ]);
}
echo "Berhasil mengisi data dummy Potensi\n";
