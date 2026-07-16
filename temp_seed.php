<?php
for($i = 1; $i <= 6; $i++) {
    $kategori = ['berita', 'pengumuman', 'pembangunan'][array_rand(['berita', 'pengumuman', 'pembangunan'])];
    \App\Models\Berita::create([
        'judul' => 'Berita Tambahan ' . $i . ' untuk Uji Coba Layout',
        'slug' => \Illuminate\Support\Str::slug('Berita Tambahan ' . $i . ' untuk Uji Coba Layout-' . uniqid()),
        'kategori' => $kategori,
        'isi' => '<p>Ini adalah konten berita tambahan otomatis untuk melihat bagaimana susunan kartu berita dan sistem halaman (pagination) bekerja ketika jumlah berita bertambah banyak.</p><p>Website ini secara cerdas akan menyusunnya ke dalam baris-baris yang rapi dan memotongnya menjadi beberapa halaman jika terlalu panjang.</p>',
        'gambar' => null,
        'status' => 'publish',
        'published_at' => now()->subDays($i),
        'views' => rand(10, 100)
    ]);
}
echo "Berhasil tambah 6 berita\n";
