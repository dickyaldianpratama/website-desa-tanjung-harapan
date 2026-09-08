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
    .article-wrapper {
        background: #ffffff;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 25px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    @media (max-width: 768px) {
        .article-wrapper {
            padding: 1.5rem;
        }
    }

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
        display: block;
        max-width: 100%;
        width: auto;
        max-height: 500px;
        margin: 0 auto 2rem auto;
        border-radius: 12px;
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
    .btn-telegram { background: #0088cc; }
    
    /* KOMENTAR */
    .comment-section {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(0,0,0,0.05);
    }
    .comment-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--coklat-tua);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .comment-title i {
        color: var(--gold);
    }
    .comment-alert {
        background-color: var(--cream);
        border: 1px solid rgba(201, 150, 58, 0.3);
        color: var(--coklat-tua);
        border-radius: 8px;
        padding: 1rem;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .comment-form .form-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #333;
    }
    .comment-form .form-label span {
        color: var(--gold);
    }
    .comment-form .form-control {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 0.6rem 1rem;
    }
    .comment-form .form-control:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 0.25rem rgba(201, 150, 58, 0.25);
    }
    .btn-submit-comment {
        background-color: var(--coklat-tua);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-submit-comment:hover {
        background-color: var(--gold);
        color: var(--coklat-tua);
    }

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
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ asset('images/logo_desa.png') }}" alt="Logo Desa" style="width: 50px; height: auto; object-fit: contain;">
                        <div>
                            <h1 class="article-title mb-1" style="font-size: 1.8rem;">{{ $berita->judul }}</h1>
                            <div class="text-muted small">Desa Tanjung Harapan</div>
                        </div>
                    </div>
                    
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

                    @if($berita->gambar)
                        <img src="{{ Storage::disk('s3')->url('images/berita/' . $berita->gambar) }}" class="article-image" alt="{{ $berita->judul }}">
                    @else
                        @php $fallbackImg = 'berita' . (($berita->id % 3) + 1) . '.jpg'; @endphp
                        <img src="{{ Storage::disk('s3')->url('images/berita/' . $fallbackImg) }}" class="article-image" alt="{{ $berita->judul }}" onerror="this.src='{{ asset('images/hero-placeholder.jpg') }}'">
                    @endif

                    <div class="article-content">
                        {!! $berita->isi !!}
                    </div>

                    <!-- SHARE BUTTONS -->
                    <div class="share-section mt-5">
                        <span class="fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="bi bi-share-fill"></i> Bagikan:
                        </span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}" target="_blank" class="btn-share btn-facebook" title="Share ke Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}&text={{ urlencode($berita->judul) }}" target="_blank" class="btn-share btn-twitter" title="Share ke Twitter">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($berita->judul . ' ' . Request::url()) }}" target="_blank" class="btn-share btn-whatsapp" title="Share ke WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <a href="https://t.me/share/url?url={{ urlencode(Request::url()) }}&text={{ urlencode($berita->judul) }}" target="_blank" class="btn-share btn-telegram" title="Share ke Telegram">
                            <i class="bi bi-telegram"></i>
                        </a>
                    </div>
                    
                    <!-- DAFTAR KOMENTAR -->
                    @if(isset($komentars) && $komentars->count() > 0)
                    <div class="mt-5 pt-4 border-top">
                        <h4 class="fw-bold mb-4 text-coklat-tua"><i class="bi bi-chat-text-fill me-2"></i>Komentar ({{ $komentars->count() }})</h4>
                        @foreach($komentars as $kom)
                            <div class="d-flex gap-3 mb-4 p-3 bg-light rounded-4">
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; font-size: 1.2rem; flex-shrink: 0;">
                                    {{ strtoupper(substr($kom->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $kom->nama }}</h6>
                                    <div class="text-muted small mb-2"><i class="bi bi-clock me-1"></i>{{ $kom->created_at->diffForHumans() }}</div>
                                    <p class="mb-0" style="font-size: 0.95rem;">{{ $kom->isi }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- COMMENT SECTION -->
                    <div class="comment-section">
                        <div class="comment-title">
                            <i class="bi bi-pencil-fill"></i> Beri Komentar
                        </div>
                        
                        <div class="comment-alert">
                            <i class="bi bi-info-circle-fill"></i> Komentar baru terbit setelah disetujui oleh admin
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success border-0 shadow-sm rounded-3">
                                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger border-0 shadow-sm rounded-3">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                            </div>
                        @endif
                        
                        <form action="{{ route('komentar.store', $berita->slug) }}" method="POST" class="comment-form">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Komentar <span>*</span></label>
                                <textarea name="isi" class="form-control" rows="4" required>{{ old('isi') }}</textarea>
                            </div>
                            
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Nama <span>*</span></label>
                                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Alamat Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">No. HP <span>*</span></label>
                                    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
                                <div style="background: #f1f5f9; padding: 0.25rem; border-radius: 4px; border: 1px solid #e2e8f0; display: inline-block;">
                                    <img src="{{ route('captcha.image') }}" alt="Captcha" id="captchaImage" style="display: block; border-radius: 2px;">
                                </div>
                                <button type="button" class="btn btn-link text-danger small text-decoration-none p-0 border-0" id="btnReloadCaptcha">[Ganti Gambar]</button>
                                <input type="text" name="captcha" class="form-control" style="width: 200px;" placeholder="Tulis kode di samping" required>
                            </div>
                            
                            <button type="submit" class="btn-submit-comment">
                                <i class="bi bi-send-fill me-1"></i> Kirim Komentar
                            </button>
                        </form>
                    </div>

                </div>
            </div>

            <!-- SIDEBAR -->
            <div class="col-lg-4">
                <div class="sidebar-widget" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="sidebar-title">Berita Terbaru</h3>
                    <div class="recent-posts-list">
                        @forelse($terbaru as $item)
                        <div class="recent-post">
                            @if($item->gambar)
                                <img src="{{ Storage::disk('s3')->url('images/berita/' . $item->gambar) }}" class="recent-img" alt="{{ $item->judul }}">
                            @else
                                @php $recentFallbackImg = 'berita' . (($item->id % 3) + 1) . '.jpg'; @endphp
                                <img src="{{ Storage::disk('s3')->url('images/berita/' . $recentFallbackImg) }}" class="recent-img" alt="{{ $item->judul }}" onerror="this.src='{{ asset('images/hero-placeholder.jpg') }}'">
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
                        @if(isset($kategoris) && count($kategoris) > 0)
                            @foreach($kategoris as $kat)
                                @if($kat)
                                    <a href="{{ route('berita.index', ['kategori' => $kat]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center bg-transparent border-bottom">
                                        {{ $kat }} <i class="bi bi-chevron-right small text-gold"></i>
                                    </a>
                                @endif
                            @endforeach
                        @else
                            <p class="text-muted small">Belum ada kategori.</p>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Captcha reload
        const btnReload = document.getElementById('btnReloadCaptcha');
        const captchaImage = document.getElementById('captchaImage');
        
        if (btnReload && captchaImage) {
            btnReload.addEventListener('click', function() {
                captchaImage.src = '{{ route('captcha.image') }}?' + new Date().getTime();
            });
        }
    });
</script>
@endpush
