@extends('layouts.app')

@section('title', 'Profil Desa - ' . ($settings['nama_desa'] ?? 'Desa Tanjung Harapan'))

@push('styles')
<style>
    /* HERO PROFIL */
    .hero-profil {
        position: relative;
        width: 100%;
        min-height: 500px;
        padding-top: 120px;
        padding-bottom: 60px;
        background: url('{{ asset("images/profil/hero.jpg") }}') center/cover no-repeat;
        display: flex;
        align-items: center;
        background-color: var(--coklat-tua); /* Fallback */
    }
    .hero-profil::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, rgba(42,22,8,0.9) 0%, rgba(42,22,8,0.4) 100%);
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        padding: 1.5rem;
        color: var(--putih);
    }
    .glass-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .glass-item:last-child { margin-bottom: 0; }
    .glass-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    /* SEJARAH & KADES */
    .section-spacing { padding: 5rem 0; }
    .bg-light-cream { background-color: var(--cream-light); }
    
    .sejarah-img-wrapper {
        border-radius: 16px;
        overflow: hidden;
        position: relative;
        height: 400px;
    }
    .sejarah-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .sejarah-overlay {
        position: absolute;
        bottom: 0; left: 0; width: 100%;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        padding: 2rem 1.5rem 1rem;
        color: white;
        display: flex;
        justify-content: space-between;
    }
    .sejarah-box {
        background: var(--putih);
        border-radius: 16px;
        padding: 2rem;
        height: 400px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.05);
        overflow-y: auto;
    }
    .sejarah-box::-webkit-scrollbar { width: 6px; }
    .sejarah-box::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 10px; }
    
    .kades-card-profil {
        background-color: var(--putih);
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        height: 400px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    .kades-card-profil > * {
        position: relative;
        z-index: 1;
    }
    .kades-card-profil .kades-photo-img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 1.5rem;
        border: 4px solid var(--cream);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    /* VISI MISI */
    .misi-card {
        background: var(--putih);
        border-radius: 16px;
        padding: 2rem;
        height: 100%;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.05);
        position: relative;
        transition: transform 0.3s ease;
    }
    .misi-card:hover { transform: translateY(-5px); }
    .misi-number {
        width: 40px;
        height: 40px;
        background: var(--teks-gelap);
        color: var(--putih);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-bottom: 1.5rem;
    }
    .misi-title-line {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 3rem;
    }
    .misi-title-line::before, .misi-title-line::after {
        content: '';
        height: 2px;
        width: 60px;
        background: var(--gold);
    }

    /* SAMBUTAN */
    .sambutan-box {
        background: var(--putih);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    }
    .sambutan-img-wrap {
        position: relative;
        height: 100%;
        min-height: 300px;
    }
    @media (max-width: 768px) {
        .sambutan-img-wrap {
            min-height: 260px;
        }
    }
    .sambutan-img-wrap img {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top center;
    }
    
    /* PERANGKAT SWIPER */
    .perangkat-swiper {
        padding: 2rem 1rem;
        padding-bottom: 4rem;
    }
    .perangkat-slide-card {
        background: var(--cream);
        border-radius: 16px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
        height: 340px; /* default for mobile */
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }
    @media (min-width: 768px) {
        .perangkat-slide-card {
            height: 380px;
        }
    }
    @media (min-width: 992px) {
        .perangkat-slide-card {
            height: 440px; /* Taller on desktop */
        }
    }
    .perangkat-slide-card img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top center;
        z-index: 0;
    }
    .perangkat-slide-card .placeholder {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--cream);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
        color: #d8c3a5;
        z-index: 0;
    }
    .perangkat-slide-card .card-content {
        position: relative;
        z-index: 2;
        padding: 2rem 1rem 1.5rem 1rem;
        background: linear-gradient(to top, rgba(61, 31, 10, 0.95) 0%, rgba(61, 31, 10, 0.8) 50%, transparent 100%);
        color: white;
    }
    .perangkat-slide-card .card-content h5 {
        color: white !important;
        font-size: 1.1rem;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .perangkat-slide-card .card-content p {
        color: rgba(255, 255, 255, 0.85) !important;
        font-size: 0.85rem;
        margin-bottom: 0;
    }

    /* KEPEMIMPINAN TIMELINE */
    .kepemimpinan-card {
        background: var(--putih);
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.03);
        border: 1px solid rgba(0,0,0,0.05);
        margin-bottom: 4rem;
    }
    .kepemimpinan-header {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        color: var(--coklat-tua);
        margin-bottom: 3rem;
    }
    .timeline-line {
        height: 2px;
        background: #e9ecef;
        position: relative;
        margin: 2rem 0 3rem;
    }
    .timeline-node {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 20px;
        height: 20px;
        background: #f8f9fa;
        border: 3px solid #dee2e6;
        border-radius: 50%;
        display: flex;
        justify-content: center;
    }
    .timeline-content {
        position: absolute;
        top: 30px;
        text-align: center;
        width: 300px;
    }
    .timeline-content h6 { font-weight: 700; color: var(--teks-gelap); font-size: 0.95rem; margin: 0.5rem 0 0.2rem; }
    .timeline-content .periode { font-size: 0.85rem; font-weight: 700; color: var(--coklat-tua); }
    .timeline-content .jabatan { font-size: 0.8rem; color: var(--teks-abu); }
    .kepemimpinan-note {
        background: var(--cream-light);
        padding: 1rem 1.5rem;
        border-radius: 8px;
        font-size: 0.9rem;
        color: var(--teks-abu);
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 5rem;
    }

    /* PETA BATAS WILAYAH ELEGANT */
    .badge-peta {
        background: var(--cream);
        color: var(--coklat-tua);
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 1px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }
    .map-card-container {
        background: var(--putih);
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.04);
        display: flex;
        flex-wrap: wrap;
        overflow: hidden;
    }
    .map-info-side {
        flex: 1 1 300px;
        padding: 2.5rem;
        display: flex;
        flex-direction: column;
    }
    .map-embed-side {
        flex: 1 1 300px;
        min-height: 500px;
    }
    .batas-header {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--teks-gelap);
        margin-bottom: 2rem;
    }
    .icon-circle-black {
        width: 45px;
        height: 45px;
        background: var(--teks-gelap);
        color: var(--putih);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    .batas-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .batas-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }
    .batas-icon-arrow {
        width: 30px;
        height: 30px;
        background: #f8f9fa;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--teks-abu);
        font-size: 1rem;
        flex-shrink: 0;
    }
    .batas-item .label { font-size: 0.75rem; color: var(--teks-abu); margin-bottom: 0.2rem; }
    .batas-item .value { font-size: 0.9rem; font-weight: 700; color: var(--teks-gelap); line-height: 1.4; }
    
    .batas-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        padding: 1.5rem 0;
        border-top: 1px dashed #e9ecef;
        border-bottom: 1px dashed #e9ecef;
        margin-bottom: 1.5rem;
    }
    .b-stat-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .b-stat-icon { color: var(--teks-abu); font-size: 1.2rem; }
    .b-stat-info .val { font-size: 1.1rem; font-weight: 700; color: var(--teks-gelap); line-height: 1.2; }
    .b-stat-info .lbl { font-size: 0.75rem; color: var(--teks-abu); }
    
    .map-footer-note {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        color: var(--teks-abu);
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: auto;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
@endpush

@section('content')

{{-- 1. HERO PROFIL --}}
<section class="hero-profil">
    <div class="container position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-7 text-white mb-4 mb-lg-0" data-aos="fade-up">
                <p class="mb-1 text-gold fw-bold d-flex align-items-center gap-2" style="letter-spacing: 2px; text-transform: uppercase;">
                    <i class="bi bi-bookmark-star-fill"></i> Selamat Datang di
                </p>
                <h1 class="display-4 font-serif fw-bold mb-3">Profil Desa<br>{{ $settings['nama_desa'] ?? 'Tanjung Harapan' }}</h1>
                <p class="lead opacity-75"><i class="bi bi-info-circle me-2"></i>Informasi mengenai {{ $settings['nama_desa'] ?? 'Desa Tanjung Harapan' }}, {{ $settings['nama_kecamatan'] ?? 'Kecamatan Kampar Kiri' }} {{ $settings['nama_kabupaten'] ?? 'Kabupaten Kampar' }}.</p>
            </div>
            <div class="col-lg-5" data-aos="fade-left" data-aos-delay="200">
                <div class="glass-card">
                    <div class="glass-item">
                        <div class="glass-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <div>
                            <div class="small opacity-75">Kecamatan</div>
                            <div class="fw-bold">{{ $settings['nama_kecamatan'] ?? 'Kampar Kiri' }}, {{ $settings['nama_kabupaten'] ?? 'Kampar' }}</div>
                        </div>
                    </div>
                    <div class="glass-item">
                        <div class="glass-icon"><i class="bi bi-map-fill"></i></div>
                        <div>
                            <div class="small opacity-75">Luas Wilayah</div>
                            <div class="fw-bold">{{ $settings['luas_wilayah'] ?? '± 1.544 Ha' }}</div>
                        </div>
                    </div>
                    <div class="glass-item">
                        <div class="glass-icon"><i class="bi bi-people-fill"></i></div>
                        <div>
                            <div class="small opacity-75">Jumlah Penduduk</div>
                            <div class="fw-bold">{{ $settings['jumlah_penduduk'] ?? '-' }} Jiwa</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 2. SEJARAH & KADES --}}
