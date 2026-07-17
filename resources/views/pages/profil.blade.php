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
        background: var(--putih);
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
    }
    .kades-card-profil img {
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
        min-height: 400px;
    }
    .sambutan-img-wrap img {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    /* PERANGKAT SWIPER */
    .perangkat-swiper {
        padding: 2rem 1rem;
        padding-bottom: 4rem;
    }
    .perangkat-slide-card {
        background: var(--putih);
        border-radius: 16px;
        padding: 2rem 1.5rem;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .perangkat-slide-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        border-color: rgba(201,150,58,0.3);
    }
    .perangkat-slide-card img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 1.5rem;
        border: 3px solid var(--gold);
    }
    .perangkat-slide-card .placeholder {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: var(--cream);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        margin: 0 auto 1.5rem;
        border: 3px solid var(--gold);
        color: var(--coklat-muda);
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
                    <p class="text-muted fw-bold mb-4" style="letter-spacing: 1px;"><i class="bi bi-person-badge text-gold me-2"></i>Kepala Desa</p>
                    <img src="{{ asset('images/perangkat/kades.jpg') }}" alt="Foto Kades" onerror="this.src='https://ui-avatars.com/api/?name=Kades&background=C9963A&color=fff&size=150'">
                    <h5 class="fw-bold text-coklat-tua mb-1 text-uppercase">{{ $settings['nama_kades'] ?? 'H. Ahmad Suryadi, S.E.' }}</h5>
                    <span class="badge bg-cream px-3 py-2 mt-2 rounded-pill" style="color: var(--coklat-tua) !important;">Kepala {{ $settings['nama_desa'] ?? 'Desa Tanjung Harapan' }}</span>
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
        <div class="sambutan-box">
            <div class="row g-0">
                <div class="col-md-4" data-aos="fade-right">
                    <div class="sambutan-img-wrap">
                        <img src="{{ asset('images/perangkat/kades.jpg') }}" alt="Kepala Desa" onerror="this.src='https://ui-avatars.com/api/?name=Kades&background=C9963A&color=fff&size=500'">
                    </div>
                </div>
                <div class="col-md-8 d-flex align-items-center" data-aos="fade-left">
                    <div class="p-4 p-lg-5">
                        <div class="d-flex align-items-center gap-2 mb-3 text-gold">
                            <i class="bi bi-megaphone-fill"></i>
                            <span class="fw-bold text-uppercase" style="letter-spacing: 2px; font-size: 0.85rem;">Sambutan Kepala Desa</span>
                        </div>
                        <h3 class="fw-bold text-coklat-tua text-uppercase mb-2">{{ $settings['nama_kades'] ?? 'H. Ahmad Suryadi, S.E.' }}</h3>
                        <p class="text-muted fw-semibold mb-4 d-flex align-items-center gap-2"><i class="bi bi-person-vcard"></i> {{ $settings['jabatan_kades'] ?? 'Kepala Desa' }}</p>
                        
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
</section>

{{-- 5. PERANGKAT DESA (SWIPER CAROUSEL) --}}
<section class="section-spacing">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="font-serif fw-bold text-coklat-tua">Perangkat Desa</h2>
            <p class="text-muted d-flex justify-content-center align-items-center gap-2"><i class="bi bi-people-fill text-gold"></i> Aparatur pemerintahan yang siap melayani masyarakat</p>
        </div>

        <div class="swiper perangkat-swiper" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper">
                @forelse($perangkats as $perangkat)
                    <div class="swiper-slide">
                        <div class="perangkat-slide-card">
                            @if($perangkat->foto)
                                <img src="{{ asset('images/perangkat/'.$perangkat->foto) }}" alt="{{ $perangkat->nama }}">
                            @else
                                <div class="placeholder">👤</div>
                            @endif
                            <h5 class="fw-bold text-coklat-tua mb-1 text-uppercase" style="font-size: 1.1rem;">{{ $perangkat->nama }}</h5>
                            <p class="text-secondary small mb-0">{{ $perangkat->jabatan }}</p>
                        </div>
                    </div>
                @empty
                    <!-- Dummy Data -->
                    <div class="swiper-slide">
                        <div class="perangkat-slide-card">
                            <div class="placeholder">👤</div>
                            <h5 class="fw-bold text-coklat-tua mb-1 text-uppercase" style="font-size: 1.1rem;">SUPANDI, S. SI, M. SI</h5>
                            <p class="text-secondary small mb-0">Kaur Umum dan Perencanaan</p>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="perangkat-slide-card">
                            <div class="placeholder">👤</div>
                            <h5 class="fw-bold text-coklat-tua mb-1 text-uppercase" style="font-size: 1.1rem;">SUPRIADI</h5>
                            <p class="text-secondary small mb-0">Kadus I Manunggal Jaya</p>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="perangkat-slide-card">
                            <div class="placeholder">👤</div>
                            <h5 class="fw-bold text-coklat-tua mb-1 text-uppercase" style="font-size: 1.1rem;">MAY MAYANTIKA, S.K.M</h5>
                            <p class="text-secondary small mb-0">Kadus IV Maju Jaya</p>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="perangkat-slide-card">
                            <div class="placeholder">👤</div>
                            <h5 class="fw-bold text-coklat-tua mb-1 text-uppercase" style="font-size: 1.1rem;">ZARIMA, A,Md</h5>
                            <p class="text-secondary small mb-0">Kadus II Dusun Mekar Jaya</p>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="perangkat-slide-card">
                            <div class="placeholder">👤</div>
                            <h5 class="fw-bold text-coklat-tua mb-1 text-uppercase" style="font-size: 1.1rem;">SUMARDI</h5>
                            <p class="text-secondary small mb-0">Kadus III Mukti Jaya</p>
                        </div>
                    </div>
                @endforelse
            </div>
            
            <div class="swiper-pagination mt-4"></div>
        </div>
    </div>
</section>

{{-- 6. PETA LOKASI DAN KEPEMIMPINAN --}}
<section class="section-spacing bg-light-cream">
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
                        <h6 class="text-uppercase">{{ $settings['nama_kades'] ?? 'H. Ahmad Suryadi, S.E.' }}</h6>
                        <div class="jabatan">Kepala Desa</div>
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
                            <div class="value">Jalan Propinsi & Desa Gading Sari</div>
                        </div>
                    </div>
                    <div class="batas-item">
                        <div class="batas-icon-arrow"><i class="bi bi-arrow-down"></i></div>
                        <div>
                            <div class="label">Batas Selatan</div>
                            <div class="value">Desa Petapahan</div>
                        </div>
                    </div>
                    <div class="batas-item">
                        <div class="batas-icon-arrow"><i class="bi bi-arrow-right"></i></div>
                        <div>
                            <div class="label">Batas Timur</div>
                            <div class="value">Desa Indrapuri</div>
                        </div>
                    </div>
                    <div class="batas-item">
                        <div class="batas-icon-arrow"><i class="bi bi-arrow-left"></i></div>
                        <div>
                            <div class="label">Batas Barat</div>
                            <div class="value">Desa Petapahan</div>
                        </div>
                    </div>
                </div>
                
                <div class="batas-stats">
                    <div class="b-stat-item">
                        <i class="bi bi-map b-stat-icon"></i>
                        <div class="b-stat-info">
                            <div class="val">{{ $settings['luas_wilayah'] ?? '1.544 Ha' }}</div>
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
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127670.36873523455!2d101.12187765103217!3d0.015386657954302097!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5b1285bf8a48b%3A0xf601df52b04c8f25!2sKampar%20Kiri%2C%20Kabupaten%20Kampar%2C%20Riau!5e0!3m2!1sid!2sid!4v1704123456789!5m2!1sid!2sid" 
                    width="100%" 
                    height="100%" 
                    style="border:0; display:block; min-height: 500px;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swiper = new Swiper('.perangkat-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: false,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            breakpoints: {
                576: { slidesPerView: 2, spaceBetween: 20 },
                768: { slidesPerView: 3, spaceBetween: 30 },
                992: { slidesPerView: 4, spaceBetween: 30 },
                1200: { slidesPerView: 5, spaceBetween: 30 }
            }
        });
    });
</script>
@endpush
