@extends('layouts.app')
@section('title', 'Fasilitas Desa')

@php
    if(!function_exists('getFasilitasIcon')) {
        function getFasilitasIcon($kat) {
            $kat = strtolower($kat);
            if (str_contains($kat, 'pendidikan') || str_contains($kat, 'sekolah')) return 'bi-mortarboard-fill';
            if (str_contains($kat, 'kesehatan') || str_contains($kat, 'puskesmas') || str_contains($kat, 'posyandu')) return 'bi-heart-pulse-fill';
            if (str_contains($kat, 'ibadah') || str_contains($kat, 'masjid') || str_contains($kat, 'mushola')) return 'bi-moon-stars-fill';
            if (str_contains($kat, 'olahraga') || str_contains($kat, 'lapangan')) return 'bi-trophy-fill';
            if (str_contains($kat, 'kantor') || str_contains($kat, 'desa')) return 'bi-building-fill';
            return 'bi-geo-alt-fill';
        }
    }
@endphp

@push('styles')
<style>
    /* Styling modern untuk Filter dan Grid Fasilitas */
    .filter-btn {
        background: transparent;
        border: 1px solid var(--gold);
        color: var(--coklat-tua);
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        margin: 0.25rem;
    }
    .filter-btn:hover, .filter-btn.active {
        background: var(--gold);
        color: #fff;
    }

    .fasilitas-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .fasilitas-card {
        border-radius: 16px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: all 0.4s ease;
        background: #fff;
        height: 320px;
        cursor: pointer;
    }
    .fasilitas-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    .fasilitas-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }
    .fasilitas-card:hover img {
        transform: scale(1.08);
    }

    /* Glassmorphism Overlay */
    .fasilitas-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(44, 21, 7, 0.9) 0%, rgba(44, 21, 7, 0.4) 60%, transparent 100%);
        padding: 2rem 1.5rem 1.5rem;
        color: #fff;
        transform: translateY(30%); /* Sembunyikan sebagian deskripsi */
        transition: transform 0.4s ease;
    }
    .fasilitas-card:hover .fasilitas-overlay {
        transform: translateY(0);
        background: linear-gradient(to top, rgba(44, 21, 7, 0.95) 0%, rgba(44, 21, 7, 0.7) 100%);
        backdrop-filter: blur(4px);
    }

    .fasilitas-kategori {
        background: var(--gold);
        color: var(--coklat-tua);
        font-size: 0.75rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        display: inline-block;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .fasilitas-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1.3;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }
    .fasilitas-desc {
        font-size: 0.85rem;
        color: rgba(255,255,255,0.8);
        opacity: 0;
        transition: opacity 0.4s ease;
        transition-delay: 0.1s;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .fasilitas-card:hover .fasilitas-desc {
        opacity: 1;
    }

    /* Hide element class for filtering */
    .fasilitas-item.hide {
        display: none;
    }
    
    /* Animasi Zoom In Modal Khusus Fasilitas */
    .modal.fade .modal-dialog.modal-zoom {
        transform: scale(0.8);
        transition: transform 0.3s ease-out, opacity 0.3s ease-out;
        opacity: 0;
    }
    .modal.show .modal-dialog.modal-zoom {
        transform: scale(1);
        opacity: 1;
    }
    .btn-close-custom {
        background-color: rgba(255,255,255,0.9);
        border-radius: 50%;
        padding: 0.6rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        transition: all 0.2s ease;
    }
    .btn-close-custom:hover {
        background-color: #fff;
        transform: scale(1.1);
    }
</style>
@endpush

@section('content')

<!-- Memberikan jarak dari navbar -->
<div class="container" style="margin-top: 130px; margin-bottom: 80px;">
    <!-- Filter Section -->
    <div class="row mb-5" data-aos="fade-down">
        <div class="col-12 text-center">
            <h2 class="font-serif fw-bold text-coklat-tua mb-4">Eksplorasi Fasilitas Kami</h2>
            <div id="fasilitas-filters" class="d-flex flex-wrap justify-content-center">
                <button class="filter-btn active" data-filter="all">Semua Fasilitas</button>
                @foreach($kategoriList as $kat)
                    <button class="filter-btn" data-filter="{{ Str::slug($kat) }}">{{ $kat }}</button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Grid Section -->
    <div class="fasilitas-grid" id="fasilitas-container">
        @forelse($fasilitas as $item)
            <div class="fasilitas-item" data-category="{{ Str::slug($item->kategori) }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <!-- Ditambahkan attribut data-* untuk JS Modal -->
                <div class="fasilitas-card" 
                     data-nama="{{ $item->nama_fasilitas }}"
                     data-kategori="{{ $item->kategori }}"
                     data-deskripsi="{{ $item->deskripsi }}"
                     data-foto="{{ $item->foto ? Storage::disk('s3')->url('images/fasilitas/' . $item->foto) : '' }}"
                     onclick="openFasilitasModal(this)">
                     
                    @if($item->foto)
                        <img src="{{ Storage::disk('s3')->url('images/fasilitas/' . $item->foto) }}" alt="{{ $item->nama_fasilitas }}" loading="lazy">
                    @else
                        <!-- Placeholder jika foto kosong -->
                        <div class="w-100 h-100 bg-secondary d-flex align-items-center justify-content-center">
                            <i class="bi bi-building fs-1 text-light"></i>
                        </div>
                    @endif
                    
                    <div class="fasilitas-overlay">
                        <span class="fasilitas-kategori">
                            <i class="{{ getFasilitasIcon($item->kategori) }} me-1"></i> {{ $item->kategori }}
                        </span>
                        <h4 class="fasilitas-title font-serif">{{ $item->nama_fasilitas }}</h4>
                        @if($item->deskripsi)
                            <div class="fasilitas-desc">
                                {{ $item->deskripsi }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                <h5 class="text-muted">Belum ada data fasilitas yang ditambahkan.</h5>
            </div>
        @endforelse
    </div>
</div>

<!-- Modal Zoom In Detail Fasilitas -->
<div class="modal fade" id="fasilitasModal" tabindex="-1" aria-labelledby="modalNama" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-zoom mx-4 mx-sm-auto" style="max-width: 500px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden; background: #faf9f6;">
            
            <!-- Tombol Close (Silang) menumpuk di atas gambar -->
            <button type="button" class="btn-close btn-close-custom position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="z-index: 10;"></button>
            
            <div class="position-relative">
                <!-- Gambar Fasilitas (Zoomed) -->
                <img id="modalFoto" src="" alt="Foto Fasilitas" class="d-none" style="width: 100%; height: 280px; object-fit: cover; border-bottom: 3px solid var(--gold);">
                
                <!-- Placeholder jika tidak ada gambar -->
                <div id="modalFotoPlaceholder" class="bg-secondary d-none align-items-center justify-content-center" style="width: 100%; height: 280px; border-bottom: 3px solid var(--gold);">
                    <i class="bi bi-building" style="font-size: 4rem; color: rgba(255,255,255,0.7);"></i>
                </div>
                
                <!-- Badge Kategori Overlapping (Melayang di antara gambar & teks) -->
                <div class="position-absolute w-100 text-center" style="bottom: -16px; left: 0;">
                    <span class="px-4 py-2 rounded-pill shadow" style="background-color: #C9963A; color: #3D1F0A; font-size: 0.85rem; border: 2px solid #fff; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                        <i id="modalKategoriIcon" class="bi me-1"></i> <span id="modalKategori"></span>
                    </span>
                </div>
            </div>
            
            <!-- Detail Teks -->
            <div class="modal-body px-4 pb-4 pt-5">
                <div class="text-center mb-4">
                    <h3 id="modalNama" class="fw-bold text-coklat-tua mb-2 font-serif"></h3>
                    <div style="width: 50px; height: 3px; background: var(--gold); margin: 0 auto; border-radius: 50px;"></div>
                </div>
                
                <div class="p-3 p-md-4 rounded-4 position-relative overflow-hidden" style="background: linear-gradient(145deg, rgba(255,255,255,0.85), rgba(253,251,247,0.85)); backdrop-filter: blur(10px); border: 1px solid rgba(201, 150, 58, 0.3); box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
                    
                    <!-- Watermark Logo Desa -->
                    <img src="{{ asset('images/logo_desa.png') }}" alt="Watermark" class="position-absolute top-50 start-50 translate-middle" style="width: 150px; opacity: 0.1; pointer-events: none; z-index: 0;">

                    <div class="position-relative" style="z-index: 1;">
                        <div class="d-flex align-items-center mb-3 pb-2" style="border-bottom: 1px dashed rgba(201, 150, 58, 0.3);">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px; background-color: rgba(201, 150, 58, 0.15); color: #C9963A;">
                                <i class="bi bi-info-circle-fill fs-5"></i>
                            </div>
                            <h6 class="fw-bold mb-0 text-coklat-tua" style="letter-spacing: 0.5px;">Tentang Fasilitas</h6>
                        </div>
                        <p id="modalDeskripsi" class="text-secondary mb-0" style="line-height: 1.8; font-size: 0.95rem; text-align: justify; font-weight: 500;"></p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // 1. Script Filter Kategori
    document.addEventListener("DOMContentLoaded", function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const items = document.querySelectorAll('.fasilitas-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filterValue = this.getAttribute('data-filter');

                items.forEach(item => {
                    if (filterValue === 'all') {
                        item.classList.remove('hide');
                    } else {
                        if (item.getAttribute('data-category') === filterValue) {
                            item.classList.remove('hide');
                        } else {
                            item.classList.add('hide');
                        }
                    }
                });
            });
        });
    });

    // 2. Script Buka Modal Detail (Zoom-in)
    function openFasilitasModal(element) {
        // Ambil data dari atribut element yang diklik
        const nama = element.getAttribute('data-nama');
        const kategori = element.getAttribute('data-kategori');
        const deskripsi = element.getAttribute('data-deskripsi');
        const foto = element.getAttribute('data-foto');

        // Logic untuk mendapatkan icon class berdasarkan nama kategori (seragam dengan PHP helper)
        let iconClass = 'bi-geo-alt-fill';
        const katLower = kategori.toLowerCase();
        if (katLower.includes('pendidikan') || katLower.includes('sekolah')) iconClass = 'bi-mortarboard-fill';
        else if (katLower.includes('kesehatan') || katLower.includes('puskesmas') || katLower.includes('posyandu')) iconClass = 'bi-heart-pulse-fill';
        else if (katLower.includes('ibadah') || katLower.includes('masjid') || katLower.includes('mushola')) iconClass = 'bi-moon-stars-fill';
        else if (katLower.includes('olahraga') || katLower.includes('lapangan')) iconClass = 'bi-trophy-fill';
        else if (katLower.includes('kantor') || katLower.includes('desa')) iconClass = 'bi-building-fill';

        // Isi konten modal
        document.getElementById('modalNama').innerText = nama;
        document.getElementById('modalKategori').innerText = kategori;
        document.getElementById('modalKategoriIcon').className = 'bi ' + iconClass + ' me-1';
        document.getElementById('modalDeskripsi').innerText = deskripsi ? deskripsi : 'Tidak ada deskripsi/informasi tambahan untuk fasilitas ini.';

        const imgEl = document.getElementById('modalFoto');
        const placeholder = document.getElementById('modalFotoPlaceholder');

        // Mengatur tampilan gambar vs placeholder dengan class d-none / d-flex
        if (foto && foto.trim() !== '') {
            imgEl.src = foto;
            imgEl.classList.remove('d-none');
            
            placeholder.classList.remove('d-flex');
            placeholder.classList.add('d-none');
        } else {
            imgEl.classList.add('d-none');
            
            placeholder.classList.remove('d-none');
            placeholder.classList.add('d-flex');
        }

        // Tampilkan Modal Bootstrap
        const modalElement = document.getElementById('fasilitasModal');
        const modalInstance = new bootstrap.Modal(modalElement);
        modalInstance.show();
    }
</script>
@endpush
