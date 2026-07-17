@extends('layouts.app')
@section('title', 'Beranda')

@push('styles')
<style>
/* ── HERO SWIPER ── */
.hero-swiper { width:100vw; max-width:100%; height:100vh; min-height:550px; max-height:900px; overflow:hidden; margin:0; padding:0; background:var(--coklat-tua); }
.hero-swiper .swiper-wrapper { margin:0; padding:0; }
.hero-slide { position:relative; width:100%; height:100%; overflow:hidden; }
.hero-slide img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; }
.hero-overlay { position:absolute; inset:0; background:linear-gradient(to top, rgba(61,31,10,.85) 0%, rgba(61,31,10,.4) 50%, rgba(0,0,0,.2) 100%); z-index:1; }
.hero-content { position:absolute; inset:0; z-index:2; display:flex; align-items:center; justify-content:center; flex-direction:column; text-align:center; padding:2rem; width:100%; }
.hero-ornament {
    color: var(--gold);
    font-size: .95rem;
    letter-spacing: 8px;
    text-transform: uppercase;
    margin-bottom: 1rem;
    font-weight: 700;
    /* Kotak semi-transparan agar terbaca di atas foto apapun */
    background: rgba(0,0,0,.35);
    display: inline-block;
    padding: .4rem 1.5rem;
    border-radius: 30px;
    border: none; /* Border emas dihapus */
    backdrop-filter: blur(4px);
}
.hero-title {
    font-family: 'Playfair Display', serif;
    color: #fff;
    font-size: clamp(2.2rem, 5vw, 3.8rem);
    font-weight: 800;
    line-height: 1.15;
    margin-bottom: .5rem;
    text-shadow: 0 3px 25px rgba(0,0,0,.8), 0 1px 5px rgba(0,0,0,.9);
}
.hero-title span { color: var(--gold); }
.hero-subtitle {
    color: rgba(255,255,255,.95);
    font-size: 1.05rem;
    margin-bottom: 2rem;
    letter-spacing: 1.5px;
    text-shadow: 0 2px 10px rgba(0,0,0,.8);
    background: rgba(0,0,0,.25);
    display: inline-block;
    padding: .3rem 1rem;
    border-radius: 20px;
}
.hero-buttons { display:flex; gap:1rem; justify-content:center; flex-wrap:wrap; }
.swiper-button-next,.swiper-button-prev { color:var(--gold)!important; }
.swiper-pagination-bullet-active { background:var(--gold)!important; }
.hero-placeholder { width:100%; height:100%; background:linear-gradient(135deg,var(--coklat-tua),var(--coklat-muda)); display:flex; align-items:center; justify-content:center; font-size:8rem; }

