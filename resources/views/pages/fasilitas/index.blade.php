@extends('layouts.app')
@section('title', 'Fasilitas Desa')

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
</style>
@endpush

@section('content')

<div class="page-header text-center">
    <div class="container position-relative" style="z-index: 1;">
        <h1 class="fw-bold mb-3">Fasilitas Desa</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fasilitas</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5 my-3">
    <!-- Filter Section -->
    <div class="row mb-5">
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
            <div class="fasilitas-item" data-category="{{ Str::slug($item->kategori) }}">
                <div class="fasilitas-card">
                    @if($item->foto)
                        <img src="{{ Storage::disk('s3')->url('images/fasilitas/' . $item->foto) }}" alt="{{ $item->nama_fasilitas }}" loading="lazy">
                    @else
                        <!-- Placeholder jika foto kosong (meski diwajibkan) -->
                        <div class="w-100 h-100 bg-secondary d-flex align-items-center justify-content-center">
                            <i class="bi bi-building fs-1 text-light"></i>
                        </div>
                    @endif
                    
                    <div class="fasilitas-overlay">
                        <span class="fasilitas-kategori">{{ $item->kategori }}</span>
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

@endsection

@push('scripts')
<script>
    // Simple Filtering Script
    document.addEventListener("DOMContentLoaded", function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const items = document.querySelectorAll('.fasilitas-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all
                filterBtns.forEach(b => b.classList.remove('active'));
                // Add active class to clicked
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
</script>
@endpush
