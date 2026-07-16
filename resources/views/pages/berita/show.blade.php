@extends('layouts.app')

@section('title', $berita->judul . ' - ' . ($settings['nama_desa'] ?? 'Desa'))

@push('styles')
<style>
    /* BREADCRUMBS */
    .breadcrumb-custom {
        padding: 2rem 0;
        margin: 0;
        background: transparent;
    }
    .breadcrumb-custom a {
        color: var(--coklat-tua);
        text-decoration: none;
        font-weight: 500;
    }
    .breadcrumb-custom a:hover {
        color: var(--gold);
    }
    .breadcrumb-custom .separator {
        margin: 0 0.5rem;
        color: var(--teks-abu);
    }
    .breadcrumb-custom .active {
        color: var(--teks-abu);
    }

    /* BERITA DETAIL */
    .article-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--coklat-tua);
        margin-bottom: 1rem;
        line-height: 1.3;
    }
    .article-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        color: var(--teks-abu);
        font-size: 0.95rem;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .article-meta-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .article-meta-item i {
        color: var(--gold);
        font-size: 1.1rem;
    }
    .article-image {
        width: 100%;
        max-width: 100%;
        max-height: 500px;
        object-fit: contain;
        background-color: #f8f9fa; /* Latar belakang abu-abu muda jika gambar tidak memenuhi lebar penuh */
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .article-content {
        font-size: 1.05rem;
        line-height: 1.8;
        color: var(--teks-gelap);
    }
    .article-content p {
        margin-bottom: 1.2rem;
    }

    /* SIDEBAR */
    .sidebar-widget {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 5px 20px rgba(0,0,0,0.02);
        margin-bottom: 2rem;
    }
    .sidebar-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--coklat-tua);
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 0.75rem;
    }
    .sidebar-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background: var(--gold);
        border-radius: 2px;
    }
    
    .recent-post {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.2rem;
        align-items: flex-start;
    }
    .recent-post:last-child {
        margin-bottom: 0;
    }
    .recent-img {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        object-fit: cover;
    }
    .recent-body {
        flex: 1;
    }
    .recent-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--coklat-tua);
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.4;
        margin-bottom: 0.3rem;
    }
    .recent-title:hover {
        color: var(--gold);
    }
    .recent-meta {
        font-size: 0.75rem;
        color: var(--teks-abu);
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }
    .recent-meta i {
        color: var(--gold);
    }

    /* SHARE BUTTONS */
    .share-section {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .btn-share {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: transform 0.2s ease;
        text-decoration: none;
    }
    .btn-share:hover {
        transform: translateY(-3px);
        color: white;
    }
    .btn-whatsapp { background: #25D366; }
    .btn-facebook { background: #1877F2; }
    .btn-twitter { background: #1DA1F2; }
</style>
@endpush

@section('content')
<section class="py-4 bg-cream">
    <div class="container">
        <!-- BREADCRUMBS -->
        <div class="breadcrumb-custom">
            <a href="{{ route('home') }}"><i class="bi bi-house-door-fill"></i></a>
            <span class="separator">/</span>
            <a href="{{ route('berita.index') }}">Berita {{ $settings['nama_desa'] ?? '' }}</a>
        </div>

        <div class="row g-5">
            <!-- MAIN CONTENT -->
            <div class="col-lg-8">
                <div class="article-wrapper" data-aos="fade-up">
                    <h1 class="article-title">{{ $berita->judul }}</h1>
                    
                    <div class="article-meta">
                        <div class="article-meta-item">
                            <i class="bi bi-calendar3"></i> 
                            {{ $berita->published_at ? $berita->published_at->translatedFormat('d F Y') : '-' }}
                        </div>
                        <div class="article-meta-item">
                            <i class="bi bi-person"></i> Ditulis oleh <strong>ADMIN DESA</strong>
                        </div>
                        <div class="article-meta-item">
                            <i class="bi bi-eye"></i> Dilihat <strong>{{ $berita->views }}</strong> kali
                        </div>
                    </div>

                    @if($berita->gambar && file_exists(public_path('images/berita/'.$berita->gambar)))
                        <img src="{{ asset('images/berita/'.$berita->gambar) }}" class="article-image" alt="{{ $berita->judul }}">
                    @else
                        @php $fallbackImg = 'berita' . (($berita->id % 3) + 1) . '.jpg'; @endphp
                        <img src="{{ asset('images/berita/' . $fallbackImg) }}" class="article-image" alt="{{ $berita->judul }}" onerror="this.src='{{ asset('images/hero-placeholder.jpg') }}'">
                    @endif

                    <div class="article-content">
                        {!! $berita->isi !!}
                    </div>

                    <!-- SHARE BUTTONS -->
                    <div class="share-section">
                        <span class="fw-bold text-coklat-tua">Bagikan:</span>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($berita->judul . ' ' . Request::url()) }}" target="_blank" class="btn-share btn-whatsapp" title="Share ke WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}" target="_blank" class="btn-share btn-facebook" title="Share ke Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}&text={{ urlencode($berita->judul) }}" target="_blank" class="btn-share btn-twitter" title="Share ke Twitter">
                            <i class="bi bi-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- SIDEBAR -->
            <div class="col-lg-4">
                <div class="sidebar-widget" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="sidebar-title">Berita Terbaru</h3>
                    <div class="recent-posts-list">
                        @forelse($related as $item)
                        <div class="recent-post">
                            @if($item->gambar && file_exists(public_path('images/berita/'.$item->gambar)))
                                <img src="{{ asset('images/berita/'.$item->gambar) }}" class="recent-img" alt="{{ $item->judul }}">
                            @else
                                @php $recentFallbackImg = 'berita' . (($item->id % 3) + 1) . '.jpg'; @endphp
                                <img src="{{ asset('images/berita/' . $recentFallbackImg) }}" class="recent-img" alt="{{ $item->judul }}" onerror="this.src='{{ asset('images/hero-placeholder.jpg') }}'">
                            @endif
                            <div class="recent-body">
                                <a href="{{ route('berita.show', $item->slug) }}" class="recent-title">{{ $item->judul }}</a>
                                <div class="recent-meta">
                                    <i class="bi bi-calendar3"></i> 
                                    {{ $item->published_at ? $item->published_at->translatedFormat('d M Y') : '-' }}
                                    &nbsp; | &nbsp; 
                                    <i class="bi bi-eye"></i> {{ $item->views }}
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted small">Belum ada berita lainnya.</p>
                        @endforelse
                    </div>
                </div>

                <div class="sidebar-widget mt-4" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="sidebar-title">Kategori</h3>
                    <ul class="list-group list-group-flush border-0">
                        <a href="{{ route('berita.index', ['kategori' => 'berita']) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center bg-transparent border-bottom">
                            Berita <i class="bi bi-chevron-right small text-gold"></i>
                        </a>
                        <a href="{{ route('berita.index', ['kategori' => 'pengumuman']) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center bg-transparent border-bottom">
                            Pengumuman <i class="bi bi-chevron-right small text-gold"></i>
                        </a>
                        <a href="{{ route('berita.index', ['kategori' => 'pembangunan']) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center bg-transparent border-bottom">
                            Pembangunan <i class="bi bi-chevron-right small text-gold"></i>
                        </a>
                        <a href="{{ route('berita.index', ['kategori' => 'kegiatan']) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center bg-transparent">
                            Kegiatan <i class="bi bi-chevron-right small text-gold"></i>
                        </a>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