/* ── SAMBUTAN ── */
.sambutan-section { background:var(--cream-light); }
.kades-photo-wrap { position:relative; }
.kades-photo { width:100%; max-width:300px; border-radius:12px; border:5px solid var(--gold); box-shadow:0 8px 30px rgba(61,31,10,.2); object-fit:cover; height:380px; }
.kades-photo-placeholder { width:100%; max-width:300px; height:380px; border-radius:12px; border:5px solid var(--gold); background:linear-gradient(135deg,var(--cream),var(--coklat-muda)); display:flex; align-items:center; justify-content:center; font-size:5rem; box-shadow:0 8px 30px rgba(61,31,10,.2); }
.kades-badge { position:absolute; bottom:-15px; left:50%; transform:translateX(-50%); background:var(--coklat-tua); color:#fff; padding:.6rem 1.5rem; border-radius:30px; font-size:.8rem; font-weight:600; text-align:center; white-space:nowrap; border:2px solid var(--gold); }
.sambutan-quote { color:var(--teks-gelap); font-size:1.05rem; line-height:1.8; margin:1.5rem 0; }
.signature-line { font-size:1.1rem; color:var(--coklat-tua); font-weight:700; margin-bottom:0; }

/* HORIZONTAL SCROLL KHUSUS HP */
@media (max-width: 768px) {
    .news-scroll-mobile {
        flex-wrap: nowrap !important;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 1rem;
        scroll-snap-type: x mandatory;
    }
    .news-scroll-mobile > div {
        flex: 0 0 85%;
        max-width: 85%;
        scroll-snap-align: start;
    }
    /* Sembunyikan scrollbar untuk tampilan lebih bersih */
    .news-scroll-mobile::-webkit-scrollbar { display: none; }
}

/* ANIMASI SCROLL REVEAL (Universal PC & HP) */
.reveal {
    opacity: 0;
    transform: translateY(40px);
    transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
}
.reveal.active {
    opacity: 1;
    transform: translateY(0);
}

/* ANIMASI HOVER ZOOM (Hanya jalan di perangkat dengan mouse / PC) */
.card-desa { overflow: hidden; }
.card-desa img { transition: transform 0.6s ease; }
@media (hover: hover) {
    .card-desa:hover img { transform: scale(1.08); }
}
</style>
@endpush

@section('content')

{{-- ── HERO CAROUSEL ── --}}
<div class="swiper hero-swiper">
    <div class="swiper-wrapper">
        @forelse($sliders as $slider)
        <div class="swiper-slide hero-slide">
            @if($slider->gambar)
                <img src="{{ asset('images/sliders/'.$slider->gambar) }}" alt="{{ $slider->judul }}">
            @else
                <div class="hero-placeholder">🏡</div>
            @endif
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <div class="hero-ornament">Selamat Datang</div>
                <h1 class="hero-title">{{ $slider->judul }}<br><span>{{ $settings['nama_desa'] ?? '' }}</span></h1>
                @if($slider->subtitle)
                    <p class="hero-subtitle">{{ $slider->subtitle }}</p>
                @endif
                <div class="hero-buttons">
                    <a href="{{ route('profil') }}" class="btn-desa-primary">Profil Desa</a>
                    <a href="{{ route('kontak') }}" class="btn-desa-outline">Hubungi Kami</a>
                </div>
            </div>
        </div>
        @empty
        <div class="swiper-slide hero-slide">
            <div class="hero-placeholder">🏡</div>
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <div class="hero-ornament">✦ &nbsp; Selamat Datang &nbsp; ✦</div>
                <h1 class="hero-title">Selamat Datang di<br><span>{{ $settings['nama_desa'] ?? 'Desa Nusantara' }}</span></h1>
                <p class="hero-subtitle">{{ $settings['nama_kecamatan'] ?? '' }} · {{ $settings['nama_kabupaten'] ?? '' }}</p>
                <div class="hero-buttons">
                    <a href="{{ route('profil') }}" class="btn-desa-primary">Profil Desa</a>
                    <a href="{{ route('kontak') }}" class="btn-desa-outline">Hubungi Kami</a>
                </div>
            </div>
        </div>
        @endforelse
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
</div>

{{-- ── STATISTIK ── --}}
<section class="stats-bar">
    <div class="container">
        <div class="row g-0">
            <div class="col-6 col-md-3 stat-item">
                <div class="stat-number" data-target="{{ preg_replace('/[^0-9]/', '', $settings['jumlah_penduduk'] ?? '0') }}">0</div>
                <div class="stat-unit">Jiwa</div>
                <div class="stat-label">Jumlah Penduduk</div>
            </div>
            <div class="col-6 col-md-3 stat-item stat-divider">
                <div class="stat-number" data-target="{{ preg_replace('/[^0-9]/', '', $settings['jumlah_kk'] ?? '0') }}">0</div>
                <div class="stat-unit">KK</div>
                <div class="stat-label">Kepala Keluarga</div>
            </div>
            <div class="col-6 col-md-3 stat-item stat-divider">
                <div class="stat-number" data-target="{{ preg_replace('/[^0-9]/', '', $settings['jumlah_rw'] ?? '0') }}">0</div>
                <div class="stat-unit">RW</div>
                <div class="stat-label">Rukun Warga</div>
            </div>
            <div class="col-6 col-md-3 stat-item stat-divider">
                <div class="stat-number" data-target="{{ preg_replace('/[^0-9]/', '', $settings['jumlah_rt'] ?? '0') }}">0</div>
                <div class="stat-unit">RT</div>
                <div class="stat-label">Rukun Tetangga</div>
            </div>
        </div>
    </div>
</section>

{{-- ── SAMBUTAN KEPALA DESA ── --}}
<section class="sambutan-section py-5">
    <div class="container">
        <div class="row align-items-center g-5 reveal">
            <div class="col-md-4 text-center">
                <div class="kades-photo-wrap d-inline-block position-relative">
                    @php 
                        $fotoKades = $settings['foto_kades'] ?? ''; 
                        $defaultKades = 'perangkat/kades.jpg';
                    @endphp
                    @if($fotoKades)
                        <img src="{{ asset('images/'.$fotoKades) }}" class="kades-photo" alt="Kepala Desa">
                    @elseif($defaultKades)
                        <img src="{{ asset('images/'.$defaultKades) }}" class="kades-photo" alt="Kepala Desa">
                    @else
                        <div class="kades-photo-placeholder">👤</div>
                    @endif
                    <div class="kades-badge">
                        <div style="font-size:.65rem;opacity:.8">{{ $settings['jabatan_kades'] ?? 'Kepala Desa' }}</div>
                        <div>{{ $settings['nama_kades'] ?? '-' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-8" style="margin-top:1rem">
                <p class="text-gold fw-semibold mb-1" style="font-size:.85rem;letter-spacing:2px;text-transform:uppercase">Sambutan</p>
                <h2 class="section-title left">Kepala Desa</h2>
                <div class="sambutan-quote mt-4">
                    {{ $settings['sambutan_kades'] ?? 'Selamat datang di website resmi desa Tanjung Harapan. Melalui website ini, kami berkomitmen untuk memberikan informasi yang transparan dan akurat kepada seluruh masyarakat. Mari bersama-sama membangun desa kita tercinta.' }}
                </div>
                <div class="mt-4">
                    <div class="signature-line">{{ $settings['nama_kades'] ?? '-' }}</div>
                    <div style="font-size:.85rem;color:var(--teks-abu)">{{ $settings['jabatan_kades'] ?? 'Kepala Desa' }}</div>
                </div>
                <a href="{{ route('profil') }}" class="btn-desa-primary mt-3 d-inline-block">Selengkapnya</a>
            </div>
        </div>
    </div>
</section>

{{-- ── BERITA TERBARU ── --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-4">
            <p class="text-gold fw-semibold mb-1" style="font-size:.85rem;letter-spacing:2px;text-transform:uppercase">Informasi</p>
            <h2 class="section-title">Berita & Pengumuman</h2>
            <p class="section-subtitle">Informasi terkini seputar kegiatan dan pengumuman desa</p>
        </div>
        <div class="swiper berita-swiper pb-4">
            <div class="swiper-wrapper">
                @forelse($beritas as $berita)
                <div class="swiper-slide h-auto">
                    <div class="card-desa h-100 reveal" style="transition-delay: {{ $loop->index * 150 }}ms;">
                        @php $defaultImg = 'berita' . $loop->iteration . '.jpg'; @endphp
                        @if($berita->gambar)
                            <img src="{{ asset('images/berita/'.$berita->gambar) }}" alt="{{ $berita->judul }}">
                        @elseif($defaultImg)
                            <img src="{{ asset('images/berita/'.$defaultImg) }}" alt="{{ $berita->judul }}">
                        @else
                            <div class="img-placeholder" style="height:200px">📰</div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <span class="badge-kategori">{{ ucfirst($berita->kategori) }}</span>
                            <h3 class="card-title mt-2">{{ $berita->judul }}</h3>
                            <p style="font-size:.8rem;color:var(--teks-abu)" class="mb-auto">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $berita->published_at ? $berita->published_at->translatedFormat('d F Y') : '-' }}
                            </p>
                            <a href="{{ route('berita.show', $berita->slug) }}" class="link-gold mt-3">Selengkapnya <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-4 text-muted">Belum ada berita.</div>
                @endforelse
            </div>
            <div class="swiper-pagination position-static mt-2"></div>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('berita.index') }}" class="btn-desa-primary">Lihat Semua Berita</a>
        </div>
    </div>
</section>

{{-- ── POTENSI DESA ── --}}
<section class="py-5 bg-cream">
    <div class="container">
        <div class="text-center mb-4">
            <p class="text-gold fw-semibold mb-1" style="font-size:.85rem;letter-spacing:2px;text-transform:uppercase">Unggulan</p>
            <h2 class="section-title">Potensi Desa</h2>
            <p class="section-subtitle">Kekayaan dan potensi yang dimiliki {{ $settings['nama_desa'] ?? 'desa kami' }}</p>
        </div>
        <div class="swiper potensi-swiper pb-4">
            <div class="swiper-wrapper">
                @forelse($potensis as $potensi)
                <div class="swiper-slide h-auto">
                    <div class="card-desa h-100 reveal" style="transition-delay: {{ $loop->index * 150 }}ms;">
                        @php 
                            $defaultImg = 'potensi' . $loop->iteration . '.jpg'; 
                            $icons = ['wisata'=>'🏞️','umkm'=>'🛒','pertanian'=>'🌾','budaya'=>'🎭']; 
                        @endphp
                        @if($potensi->gambar)
                            <img src="{{ asset('images/potensi/'.$potensi->gambar) }}" alt="{{ $potensi->judul }}">
                        @elseif($defaultImg)
                            <img src="{{ asset('images/potensi/'.$defaultImg) }}" alt="{{ $potensi->judul }}">
                        @else
                            <div class="img-placeholder" style="height:200px">{{ $icons[$potensi->kategori] ?? '🌟' }}</div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <span class="badge-kategori">{{ ucfirst($potensi->kategori) }}</span>
                            <h3 class="card-title mt-2">{{ $potensi->judul }}</h3>
                            <p style="font-size:.875rem;color:var(--teks-abu);display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;" class="mb-auto">{{ $potensi->deskripsi }}</p>
                            <a href="{{ route('potensi.show', $potensi->slug) }}" class="link-gold mt-3">Selengkapnya <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-4 text-muted">Belum ada data potensi.</div>
                @endforelse
            </div>
            <div class="swiper-pagination position-static mt-2"></div>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('potensi.index') }}" class="btn-desa-primary">Lihat Semua Potensi</a>
        </div>
    </div>
