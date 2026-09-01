@extends('layouts.app')
@section('title', 'Potensi Desa')

@push('styles')
<style>
    /* OVERRIDE NAVBAR */
    .navbar {
        background-color: var(--coklat-tua) !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    /* SECTION TITLE */
    .section-title {
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
        margin-bottom: 2rem;
    }
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: var(--gold);
        border-radius: 3px;
    }

    /* WISATA CARDS (Large Horizontal) */
    .wisata-card {
        background: var(--putih);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
        margin-bottom: 2rem;
        display: flex;
        flex-direction: column;
    }
    @media (min-width: 992px) {
        .wisata-card { flex-direction: row; }
    }
    .wisata-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .wisata-img-wrap {
        position: relative;
        flex: 1;
        min-height: 250px;
    }
    @media (min-width: 992px) {
        .wisata-img-wrap { max-width: 50%; }
    }
    .wisata-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0; left: 0;
    }
    .wisata-body {
        flex: 1;
        padding: 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    /* UMKM CARDS (Product Grid) */
    .umkm-card {
        background: var(--putih);
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .umkm-card:hover {
        border-color: var(--gold);
        box-shadow: 0 10px 25px rgba(201, 150, 58, 0.15);
    }
    .umkm-img-wrap {
        position: relative;
        padding-top: 100%; /* 1:1 Aspect Ratio */
        background: #f8f9fa;
    }
    .umkm-img-wrap img {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        object-fit: cover;
    }
    .umkm-body {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .btn-whatsapp {
        background-color: #25D366;
        color: white;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-whatsapp:hover {
        background-color: #128C7E;
        color: white;
    }

    /* PERTANIAN CARDS (Vertical Info) */
    .tani-card {
        background: #F4F9F4; /* Light green tint */
        border-radius: 16px;
        padding: 2rem;
        height: 100%;
        border: 1px solid rgba(46, 125, 50, 0.1);
        transition: transform 0.3s ease;
    }
    .tani-card:hover {
        transform: translateY(-5px);
        background: #E8F5E9;
    }
    .tani-icon {
        width: 60px; height: 60px;
        background: #2E7D32;
        color: white;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 1.5rem;
    }
</style>
@endpush

@section('content')

<!-- PAGE HEADER -->
<div class="container mt-5 pt-5" data-aos="fade-up">
    <div class="text-center mb-5 mt-4">
        <span class="badge bg-gold text-dark mb-2 px-3 py-2"><i class="bi bi-stars me-1"></i> KEKAYAAN DESA</span>
        <h1 class="display-5 fw-bold" style="color: var(--teks-gelap);">Potensi Desa</h1>
        <p class="text-muted">Menjelajahi kekayaan alam, budaya, dan kreativitas warga {{ $settings['nama_desa'] ?? 'Desa' }}</p>
    </div>
</div>

<section class="py-5 bg-cream">
    <div class="container py-4">

        @forelse($groupedPotensi as $kategori => $items)
        <div class="mb-5 pb-3">
            <h2 class="fw-bold section-title text-capitalize" data-aos="fade-right">{{ $kategori }}</h2>
            <div class="row g-4 mt-2">
                @foreach($items as $item)
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="tani-card" style="background:var(--putih); padding:1.5rem; border-radius:12px; border:1px solid rgba(0,0,0,0.08); height:100%; display:flex; flex-direction:column; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                        <div class="tani-img-wrap mb-3" style="height: 200px; border-radius: 12px; overflow: hidden; position:relative;">
                            @if($item->gambar)
                                <img src="{{ Storage::disk('s3')->url('images/potensi/' . $item->gambar) }}" alt="{{ $item->judul }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/hero-placeholder.jpg') }}" alt="{{ $item->judul }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @endif
                        </div>
                        <h4 class="fw-bold mb-3">{{ $item->judul }}</h4>
                        <p class="text-muted mb-4" style="flex-grow:1;">{{ Str::limit(strip_tags($item->deskripsi), 120) }}</p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('potensi.show', $item->slug) }}" class="btn btn-outline-dark flex-grow-1">Selengkapnya</a>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['telepon'] ?? '6281234567890') }}?text=Halo%20Admin,%20saya%20tertarik%20dengan%20Potensi%20Desa:%20{{ urlencode($item->judul) }}" target="_blank" class="btn btn-success px-3" title="Hubungi">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-folder-x display-1 text-muted mb-3 d-block"></i>
            <h4 class="text-muted">Belum ada data potensi desa.</h4>
        </div>
        @endforelse

    </div>
</section>

@endsection