<section class="section-spacing bg-light-cream">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <p class="badge bg-cream rounded-pill px-3 py-2 fw-bold mb-3" style="color: var(--coklat-tua) !important; letter-spacing: 2px;"><i class="bi bi-journal-text me-1"></i> PROFIL DESA</p>
            <h2 class="font-serif fw-bold text-coklat-tua">Sejarah {{ $settings['nama_desa'] ?? 'Desa Tanjung Harapan' }} <i class="bi bi-stars text-gold ms-1"></i></h2>
            <p class="text-muted">Mengenal asal-usul dan perjalanan desa dari masa ke masa</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-right">
                <div class="sejarah-img-wrapper">
                    <!-- Ganti src dengan gambar gerbang desa/ikon desa jika ada -->
                    <img src="{{ asset('images/profil/sejarah.jpg') }}" alt="Gerbang Desa" class="sejarah-img" onerror="this.src='{{ asset('images/hero-placeholder.jpg') }}'">
                    <div class="sejarah-overlay">
                        <div>
                            <div class="small opacity-75">Jumlah Penduduk</div>
                            <div class="fw-bold"><i class="bi bi-people-fill text-gold me-1"></i> {{ $settings['jumlah_penduduk'] ?? '-' }}</div>
                        </div>
                        <div class="text-end">
                            <div class="small opacity-75">Luas Wilayah</div>
                            <div class="fw-bold"><i class="bi bi-pin-map-fill text-gold me-1"></i> {{ $settings['luas_wilayah'] ?? '± 1.544 Ha' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="sejarah-box">
                    <h5 class="fw-bold text-coklat-tua mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-book-half text-gold fs-4"></i> Asal Usul Desa
                    </h5>
                    <div class="text-secondary" style="line-height: 1.8; font-size: 0.95rem;">
                        @if(!empty($settings['sejarah_desa']))
                            {!! nl2br(e($settings['sejarah_desa'])) !!}
                        @else
                            <p>{{ $settings['nama_desa'] ?? 'Desa Tanjung Harapan' }} memiliki sejarah panjang yang erat kaitannya dengan perkembangan masyarakat setempat. Dibentuk pada masa pra-kemerdekaan, desa ini awalnya merupakan perkampungan kecil yang mayoritas penduduknya berprofesi sebagai petani dan nelayan.</p>
                            <p>Seiring berjalannya waktu, desa ini terus berkembang menjadi pusat perekonomian dan kebudayaan, menjunjung tinggi kearifan lokal serta asas gotong royong dalam membangun kehidupan bermasyarakat yang harmonis, agamis, dan sejahtera.</p>
                        @endif
                    </div>
                    <hr class="my-4">
                    <div class="d-flex gap-3 text-muted fst-italic bg-light p-3 rounded" style="font-size: 0.9rem;">
                        <i class="bi bi-quote fs-3 text-gold" style="margin-top: -10px;"></i>
                        <p class="mb-0">Bersama membangun desa, menjaga warisan, dan melangkah menuju masa depan yang lebih baik.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-12" data-aos="fade-left" data-aos-delay="200">
                <div class="kades-card-profil">
                    <!-- Logo Desa (sebagai objek di balik kaca) -->
                    <img src="{{ asset('images/logo_desa.png') }}" alt="Watermark" class="position-absolute top-50 start-50 translate-middle" style="width: 220px; opacity: 0.65; pointer-events: none; z-index: 0;">

                    <!-- Layer Kaca (Glassmorphism Effect) -->
                    <div class="position-absolute w-100 h-100 top-0 start-0" style="background: linear-gradient(135deg, rgba(255,255,255,0.45), rgba(255,255,255,0.15)); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); z-index: 1;"></div>

                    <!-- Konten -->
                    <div class="position-relative w-100" style="z-index: 2;">
                        <p class="text-muted fw-bold mb-4" style="letter-spacing: 1px;"><i class="bi bi-person-badge text-gold me-2"></i>Kepala Desa</p>
                        
                        @php 
                            $fotoKades = $kades && $kades->foto ? 'perangkat/'.$kades->foto : ($settings['foto_kades'] ?? 'perangkat/kades.jpg');
                            $namaKades = $kades ? $kades->nama : ($settings['nama_kades'] ?? 'Saripudin, S.Pd.I');
                            $jabatanKades = $kades ? $kades->jabatan : ($settings['jabatan_kades'] ?? 'Kepala Desa');
                        @endphp
                        
                        @if($kades && $kades->foto)
                            <img src="{{ Storage::disk('s3')->url('images/perangkat/' . $kades->foto) }}" alt="Foto Kades" class="kades-photo-img">
                        @elseif(isset($settings['foto_kades']) && $settings['foto_kades'])
                            <img src="{{ asset('images/'.$settings['foto_kades']) }}" alt="Foto Kades" class="kades-photo-img">
                        @else
                            <img src="{{ Storage::disk('s3')->url('images/perangkat/kades.jpg') }}" alt="Foto Kades" class="kades-photo-img" onerror="this.src='https://ui-avatars.com/api/?name=Kades&background=C9963A&color=fff&size=150'">
                        @endif
                        
                        <h5 class="fw-bold text-coklat-tua mb-1">{{ $namaKades }}</h5>
                        <span class="badge bg-cream px-3 py-2 mt-2 rounded-pill" style="color: var(--coklat-tua) !important;">{{ $jabatanKades }} {{ $settings['nama_desa'] ?? 'Tanjung Harapan' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 3. VISI & MISI --}}
<section class="section-spacing">
    <div class="container">
        <!-- VISI -->
        <div class="text-center mb-5" data-aos="zoom-in">
            <h5 class="fw-bold text-dark mb-4 letter-spacing-1 d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-eye-fill fs-3"></i> VISI
            </h5>
            <div class="mx-auto" style="max-width: 800px;">
                <h3 class="font-serif text-coklat-tua fw-bold" style="line-height: 1.6;">
                    "{{ $settings['visi_desa'] ?? 'Mewujudkan Desa yang Mandiri, Sejahtera, Agamis, dan Berbudaya melalui Tata Kelola Pemerintahan yang Bersih dan Inovatif.' }}"
                </h3>
            </div>
        </div>

        <!-- MISI -->
        <div class="misi-title-line mt-5" data-aos="fade-up">
            <h5 class="fw-bold text-dark mb-0 letter-spacing-1 mx-3 d-flex align-items-center gap-2">
                <i class="bi bi-bullseye fs-4"></i> MISI
            </h5>
        </div>

        @php
            $misi_list = [];
            if(!empty($settings['misi_desa'])) {
                $misi_list = array_filter(explode("\n", $settings['misi_desa']), 'trim');
            } else {
                $misi_list = [
                    'Meningkatkan Kinerja Pemerintah Desa. Maksudnya adalah meningkatkan kualitas pelayanan publik.',
                    'Mewujudkan nilai-nilai kebudayaan masyarakat, mampu bertahan terhadap kemajuan dan berkontribusi.',
                    'Mewujudkan peningkatan kehidupan sosial bermasyarakat yang majemuk semakin mampu menciptakan kebersamaan.',
                    'Mewujudkan stabilitas ekonomi masyarakat dengan kondisi pendapatan yang mendasar didukung usaha sesuai profesi.'
                ];
            }
        @endphp

        <div class="row g-4 justify-content-center">
            @foreach($misi_list as $index => $misi)
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="misi-card">
                    <div class="misi-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                    <p class="text-secondary" style="font-size: 0.95rem; line-height: 1.6;">{{ $misi }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- 4. SAMBUTAN KEPALA DESA --}}
<section class="section-spacing bg-light-cream">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="sambutan-box">
                    <div class="row g-0">
                        <div class="col-md-5" data-aos="fade-right">
                    <div class="sambutan-img-wrap">
                        @if($kades && $kades->foto)
                            <img src="{{ Storage::disk('s3')->url('images/perangkat/' . $kades->foto) }}" alt="Kepala Desa">
                        @elseif(isset($settings['foto_kades']) && $settings['foto_kades'])
                            <img src="{{ asset('images/'.$settings['foto_kades']) }}" alt="Kepala Desa">
                        @else
                            <img src="{{ Storage::disk('s3')->url('images/perangkat/kades.jpg') }}" alt="Kepala Desa" onerror="this.src='https://ui-avatars.com/api/?name=Kades&background=C9963A&color=fff&size=500'">
                        @endif
                    </div>
                </div>
                        <div class="col-md-7 d-flex align-items-center" data-aos="fade-left">
                            <div class="p-4 p-lg-5">
                                <div class="d-flex align-items-center gap-2 mb-3 text-gold">
                                    <i class="bi bi-megaphone-fill"></i>
                                    <span class="fw-bold text-uppercase" style="letter-spacing: 2px; font-size: 0.85rem;">Sambutan Kepala Desa</span>
                                </div>
                                <h3 class="fw-bold text-coklat-tua mb-2">{{ $namaKades }}</h3>
                                <p class="text-muted fw-semibold mb-4 d-flex align-items-center gap-2"><i class="bi bi-person-vcard"></i> {{ $jabatanKades }}</p>
                                
                                <div class="text-secondary" style="line-height: 1.8;">
                                    <p><em>Assalamu'alaikum Warahmatullahi Wabarakatuh,</em></p>
                                    <p><em>Yth. Bapak/Ibu/Saudara/i sekalian warga desa yang saya cintai,</em></p>
                                    <p>Dengan segala kerendahan hati dan rasa syukur yang mendalam, saya ingin menyampaikan terima kasih atas kepercayaan yang telah diberikan kepada saya untuk memimpin desa yang kita cintai ini. Sambutan ini bukan sekadar formalitas, melainkan wujud komitmen saya untuk bersama-sama membangun desa menjadi lebih baik...</p>
                                </div>
                                
                                <a href="{{ route('home') }}" class="btn btn-gold mt-3 px-4 rounded-pill">
                                    <i class="bi bi-chat-quote-fill me-2"></i> Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 5. PERANGKAT DESA (SWIPER CAROUSEL) --}}