</section>

{{-- ── CTA KONTAK ── --}}
<section class="py-5 bg-coklat text-white text-center">
    <div class="container">
        <h2 class="font-serif mb-2" style="color:var(--gold)">Ada Pertanyaan atau Pengaduan?</h2>
        <p class="mb-4" style="color:rgba(255,255,255,.8)">Kami siap melayani dan menampung aspirasi masyarakat desa</p>
        <a href="{{ route('kontak') }}" class="btn-gold">Hubungi Kami <i class="bi bi-arrow-right ms-1"></i></a>
    </div>
</section>

@endsection

@push('scripts')
<script>
const heroSwiper = new Swiper('.hero-swiper', {
    loop: true,
    autoplay: { delay: 5000, disableOnInteraction: false },
    effect: 'fade',
    fadeEffect: { crossFade: false },
    navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
    pagination: { el: '.swiper-pagination', clickable: true },
});

// Berita & Potensi Swiper (Horizontal Scroll on Mobile)
const commonSwiperConfig = {
    slidesPerView: 1.15,
    spaceBetween: 20,
    grabCursor: true,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    pagination: { el: '.swiper-pagination', clickable: true },
    breakpoints: {
        576: { slidesPerView: 2, spaceBetween: 20 },
        768: { slidesPerView: 3, spaceBetween: 30 }
    }
};
new Swiper('.berita-swiper', commonSwiperConfig);
new Swiper('.potensi-swiper', commonSwiperConfig);

// Counter Animasi Statistik
document.addEventListener('DOMContentLoaded', () => {
    const counters = document.querySelectorAll('.stat-number');
    
    const animateCounter = (counter) => {
        const target = +counter.getAttribute('data-target');
        const duration = 2000; // 2 detik
        const increment = target / (duration / 16); 
        
        let current = 0;
        const updateCounter = () => {
            current += increment;
            if (current < target) {
                // Format angka dengan pemisah ribuan ala Indonesia
                counter.innerText = Math.ceil(current).toLocaleString('id-ID').replace(/,/g, '.');
                requestAnimationFrame(updateCounter);
            } else {
                counter.innerText = target.toLocaleString('id-ID').replace(/,/g, '.');
            }
        };
        updateCounter();
    };

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });

    counters.forEach(counter => observer.observe(counter));
});

// Animasi Scroll Reveal
document.addEventListener('DOMContentLoaded', () => {
    const reveals = document.querySelectorAll('.reveal');
    const revealObserver = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                obs.unobserve(entry.target); // Hanya animasi 1x
            }
        });
    }, { threshold: 0.15, rootMargin: "0px 0px -50px 0px" });

    reveals.forEach(reveal => revealObserver.observe(reveal));
});
</script>
@endpush
