<?php

// Update Wisata
\App\Models\Potensi::where('judul', 'like', '%Air Terjun%')->update(['gambar' => 'wisata1.jpg']);
\App\Models\Potensi::where('judul', 'like', '%Festival%')->update(['gambar' => 'wisata2.jpg']);

// Update UMKM
\App\Models\Potensi::where('judul', 'like', '%Anyaman%')->update(['gambar' => 'umkm1.jpg']);
\App\Models\Potensi::where('judul', 'like', '%Kopi%')->update(['gambar' => 'umkm2.jpg']);
\App\Models\Potensi::where('judul', 'like', '%Keripik%')->update(['gambar' => 'umkm3.jpg']);
\App\Models\Potensi::where('judul', 'like', '%Tenun%')->update(['gambar' => 'umkm4.jpg']);

echo "Berhasil menghubungkan gambar ke database\n";