<section class="section-spacing bg-light-cream">
    <div class="container">
        
        <div class="row g-4 justify-content-center">
            
            <!-- Kolom Kiri: Widget Absensi -->
            <div class="col-lg-4" data-aos="fade-up">
                <div style="background: #fff; border-radius: 20px; box-shadow: 0 8px 32px rgba(0,0,0,.10); overflow: hidden; font-family: 'Poppins', sans-serif; display: flex; flex-direction: column;">
                    {{-- Header Coklat --}}
                    <div style="background: var(--coklat-tua); padding: 1.25rem 1.5rem; display:flex; align-items:center; gap:.9rem; flex-shrink: 0;">
                        <div style="width:44px;height:44px;background:rgba(255,255,255,.15);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <i class="bi bi-briefcase-fill" style="color:#fff;font-size:1.3rem"></i>
                        </div>
                        <div>
                            <div style="font-weight:700;color:#fff;font-size:1.05rem;line-height:1.2">Jam Kerja</div>
                            <div style="color:rgba(255,255,255,.75);font-size:.8rem">Jadwal layanan kantor</div>
                        </div>
                    </div>

                    {{-- Daftar Hari --}}
                    @php
                        $today = now()->locale('id')->dayOfWeek;
                        $jamKerja = [
                            ['hari' => 'Senin',  'masuk' => '08:00', 'pulang' => '14:00', 'libur' => false, 'dow' => 1],
                            ['hari' => 'Selasa', 'masuk' => '08:00', 'pulang' => '14:00', 'libur' => false, 'dow' => 2],
                            ['hari' => 'Rabu',   'masuk' => '08:00', 'pulang' => '14:00', 'libur' => false, 'dow' => 3],
                            ['hari' => 'Kamis',  'masuk' => '08:00', 'pulang' => '14:00', 'libur' => false, 'dow' => 4],
                            ['hari' => 'Jumat',  'masuk' => '08:00', 'pulang' => '13:00', 'libur' => false, 'dow' => 5],
                            ['hari' => 'Sabtu',  'masuk' => null,    'pulang' => null,    'libur' => true,  'dow' => 6],
                            ['hari' => 'Minggu', 'masuk' => null,    'pulang' => null,    'libur' => true,  'dow' => 0],
                        ];
                    @endphp
                    <div style="padding: .5rem 0; flex-grow: 1;">
                        @foreach($jamKerja as $jk)
                        @php $isToday = ($today == $jk['dow']); @endphp
                        <div style="
                            display:flex; align-items:center; justify-content:space-between;
                            padding: .7rem 1.5rem;
                            background: {{ $isToday ? 'rgba(201,150,58,.05)' : 'transparent' }};
                            border-left: {{ $isToday ? '3px solid var(--gold)' : '3px solid transparent' }};
                            transition: background .2s;
                        ">
                            <div style="display:flex;align-items:center;gap:.6rem">
                                @if($isToday)
                                    <span style="width:8px;height:8px;background:var(--gold);border-radius:50%;display:inline-block;flex-shrink:0"></span>
                                @else
                                    <span style="width:8px;height:8px;background:transparent;display:inline-block;flex-shrink:0"></span>
                                @endif
                                <span style="font-weight:{{ $isToday ? '700' : '500' }};color:{{ $jk['libur'] ? '#adb5bd' : '#2d3748' }};font-size:.9rem">
                                    {{ $jk['hari'] }}
                                </span>
                            </div>
                            @if($jk['libur'])
                                <span style="background:#e2e8f0;color:#718096;border-radius:20px;padding:.25rem .85rem;font-size:.78rem;font-weight:600">
                                    🌙 Libur
                                </span>
                            @else
                                <div style="display:flex;align-items:center;gap:.5rem">
                                    <span style="background:#e6f9f0;color:#15803d;border-radius:20px;padding:.25rem .7rem;font-size:.78rem;font-weight:600;display:inline-flex;align-items:center;gap:.25rem">
                                        <i class="bi bi-box-arrow-in-right" style="font-size:.75rem"></i> {{ $jk['masuk'] }}
                                    </span>
                                    <span style="color:#adb5bd;font-size:.8rem">—</span>
                                    <span style="background:#fff3e0;color:#c05621;border-radius:20px;padding:.25rem .7rem;font-size:.78rem;font-weight:600;display:inline-flex;align-items:center;gap:.25rem">
                                        <i class="bi bi-box-arrow-right" style="font-size:.75rem"></i> {{ $jk['pulang'] }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    {{-- Footer Card --}}
                    <div style="padding: .9rem 1.5rem; display:flex; justify-content:space-between; align-items:center; border-top: 1px solid #f1f5f9; flex-shrink: 0;">
                        <span style="font-size:.78rem;color:#94a3b8;display:flex;align-items:center;gap:.4rem">
                            <i class="bi bi-info-circle" style="color:var(--gold)"></i>
                            Layanan sesuai jam kerja
                        </span>
                        <button onclick="bukaModalKehadiran()" style="
                            background: var(--coklat-tua);
                            color:#fff; border:none; border-radius:20px;
                            padding:.4rem 1.1rem; font-size:.82rem; font-weight:700;
                            font-family:'Poppins',sans-serif;
                            cursor:pointer; display:inline-flex; align-items:center; gap:.4rem;
                            box-shadow: 0 4px 12px rgba(61,31,10,.3);
                            transition: all .2s;
                        " onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'">
                            <i class="bi bi-clipboard2-check-fill" style="color:var(--gold)"></i> Kehadiran
                        </button>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Card Aparatur -->
            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                <!-- White Card Wrapper -->
                <div style="background: #fff; border-radius: 20px; box-shadow: 0 8px 32px rgba(0,0,0,.10); padding: 1.5rem 2rem; height: 100%; font-family: 'Poppins', sans-serif;">
            
            <!-- Header Section -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 border-bottom pb-3 gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:50px;height:50px;background:var(--coklat-tua);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="bi bi-people-fill" style="color:var(--gold);font-size:1.5rem"></i>
                    </div>
                    <div>
                        <div style="font-weight:700;font-size:1.1rem;line-height:1.2;color:#1e293b">Aparatur Desa</div>
                        <div style="color:#94a3b8;font-size:.85rem">Perangkat yang melayani masyarakat</div>
                    </div>
                </div>
                <a href="#" style="color:var(--coklat-tua);font-weight:600;font-size:.9rem;text-decoration:none">Lihat Semua <i class="bi bi-arrow-right"></i></a>
            </div>

            <div class="swiper perangkat-swiper" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper">
                @forelse($perangkats as $perangkat)
                    <div class="swiper-slide">
                        <div class="perangkat-slide-card">
                            @if($perangkat->foto)
                                <img src="{{ Storage::disk('s3')->url('images/perangkat/' . $perangkat->foto) }}" alt="{{ $perangkat->nama }}">
                            @else
                                <div class="placeholder">👤</div>
                            @endif
                            <div class="card-content">
                                <h5 class="fw-bold mb-1">{{ $perangkat->nama }}</h5>
                                <p class="small mb-0">{{ $perangkat->jabatan }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Dummy Data -->
                    <div class="swiper-slide">
                        <div class="perangkat-slide-card">
                            <div class="placeholder">👤</div>
                            <div class="card-content">
                                <h5 class="fw-bold mb-1">SUPANDI, S. SI, M. SI</h5>
                                <p class="small mb-0">Kaur Umum dan Perencanaan</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="perangkat-slide-card">
                            <div class="placeholder">👤</div>
                            <div class="card-content">
                                <h5 class="fw-bold mb-1">SUPRIADI</h5>
                                <p class="small mb-0">Kadus I Manunggal Jaya</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="perangkat-slide-card">
                            <div class="placeholder">👤</div>
                            <div class="card-content">
                                <h5 class="fw-bold mb-1">MAY MAYANTIKA, S.K.M</h5>
                                <p class="small mb-0">Kadus IV Maju Jaya</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="perangkat-slide-card">
                            <div class="placeholder">👤</div>
                            <div class="card-content">
                                <h5 class="fw-bold mb-1">ZARIMA, A,Md</h5>
                                <p class="small mb-0">Kadus II Dusun Mekar Jaya</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="perangkat-slide-card">
                            <div class="placeholder">👤</div>
                            <div class="card-content">
                                <h5 class="fw-bold mb-1">SUMARDI</h5>
                                <p class="small mb-0">Kadus III Mukti Jaya</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            
            <div class="swiper-pagination mt-4"></div>
            
            @php $baganPerangkat = $bagans->filter(fn($b) => str_contains(strtolower($b->nama), 'perangkat')); @endphp
            @if($baganPerangkat->count() > 0)
                <div class="row">
                    @foreach($baganPerangkat as $bagan)
                        <div class="col-12 text-center mt-5" data-aos="fade-up">
                            <button class="btn btn-outline-primary rounded-pill px-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBagan{{ $bagan->id }}" aria-expanded="false" aria-controls="collapseBagan{{ $bagan->id }}" style="border-color: var(--gold); color: var(--coklat-tua); font-weight: 600;">
                                <i class="bi bi-diagram-3-fill me-2"></i>Lihat {{ $bagan->nama }}
                            </button>
                            <p class="text-muted small mt-2 d-md-none"><i class="bi bi-zoom-in"></i> Ketuk gambar untuk memperbesar</p>
                            
                            <div class="collapse mt-4" id="collapseBagan{{ $bagan->id }}">
                                <div class="card card-body border-0 shadow-sm rounded-4 bg-white text-center">
                                    @if($bagan->gambar)
                                        <a href="{{ Storage::disk('s3')->url('images/struktur/' . $bagan->gambar) }}" data-fancybox="bagan-gallery" data-caption="{{ $bagan->nama }}" class="d-block text-decoration-none">
                                            <img src="{{ Storage::disk('s3')->url('images/struktur/' . $bagan->gambar) }}" alt="{{ $bagan->nama }}" class="img-fluid rounded shadow-sm mx-auto d-block" style="max-width: 100%; cursor: zoom-in;">
                                        </a>
                                        <div class="mt-3">
                                            <a href="{{ route('profil.downloadBagan', $bagan->id) }}" class="btn btn-sm btn-light border rounded-pill">
                                                <i class="bi bi-download me-1"></i> Download Bagan
                                            </a>
                                        </div>
                                    @else
                                        <div class="py-4 border border-dashed rounded bg-light text-muted">
                                            <p class="mb-0">Gambar {{ $bagan->nama }} belum diunggah.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
                </div> <!-- End White Card Wrapper -->
            </div> <!-- End col-lg-8 -->
        </div> <!-- End row -->
    </div>
</section>

{{-- 6. LEMBAGA DESA (PKK & BPD) --}}
<section class="section-spacing bg-light-cream">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <!-- White Card Wrapper -->
                <div class="bg-white rounded-4 shadow-sm border p-4 p-md-5 mb-5" data-aos="fade-up">
            
            <!-- Header Section -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 border-bottom pb-3 gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-4 d-flex align-items-center justify-content-center shadow-sm text-white" style="width: 65px; height: 65px; background: rgba(61, 31, 10, 0.85); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1);">
                        <i class="bi bi-diagram-3-fill fs-2"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-coklat-tua mb-1">Lembaga Desa</h4>
                        <p class="text-muted small mb-0">Susunan Kepengurusan BPD & PKK</p>
                    </div>
                </div>
            </div>

            <ul class="nav nav-pills mb-4" id="lembagaTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill px-4" id="bpd-tab" data-bs-toggle="tab" data-bs-target="#bpd-tab-pane" type="button" role="tab" style="font-weight: 600;">BPD</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill px-4 mx-2" id="pkk-tab" data-bs-toggle="tab" data-bs-target="#pkk-tab-pane" type="button" role="tab" style="font-weight: 600;">Tim Penggerak PKK</button>
                </li>
            </ul>

        <div class="tab-content" id="lembagaTabContent">
            <!-- BPD Tab -->
            <div class="tab-pane fade show active" id="bpd-tab-pane" role="tabpanel" tabindex="0">
                <div class="swiper bpd-swiper" data-aos="fade-up" data-aos-delay="100">
                    <div class="swiper-wrapper">
                        @forelse($bpd as $anggota)
                            <div class="swiper-slide">
                                <div class="perangkat-slide-card">
                                    @if($anggota->foto)
                                        <img src="{{ Storage::disk('s3')->url('images/lembaga/' . $anggota->foto) }}" alt="{{ $anggota->nama }}">
                                    @else
                                        <div class="placeholder">👤</div>
                                    @endif
                                    <div class="card-content">
                                        <h5 class="fw-bold mb-1">{{ $anggota->nama }}</h5>
                                        <p class="small mb-0">{{ $anggota->jabatan }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted py-5">
                                <p>Data struktur BPD belum tersedia. Admin dapat menambahkannya melalui Panel Admin.</p>
                                <!-- Fallback image if data empty -->
                                <img src="{{ Storage::disk('s3')->url('images/lembaga/struktur-bpd.jpg') }}" alt="Struktur BPD Sementara" style="max-width: 100%; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);" onerror="this.style.display='none'">
                            </div>
                        @endforelse
                    </div>
                    <div class="swiper-pagination bpd-pagination mt-4"></div>
                    
                    @php $baganBpd = $bagans->filter(fn($b) => str_contains(strtolower($b->nama), 'bpd')); @endphp
                    @if($baganBpd->count() > 0)
                        <div class="row">
                            @foreach($baganBpd as $bagan)
                                <div class="col-12 text-center mt-5" data-aos="fade-up">
                                    <button class="btn btn-outline-primary rounded-pill px-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBagan{{ $bagan->id }}" aria-expanded="false" aria-controls="collapseBagan{{ $bagan->id }}" style="border-color: var(--gold); color: var(--coklat-tua); font-weight: 600;">
                                        <i class="bi bi-diagram-3-fill me-2"></i>Lihat {{ $bagan->nama }}
                                    </button>
                                    <p class="text-muted small mt-2 d-md-none"><i class="bi bi-zoom-in"></i> Ketuk gambar untuk memperbesar</p>
                                    
                                    <div class="collapse mt-4" id="collapseBagan{{ $bagan->id }}">
                                        <div class="card card-body border-0 shadow-sm rounded-4 bg-white text-center">
                                            @if($bagan->gambar)
                                                <a href="{{ Storage::disk('s3')->url('images/struktur/' . $bagan->gambar) }}" data-fancybox="bagan-gallery" data-caption="{{ $bagan->nama }}" class="d-block text-decoration-none">
                                                    <img src="{{ Storage::disk('s3')->url('images/struktur/' . $bagan->gambar) }}" alt="{{ $bagan->nama }}" class="img-fluid rounded shadow-sm mx-auto d-block" style="max-width: 100%; cursor: zoom-in;">
                                                </a>
                                                <div class="mt-3">
                                                    <a href="{{ route('profil.downloadBagan', $bagan->id) }}" class="btn btn-sm btn-light border rounded-pill">
                                                        <i class="bi bi-download me-1"></i> Download Bagan
                                                    </a>
                                                </div>
                                            @else
                                                <div class="py-4 border border-dashed rounded bg-light text-muted">
                                                    <p class="mb-0">Gambar {{ $bagan->nama }} belum diunggah.</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- PKK Tab -->
            <div class="tab-pane fade" id="pkk-tab-pane" role="tabpanel" tabindex="0">
                <div class="swiper pkk-swiper" data-aos="fade-up" data-aos-delay="100">
                    <div class="swiper-wrapper">
                        @forelse($pkk as $anggota)
                            <div class="swiper-slide">
                                <div class="perangkat-slide-card">
                                    @if($anggota->foto)
                                        <img src="{{ Storage::disk('s3')->url('images/lembaga/' . $anggota->foto) }}" alt="{{ $anggota->nama }}">
                                    @else
                                        <div class="placeholder">👤</div>
                                    @endif
                                    <div class="card-content">
                                        <h5 class="fw-bold mb-1">{{ $anggota->nama }}</h5>
                                        <p class="small mb-0">{{ $anggota->jabatan }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted py-5">
                                <p>Data struktur Tim Penggerak PKK belum tersedia. Admin dapat menambahkannya melalui Panel Admin.</p>
                                <!-- Fallback image if data empty -->
                                <img src="{{ Storage::disk('s3')->url('images/lembaga/struktur-pkk.jpg') }}" alt="Struktur PKK Sementara" style="max-width: 100%; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);" onerror="this.style.display='none'">
                            </div>
                        @endforelse
                    </div>
                    <div class="swiper-pagination pkk-pagination mt-4"></div>
                    
                    @php $baganPkk = $bagans->filter(fn($b) => str_contains(strtolower($b->nama), 'pkk')); @endphp
                    @if($baganPkk->count() > 0)
                        <div class="row">
                            @foreach($baganPkk as $bagan)
                                <div class="col-12 text-center mt-5" data-aos="fade-up">
                                    <button class="btn btn-outline-primary rounded-pill px-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBagan{{ $bagan->id }}" aria-expanded="false" aria-controls="collapseBagan{{ $bagan->id }}" style="border-color: var(--gold); color: var(--coklat-tua); font-weight: 600;">
                                        <i class="bi bi-diagram-3-fill me-2"></i>Lihat {{ $bagan->nama }}
                                    </button>
                                    <p class="text-muted small mt-2 d-md-none"><i class="bi bi-zoom-in"></i> Ketuk gambar untuk memperbesar</p>
                                    
                                    <div class="collapse mt-4" id="collapseBagan{{ $bagan->id }}">
                                        <div class="card card-body border-0 shadow-sm rounded-4 bg-white text-center">
                                            @if($bagan->gambar)
                                                <a href="{{ Storage::disk('s3')->url('images/struktur/' . $bagan->gambar) }}" data-fancybox="bagan-gallery" data-caption="{{ $bagan->nama }}" class="d-block text-decoration-none">
                                                    <img src="{{ Storage::disk('s3')->url('images/struktur/' . $bagan->gambar) }}" alt="{{ $bagan->nama }}" class="img-fluid rounded shadow-sm mx-auto d-block" style="max-width: 100%; cursor: zoom-in;">
                                                </a>
                                                <div class="mt-3">
                                                    <a href="{{ route('profil.downloadBagan', $bagan->id) }}" class="btn btn-sm btn-light border rounded-pill">
                                                        <i class="bi bi-download me-1"></i> Download Bagan
                                                    </a>
                                                </div>
                                            @else
                                                <div class="py-4 border border-dashed rounded bg-light text-muted">
                                                    <p class="mb-0">Gambar {{ $bagan->nama }} belum diunggah.</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        </div> <!-- End White Card Wrapper -->
            </div>
        </div>
        @php 
            $baganLainnya = $bagans->reject(fn($b) => 
                str_contains(strtolower($b->nama), 'perangkat') || 
                str_contains(strtolower($b->nama), 'bpd') || 
                str_contains(strtolower($b->nama), 'pkk')
            );
        @endphp
        @if($baganLainnya->count() > 0)
        <div class="text-center mt-5" data-aos="fade-up">
            <button class="btn btn-outline-primary rounded-pill px-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBaganLainnya" aria-expanded="false" aria-controls="collapseBaganLainnya" style="border-color: var(--gold); color: var(--coklat-tua); font-weight: 600;">
                <i class="bi bi-diagram-3-fill me-2"></i>Lihat Bagan Struktur Lainnya
            </button>
            <p class="text-muted small mt-2 d-md-none"><i class="bi bi-zoom-in"></i> Ketuk gambar untuk memperbesar / melihat detail</p>
        </div>
        <div class="collapse mt-4" id="collapseBaganLainnya">
            <div class="card card-body border-0 shadow-sm rounded-4 bg-white text-center">
                <div class="row g-5">
                    @foreach($baganLainnya as $bagan)
                    <div class="col-12 {{ !$loop->first ? 'mt-5' : '' }}">
                        <h5 class="font-serif text-coklat-tua text-center mb-3">{{ $bagan->nama }}</h5>
                        @if($bagan->gambar)
                            <a href="{{ Storage::disk('s3')->url('images/struktur/' . $bagan->gambar) }}" data-fancybox="bagan-gallery" data-caption="{{ $bagan->nama }}" class="d-block text-decoration-none">
                                <img src="{{ Storage::disk('s3')->url('images/struktur/' . $bagan->gambar) }}" alt="{{ $bagan->nama }}" class="img-fluid rounded shadow-sm mx-auto d-block" style="max-width: 100%; cursor: zoom-in;">
                            </a>
                            <div class="mt-3">
                                <a href="{{ route('profil.downloadBagan', $bagan->id) }}" class="btn btn-sm btn-light border rounded-pill">
                                    <i class="bi bi-download me-1"></i> Download Bagan
                                </a>
                            </div>
                        @else
                            <div class="py-4 border border-dashed rounded bg-light text-muted">
                                <p class="mb-0">Gambar {{ $bagan->nama }} belum diunggah.</p>
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </div>
</section>

{{-- 7. PETA LOKASI DAN KEPEMIMPINAN --}}
<section class="section-spacing">
    <div class="container">
        
        <!-- PERJALANAN KEPEMIMPINAN -->
        <div class="kepemimpinan-card" data-aos="fade-up">
            <div class="kepemimpinan-header">
                <i class="bi bi-people-fill fs-4"></i>
                <span class="fs-5">Perjalanan Kepemimpinan Desa</span>
            </div>
            
            <div class="timeline-line">
                <!-- Data Statis 1 Periode saat ini -->
                <div class="timeline-node">
                    <div class="timeline-content">
                        <div class="periode">2024 - 2029</div>
                        <h6>{{ $namaKades }}</h6>
                        <div class="jabatan">{{ $jabatanKades }}</div>
                    </div>
                </div>
            </div>
            
            <div class="kepemimpinan-note">
                <i class="bi bi-info-circle-fill fs-5 text-gold"></i>
                Sejak berdiri hingga saat ini, desa terus berkembang berkat kerja sama antara pemerintah desa, lembaga, dan seluruh masyarakat.
            </div>
        </div>

        <!-- PETA LOKASI -->
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="badge-peta"><i class="bi bi-geo-alt-fill"></i> PETA LOKASI</div>
            <h2 class="font-serif fw-bold text-coklat-tua">Peta Lokasi {{ $settings['nama_desa'] ?? 'Desa Tanjung Harapan' }}</h2>
            <p class="text-muted">Informasi geografis dan batas wilayah {{ $settings['nama_desa'] ?? 'Desa Tanjung Harapan' }}, {{ $settings['nama_kecamatan'] ?? 'Kecamatan Kampar Kiri' }} {{ $settings['nama_kabupaten'] ?? 'Kabupaten Kampar' }}</p>
        </div>
        
        <div class="map-card-container">
            <!-- Kolom Info Batas -->
            <div class="map-info-side" data-aos="fade-right">
                <div class="batas-header">
                    <div class="icon-circle-black"><i class="bi bi-map"></i></div>
                    Batas Wilayah Desa
                </div>
                
                <div class="batas-grid">
                    <div class="batas-item">
                        <div class="batas-icon-arrow"><i class="bi bi-arrow-up"></i></div>
                        <div>
                            <div class="label">Batas Utara</div>
                            <div class="value">{{ $settings['batas_utara'] ?? 'Desa Sungai Paku / Desa Sungai Sarik (Kecamatan Kampar Kiri)' }}</div>
                        </div>
                    </div>
                    <div class="batas-item">
                        <div class="batas-icon-arrow"><i class="bi bi-arrow-down"></i></div>
                        <div>
                            <div class="label">Batas Selatan</div>
                            <div class="value">{{ $settings['batas_selatan'] ?? 'Desa Teluk Paman (Kecamatan Kampar Kiri)' }}</div>
                        </div>
                    </div>
                    <div class="batas-item">
                        <div class="batas-icon-arrow"><i class="bi bi-arrow-right"></i></div>
                        <div>
                            <div class="label">Batas Timur</div>
                            <div class="value">{{ $settings['batas_timur'] ?? 'Desa Kuntu / Desa Kuntu Darussalam' }}</div>
                        </div>
                    </div>
                    <div class="batas-item">
                        <div class="batas-icon-arrow"><i class="bi bi-arrow-left"></i></div>
                        <div>
                            <div class="label">Batas Barat</div>
                            <div class="value">{{ $settings['batas_barat'] ?? 'Hutan Lindung / Desa Siabu' }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="batas-stats">
                    <div class="b-stat-item">
                        <i class="bi bi-map b-stat-icon"></i>
                        <div class="b-stat-info">
                            <div class="val">{{ $settings['luas_wilayah'] ?? '46.266 M' }}</div>
                            <div class="lbl">Total luas wilayah</div>
                        </div>
                    </div>
                    <div class="b-stat-item">
                        <i class="bi bi-people b-stat-icon"></i>
                        <div class="b-stat-info">
                            <div class="val">{{ $settings['jumlah_penduduk'] ?? '-' }}</div>
                            <div class="lbl">Jumlah penduduk</div>
                        </div>
                    </div>
                </div>
                
                <div class="map-footer-note">
                    <i class="bi bi-pin-map"></i> Data bersumber dari Pemerintah {{ $settings['nama_desa'] ?? 'Desa Tanjung Harapan' }}.
                </div>
            </div>
            
            <!-- Kolom Embed Maps -->
            <div class="map-embed-side" data-aos="zoom-in" data-aos-delay="200">
                @if(!empty($settings['link_map']))
                    <iframe 
                        src="{{ $settings['link_map'] }}" 
                        width="100%" 
                        height="100%" 
                        style="border:0; display:block; min-height: 500px;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                @else
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127670.36873523455!2d101.12187765103217!3d0.015386657954302097!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5b1285bf8a48b%3A0xf601df52b04c8f25!2sKampar%20Kiri%2C%20Kabupaten%20Kampar%2C%20Riau!5e0!3m2!1sid!2sid!4v1704123456789!5m2!1sid!2sid" 
                        width="100%" 
                        height="100%" 
                        style="border:0; display:block; min-height: 500px;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                @endif
            </div>
        </div>

    </div>
</section>

{{-- ── MODAL KEHADIRAN PERANGKAT ── --}}
<div id="modal-kehadiran" style="
    display:none; position:fixed; inset:0; z-index:9999;
    background:rgba(0,0,0,.5); backdrop-filter:blur(3px);
    align-items:center; justify-content:center; padding:1rem;
    font-family:'Poppins',sans-serif;
" onclick="if(event.target===this) tutupModalKehadiran()">
    <div style="
        background:#fff; border-radius:20px;
        width:100%; max-width:480px;
        max-height:90vh; overflow:hidden;
        box-shadow: 0 25px 60px rgba(0,0,0,.25);
        display:flex; flex-direction:column;
        animation: modalSlideUp .3s ease;
    ">
        {{-- Modal Header --}}
        <div style="background:var(--coklat-tua);padding:1.1rem 1.4rem;display:flex;align-items:center;justify-content:space-between;flex-shrink:0">
            <div style="display:flex;align-items:center;gap:.75rem">
                <div style="width:38px;height:38px;background:rgba(255,255,255,.1);border-radius:10px;display:flex;align-items:center;justify-content:center">
                    <i class="bi bi-clipboard2-check-fill" style="color:var(--gold);font-size:1.1rem"></i>
                </div>
                <div>
                    <div style="font-weight:700;color:#fff;font-size:1rem;line-height:1.2">Kehadiran Perangkat</div>
                    <div style="color:rgba(255,255,255,.75);font-size:.75rem" id="modal-tanggal">Memuat...</div>
                </div>
            </div>
            <div style="display:flex;gap:.5rem;align-items:center">
                <button onclick="muatDataKehadiran()" title="Refresh" style="width:34px;height:34px;border-radius:50%;background:rgba(255,255,255,.15);border:none;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:.2s" onmouseover="this.style.background='rgba(255,255,255,.25)'" onmouseout="this.style.background='rgba(255,255,255,.15)'">
                    <i class="bi bi-arrow-clockwise" id="icon-refresh"></i>
                </button>
                <button onclick="tutupModalKehadiran()" style="width:34px;height:34px;border-radius:50%;background:rgba(255,255,255,.15);border:none;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:.2s" onmouseover="this.style.background='rgba(255,255,255,.25)'" onmouseout="this.style.background='rgba(255,255,255,.15)'">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>

        {{-- Statistik --}}
        <div id="modal-stat" style="display:flex;border-bottom:1px solid #f1f5f9;flex-shrink:0">
            <div style="flex:1;text-align:center;padding:.9rem .5rem;border-right:1px solid #f1f5f9">
                <div style="font-size:1.8rem;font-weight:800;color:#16a34a;line-height:1" id="stat-hadir">-</div>
                <div style="font-size:.7rem;font-weight:700;color:#16a34a;text-transform:uppercase;letter-spacing:1px">Hadir</div>
            </div>
            <div style="flex:1;text-align:center;padding:.9rem .5rem;border-right:1px solid #f1f5f9">
                <div style="font-size:1.8rem;font-weight:800;color:#d97706;line-height:1" id="stat-izin">-</div>
                <div style="font-size:.7rem;font-weight:700;color:#d97706;text-transform:uppercase;letter-spacing:1px">Izin</div>
            </div>
            <div style="flex:1;text-align:center;padding:.9rem .5rem">
                <div style="font-size:1.8rem;font-weight:800;color:#64748b;line-height:1" id="stat-belum">-</div>
                <div style="font-size:.7rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:1px">Belum</div>
            </div>
        </div>

        {{-- Daftar Perangkat --}}
        <div id="modal-list" style="overflow-y:auto;flex:1;padding:.5rem 0">
            <div style="text-align:center;padding:2rem;color:#94a3b8">
                <div class="spinner-border spinner-border-sm" role="status"></div>
                <div style="margin-top:.5rem;font-size:.85rem">Memuat data...</div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes modalSlideUp {
    from { opacity: 0; transform: translateY(30px) scale(0.97); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}
#modal-list::-webkit-scrollbar { width: 4px; }
#modal-list::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>

@endsection

@push('scripts')
<script>
// ── MODAL KEHADIRAN PERANGKAT ──
const API_ABSENSI_URL = '{{ route("api.absensi") }}';

function bukaModalKehadiran() {
    const modal = document.getElementById('modal-kehadiran');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    muatDataKehadiran();
}

function tutupModalKehadiran() {
    document.getElementById('modal-kehadiran').style.display = 'none';
    document.body.style.overflow = '';
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') tutupModalKehadiran(); });

function muatDataKehadiran() {
    const iconRefresh = document.getElementById('icon-refresh');
    iconRefresh.style.animation = 'spin 1s linear infinite';
    document.getElementById('modal-list').innerHTML = `
        <div style="text-align:center;padding:2rem;color:#94a3b8">
            <div class="spinner-border spinner-border-sm" role="status"></div>
            <div style="margin-top:.5rem;font-size:.85rem">Memuat data...</div>
        </div>`;

    fetch(API_ABSENSI_URL)
        .then(r => r.json())
        .then(res => {
            iconRefresh.style.animation = '';
            document.getElementById('modal-tanggal').textContent = res.tanggal || '';
            document.getElementById('stat-hadir').textContent = res.hadir ?? 0;
            document.getElementById('stat-izin').textContent  = res.izin  ?? 0;
            document.getElementById('stat-belum').textContent = res.belum ?? 0;

            if (!res.data || res.data.length === 0) {
                document.getElementById('modal-list').innerHTML = `
                    <div style="text-align:center;padding:2rem;color:#94a3b8;font-size:.9rem">
                        <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem"></i>
                        Belum ada data perangkat
                    </div>`;
                return;
            }

            const statusIcon = {
                hadir: `<div style="width:28px;height:28px;background:#dcfce7;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="bi bi-check-circle-fill" style="color:#16a34a;font-size:.85rem"></i></div>`,
                izin:  `<div style="width:28px;height:28px;background:#fef3c7;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="bi bi-info-circle-fill" style="color:#d97706;font-size:.85rem"></i></div>`,
                belum: `<div style="width:28px;height:28px;background:#f1f5f9;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="bi bi-dash-circle-fill" style="color:#94a3b8;font-size:.85rem"></i></div>`,
            };

            let html = '';
            res.data.forEach(p => {
                const inisial = p.nama.charAt(0).toUpperCase();
                const fotoHtml = p.foto
                    ? `<img src="${p.foto}" alt="${p.nama}"
                           style="width:42px;height:42px;border-radius:50%;object-fit:cover;border:2px solid #f1f5f9;flex-shrink:0"
                           onerror="this.outerHTML='<div style=\'width:42px;height:42px;border-radius:50%;background:#fee2e2;color:#c0392b;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.9rem;flex-shrink:0\'>${inisial}</div>'">`
                    : `<div style="width:42px;height:42px;border-radius:50%;background:#fee2e2;color:#c0392b;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.9rem;flex-shrink:0">${inisial}</div>`;

                html += `
                <div style="display:flex;align-items:center;gap:.85rem;padding:.7rem 1.25rem;border-bottom:1px solid #f8fafc">
                    ${fotoHtml}
                    <div style="flex:1;min-width:0">
                        <div style="font-weight:700;font-size:.88rem;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${p.nama}</div>
                        <div style="font-size:.75rem;color:#94a3b8;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${p.jabatan}</div>
                    </div>
                    ${statusIcon[p.status] || statusIcon.belum}
                </div>`;
            });

            document.getElementById('modal-list').innerHTML = html;
        })
        .catch(() => {
            iconRefresh.style.animation = '';
            document.getElementById('modal-list').innerHTML = `
                <div style="text-align:center;padding:2rem;color:#ef4444;font-size:.9rem">
                    <i class="bi bi-exclamation-triangle" style="font-size:2rem;display:block;margin-bottom:.5rem"></i>
                    Gagal memuat data. Silakan coba lagi.
                </div>`;
        });
}
</script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Fancybox.bind("[data-fancybox]", {
            // Options
        });
        const swiperConfig = {
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: 'auto',
            loop: true,
            coverflowEffect: {
                rotate: 0,
                stretch: 0,
                depth: 150,
                modifier: 1.5,
                slideShadows: false,
            },
            breakpoints: {
                // when window width is >= 992px (desktop)
                992: {
                    coverflowEffect: {
                        stretch: -20, // tarik slide samping lebih rapat ke tengah di desktop
                        depth: 250,
                        modifier: 1,
                    }
                }
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            }
        };

        new Swiper('.perangkat-swiper', {
            ...swiperConfig,
            pagination: { el: '.swiper-pagination', clickable: true },
        });

        new Swiper('.bpd-swiper', {
            ...swiperConfig,
            pagination: { el: '.bpd-pagination', clickable: true },
        });

        new Swiper('.pkk-swiper', {
            ...swiperConfig,
            pagination: { el: '.pkk-pagination', clickable: true },
        });
    });
</script>

<style>
    
    /* Fix Swiper Dots Overlap */
    .swiper {
        padding-bottom: 50px !important;
        padding-top: 20px !important; /* Memberi ruang untuk shadow coverflow */
    }
    .swiper-pagination {
        bottom: 0 !important;
    }
    
    /* Coverflow Slide Styling */
    .perangkat-swiper .swiper-slide,
    .bpd-swiper .swiper-slide,
    .pkk-swiper .swiper-slide {
        width: 320px; /* Fixed width for desktop */
        opacity: 0.5; /* Faded by default */
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    
    @media (max-width: 992px) {
        .perangkat-swiper .swiper-slide,
        .bpd-swiper .swiper-slide,
        .pkk-swiper .swiper-slide {
            width: 280px; 
        }
    }
    @media (max-width: 576px) {
        .perangkat-swiper .swiper-slide,
        .bpd-swiper .swiper-slide,
        .pkk-swiper .swiper-slide {
            width: 240px; 
        }
    }
    
    .perangkat-swiper .swiper-slide-active,
    .bpd-swiper .swiper-slide-active,
    .pkk-swiper .swiper-slide-active {
        opacity: 1; /* Fully visible in center */
    }
    
    
    .org-card {
        background: #ffffff;
        border: 2px solid #c9963a;
        border-radius: 12px;
        padding: 12px 15px;
        box-shadow: 0 4px 15px rgba(201, 150, 58, 0.15);
        color: #3d1f0a;
        font-family: 'Inter', sans-serif;
        min-width: 140px;
        text-align: center;
        transition: transform 0.3s;
    }
    .org-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(201, 150, 58, 0.25);
    }
    .org-card .nama {
        font-weight: bold;
        font-size: 0.95rem;
        margin-bottom: 4px;
        white-space: nowrap;
    }
    .org-card .jabatan {
        font-size: 0.8rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* === DESKTOP ONLY: Perkecil card bagan gambar & card perangkat === */
    @media (min-width: 768px) {
        /* Card putih bagan: fit ke gambar, tidak ada space putih sama sekali */
        .card.card-body.rounded-4 {
            padding: 0 !important;
            overflow: hidden;
            max-width: 65% !important;
            margin: 0 auto !important;
            display: block;
            position: relative !important;
        }
        /* Gambar bagan mengisi card 100% */
        .card.card-body.rounded-4 > a {
            display: block;
        }
        .card.card-body.rounded-4 img.img-fluid {
            width: 100% !important;
            max-width: 100% !important;
            display: block !important;
            margin: 0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
        }
        /* Tombol download: overlay di sudut kanan bawah gambar */
        .card.card-body.rounded-4 > .mt-3 {
            position: absolute !important;
            bottom: 12px !important;
            right: 12px !important;
            margin: 0 !important;
            padding: 0 !important;
            z-index: 10;
        }
        .card.card-body.rounded-4 > .mt-3 .btn {
            background: rgba(0, 0, 0, 0.55) !important;
            color: #fff !important;
            border: none !important;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            font-size: 0.78rem !important;
            padding: 0.35rem 0.85rem !important;
            border-radius: 20px !important;
        }
        .card.card-body.rounded-4 > .mt-3 .btn:hover {
            background: rgba(0, 0, 0, 0.78) !important;
        }

    }
</style>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {packages:["orgchart"]});
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        // --- DATA PERANGKAT DESA ---
        var dataPerangkat = new google.visualization.DataTable();
        dataPerangkat.addColumn('string', 'Name');
        dataPerangkat.addColumn('string', 'Manager');
        dataPerangkat.addColumn('string', 'ToolTip');

        @php
            $kadesId = $perangkats->where('urutan', 1)->first()->id ?? '';
            $sekdesId = $perangkats->where('urutan', 2)->first()->id ?? $kadesId;
        @endphp

        var perangkatRows = [
            @php
                $lastKadusId = null;
            @endphp
            @foreach($perangkats as $p)
                @php
                    $parentId = '';
                    $jabatan = strtolower($p->jabatan);
                    $isKadus = (strpos($jabatan, 'kadus') !== false || strpos($jabatan, 'dusun') !== false);
                    
                    if ($p->id == $kadesId) {
                        $parentId = '';
                    } elseif (strpos($jabatan, 'sekretaris') !== false) {
                        $parentId = (string)$kadesId;
                    } elseif (strpos($jabatan, 'kaur') !== false && strpos($jabatan, 'pelayanan') === false) {
                        // Kaur Umum, Kaur Keuangan, Kaur Perencanaan -> di bawah Sekdes
                        $parentId = (string)$sekdesId;
                    } elseif ($isKadus) {
                        // Susun Kadus ke bawah (vertikal)
                        if ($lastKadusId !== null) {
                            $parentId = (string)$lastKadusId;
                        } else {
                            $parentId = (string)$kadesId;
                        }
                        $lastKadusId = $p->id;
                    } else {
                        // Kasi dan Kaur Pelayanan -> di bawah Kades
                        $parentId = (string)$kadesId;
                    }
                @endphp
                [
                    {
                        v: '{{ $p->id }}',
                        f: `<div class="org-card"><div class="nama">{{ $p->nama }}</div><div class="jabatan">{{ $p->jabatan }}</div></div>`
                    },
                    '{{ $parentId }}',
                    '{{ $p->jabatan }}'
                ],
            @endforeach
        ];
        
        if (perangkatRows.length > 0) {
            dataPerangkat.addRows(perangkatRows);
            var chartPerangkat = new google.visualization.OrgChart(document.getElementById('chart_perangkat'));
            chartPerangkat.draw(dataPerangkat, {allowHtml:true, allowCollapse:true});
        }

        // --- DATA BPD ---
        var dataBpd = new google.visualization.DataTable();
        dataBpd.addColumn('string', 'Name');
        dataBpd.addColumn('string', 'Manager');
        dataBpd.addColumn('string', 'ToolTip');

        @php
            $ketuaBpdId = $bpd->where('urutan', 1)->first()->id ?? '';
        @endphp

        var bpdRows = [
            @foreach($bpd as $b)
                @php
                    $parentId = ($b->urutan > 1) ? (string)$ketuaBpdId : '';
                @endphp
                [
                    {
                        v: '{{ $b->id }}',
                        f: `<div class="org-card"><div class="nama">{{ $b->nama }}</div><div class="jabatan">{{ $b->jabatan }}</div></div>`
                    },
                    '{{ $parentId }}',
                    '{{ $b->jabatan }}'
                ],
            @endforeach
        ];

        if (bpdRows.length > 0) {
            dataBpd.addRows(bpdRows);
            var chartBpd = new google.visualization.OrgChart(document.getElementById('chart_bpd'));
            chartBpd.draw(dataBpd, {allowHtml:true, allowCollapse:true});
        }

        // --- DATA PKK ---
        var dataPkk = new google.visualization.DataTable();
        dataPkk.addColumn('string', 'Name');
        dataPkk.addColumn('string', 'Manager');
        dataPkk.addColumn('string', 'ToolTip');

        @php
            $pembinaId = $pkk->where('urutan', 8)->first()->id ?? '';
            $pjKetuaId = $pkk->where('urutan', 9)->first()->id ?? $pembinaId;
            $wakilId = $pkk->where('urutan', 10)->first()->id ?? $pjKetuaId;
        @endphp

        var pkkRows = [
            @php
                $lastNodeForGroup = [];
            @endphp
            @foreach($pkk as $pk)
                @php
                    $parentId = '';
                    $jabatanUpper = strtoupper($pk->jabatan);
                    if ($pk->urutan == 9) {
                        $parentId = (string)$pembinaId;
                    } elseif ($pk->urutan == 10) {
                        $parentId = (string)$pjKetuaId;
                    } elseif ($pk->urutan == 11 || $pk->urutan == 12) {
                        $parentId = (string)$wakilId;
                    } else {
                        // Cek apakah ini bagian dari POKJA
                        if (preg_match('/POKJA\s+([A-Z]+)/i', $jabatanUpper, $matches)) {
                            $group = $matches[1];
                            if (strpos($jabatanUpper, 'KETUA') !== false) {
                                $parentId = (string)$wakilId;
                                $lastNodeForGroup[$group] = $pk->id;
                            } elseif (strpos($jabatanUpper, 'ANGGOTA') !== false) {
                                if (isset($lastNodeForGroup[$group])) {
                                    // Sambungkan ke anggota sebelumnya agar membentuk list vertikal (ke bawah)
                                    $parentId = (string)$lastNodeForGroup[$group];
                                    $lastNodeForGroup[$group] = $pk->id; 
                                } else {
                                    $parentId = (string)$wakilId;
                                }
                            }
                        } else {
                            if ($pk->id != $pembinaId) $parentId = (string)$wakilId;
                        }
                    }
                @endphp
                [
                    {
                        v: '{{ $pk->id }}',
                        f: `<div class="org-card"><div class="nama">{{ $pk->nama }}</div><div class="jabatan">{{ $pk->jabatan }}</div></div>`
                    },
                    '{{ $parentId }}',
                    '{{ $pk->jabatan }}'
                ],
            @endforeach
        ];

        if (pkkRows.length > 0) {
            dataPkk.addRows(pkkRows);
            var chartPkk = new google.visualization.OrgChart(document.getElementById('chart_pkk'));
            chartPkk.draw(dataPkk, {allowHtml:true, allowCollapse:true});
        }
    }
    
    // Redraw charts when collapse is shown to fix width rendering issues
    document.getElementById('collapseBaganPerangkat').addEventListener('shown.bs.collapse', function () {
        drawCharts();
    });
    document.getElementById('collapseBaganLembaga').addEventListener('shown.bs.collapse', function () {
        drawCharts();
    });
</script>
@endpush
