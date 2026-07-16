@extends('layouts.app')

@section('title', 'Berita & Pengumuman - ' . ($settings['nama_desa'] ?? 'Desa'))

@push('styles')
<style>
    /* OVERRIDE NAVBAR UNTUK HALAMAN BERITA */
    .navbar {
        background-color: var(--coklat-tua) !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    
    .kategori-wrapper {
        margin-top: 2rem;
    }
    .filter-btn {
        background: white;
        border: 1px solid rgba(61,31,10,0.1);
        color: var(--teks-gelap);
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .filter-btn:hover, .filter-btn.active {
        background: var(--gold);
        color: white;
        border-color: var(--gold);
    }

    /* KARTU BERITA PREMIUM */
    .news-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.08);
    }
    .news-img-wrap {
        position: relative;
        width: 100%;
        padding-top: 60%; /* Aspect Ratio */
        overflow: hidden;
    }
    .news-img-wrap img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .news-card:hover .news-img-wrap img {
        transform: scale(1.05);
    }
    
    /* MENGAMBANG POJOK KANAN BAWAH (Tanggal) */
    .news-date-badge {
        position: absolute;
        bottom: 0;
        right: 0;
        background: var(--hijau);
        color: white;
        padding: 10px 15px;
        border-top-left-radius: 12px;
        font-weight: 700;
        text-align: center;
        line-height: 1.2;
        z-index: 2;
    }
    .news-date-badge .day { font-size: 1.2rem; display: block; }
    .news-date-badge .month-year { font-size: 0.8rem; font-weight: 500; }

    .news-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .news-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--coklat-tua);
        margin-bottom: 0.75rem;
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .news-title:hover {
        color: var(--gold);
    }
    .news-excerpt {
        font-size: 0.9rem;
        color: var(--teks-abu);
        margin-bottom: 1.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex-grow: 1;
    }
    
    /* FOOTER KARTU */
    .news-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 1rem;
        border-top: 1px solid rgba(0,0,0,0.05);
        font-size: 0.85rem;
        color: var(--teks-abu);
    }
    .news-footer-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .news-footer-item i {
        color: var(--gold);
    }
</style>
@endpush

@section('content')

<section class="py-5 bg-cream">
    <div class="container mt-5 pt-4" data-aos="fade-up">
        <div class="text-center mb-5 mt-4">
            <span class="badge bg-gold text-dark mb-2 px-3 py-2"><i class="bi bi-newspaper me-1"></i> PUSAT INFORMASI</span>
            <h1 class="display-5 fw-bold" style="color: var(--teks-gelap);">Berita & Pengumuman</h1>
            <p class="text-muted">Informasi terbaru seputar kegiatan dan perkembangan {{ $settings['nama_desa'] ?? 'Desa' }}</p>
        </div>
        
        <!-- FILTER KATEGORI -->
        <div class="d-flex flex-wrap justify-content-center gap-2 mb-5 kategori-wrapper" data-aos="fade-up">
            <a href="{{ route('berita.index') }}" class="filter-btn {{ !$kategori ? 'active' : '' }}">Semua Berita</a>
            <a href="{{ route('berita.index', ['kategori' => 'berita']) }}" class="filter-btn {{ $kategori == 'berita' ? 'active' : '' }}">Berita</a>
            <a href="{{ route('berita.index', ['kategori' => 'pengumuman']) }}" class="filter-btn {{ $kategori == 'pengumuman' ? 'active' : '' }}">Pengumuman</a>
            <a href="{{ route('berita.index', ['kategori' => 'pembangunan']) }}" class="filter-btn {{ $kategori == 'pembangunan' ? 'active' : '' }}">Pembangunan</a>
            <a href="{{ route('berita.index', ['kategori' => 'kegiatan']) }}" class="filter-btn {{ $kategori == 'kegiatan' ? 'active' : '' }}">Kegiatan</a>
        </div>

        <!-- GRID BERITA -->
        <div class="row g-4">
            @forelse($beritas as $berita)
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="news-card">
                    <div class="news-img-wrap">
                        @if($berita->gambar && file_exists(public_path('images/berita/'.$berita->gambar)))
                            <img src="{{ asset('images/berita/'.$berita->gambar) }}" alt="{{ $berita->judul }}">
                        @else
                            @php $fallbackImg = 'berita' . (($berita->id % 3) + 1) . '.jpg'; @endphp
                            <img src="{{ asset('images/berita/' . $fallbackImg) }}" alt="{{ $berita->judul }}" onerror="this.src='{{ asset('images/hero-placeholder.jpg') }}'">
                        @endif
                        
                        <!-- DATE BADGE -->
                        <div class="news-date-badge">
                            <span class="day">{{ $berita->published_at ? $berita->published_at->format('d') : '-' }}</span>
                            <span class="month-year">{{ $berita->published_at ? $berita->published_at->translatedFormat('M Y') : '-' }}</span>
                        </div>
                    </div>
                    <div class="news-body">
                        <a href="{{ route('berita.show', $berita->slug) }}" class="news-title">{{ $berita->judul }}</a>
                        <p class="news-excerpt">{{ Str::limit(strip_tags($berita->isi), 120) }}</p>
                        
                        <div class="news-footer">
                            <div class="news-footer-item">
                                <i class="bi bi-person"></i> ADMIN DESA
                            </div>
                            <div class="news-footer-item">
                                <i class="bi bi-eye"></i> Dilihat {{ $berita->views }} kali
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-journal-x display-1 text-muted mb-3 d-block"></i>
                <h4 class="text-muted">Belum ada berita untuk kategori ini.</h4>
            </div>
            @endforelse
        </div>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-center mt-5">
            {{ $beritas->appends(['kategori' => $kategori])->links('pagination::bootstrap-5') }}
        </div>

    </div>
</section>

@endsection
