@extends('layouts.app')
@section('title', $potensi->judul)

@push('styles')
<style>
    /* OVERRIDE NAVBAR */
    .navbar {
        background-color: var(--coklat-tua) !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    
    .article-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    .article-image {
        width: 100%;
        max-width: 100%;
        max-height: 500px;
        object-fit: contain;
        background-color: #f8f9fa;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .article-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #4b5563;
    }
    
    .contact-box {
        background: #F4F9F4;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid rgba(46, 125, 50, 0.2);
        margin-top: 3rem;
    }
</style>
@endpush

@section('content')

<div class="container mt-5 pt-5 mb-5" data-aos="fade-up">
    <div class="row justify-content-center">
        <div class="col-lg-8 mt-4">
            
            <!-- BREADCRUMB -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('potensi.index') }}" class="text-decoration-none text-muted">Potensi Desa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($potensi->judul, 30) }}</li>
                </ol>
            </nav>

            <div class="article-header">
                <span class="badge bg-gold text-dark mb-3 px-3 py-2 text-uppercase">
                    {{ $potensi->kategori }}
                </span>
                <h1 class="fw-bold mb-3" style="color: var(--teks-gelap);">{{ $potensi->judul }}</h1>
            </div>

            <!-- IMAGE -->
            @if($potensi->gambar && file_exists(public_path('images/potensi/'.$potensi->gambar)))
                <img src="{{ asset('images/potensi/'.$potensi->gambar) }}" alt="{{ $potensi->judul }}" class="article-image">
            @else
                <img src="{{ asset('images/hero-placeholder.jpg') }}" alt="{{ $potensi->judul }}" class="article-image">
            @endif

            <!-- CONTENT -->
            <div class="article-content">
                {!! nl2br(e($potensi->deskripsi)) !!}
            </div>

            <!-- CONTACT BOX (Khusus UMKM / Pertanian) -->
            @if(in_array($potensi->kategori, ['umkm', 'pertanian']))
            <div class="contact-box d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h5 class="fw-bold mb-1">Tertarik dengan potensi ini?</h5>
                    <p class="text-muted mb-0">Hubungi pengelola atau perangkat desa untuk informasi lebih lanjut.</p>
                </div>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['telepon'] ?? '6281234567890') }}?text=Halo%20Admin,%20saya%20ingin%20bertanya%20tentang%20Potensi%20Desa:%20{{ urlencode($potensi->judul) }}" target="_blank" class="btn btn-success fw-bold px-4 rounded-pill">
                    <i class="bi bi-whatsapp me-2"></i> Hubungi Sekarang
                </a>
            </div>
            @endif

            <!-- SHARE BUTTONS -->
            <div class="d-flex align-items-center gap-3 mt-5 pt-4 border-top">
                <span class="fw-bold">Bagikan:</span>
                <a href="https://api.whatsapp.com/send?text={{ urlencode($potensi->judul . ' - Baca selengkapnya di: ' . request()->url()) }}" target="_blank" class="btn btn-outline-success rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-whatsapp"></i>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-outline-primary rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-facebook"></i>
                </a>
            </div>

        </div>
    </div>
</div>

@endsection
