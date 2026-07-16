<?php

// Update Pertanian
\App\Models\Potensi::where('judul', 'like', '%Sawit%')->update(['gambar' => 'tani1.jpg']);
\App\Models\Potensi::where('judul', 'like', '%Ikan Nila%')->update(['gambar' => 'tani2.jpg']);
\App\Models\Potensi::where('judul', 'like', '%Sayur%')->update(['gambar' => 'tani3.jpg']);

echo "Berhasil menghubungkan gambar pertanian ke database\n";
