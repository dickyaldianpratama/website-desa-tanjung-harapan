<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Website Resmi {{ $settings['nama_desa'] ?? 'Desa' }} - {{ $settings['nama_kecamatan'] ?? '' }}, {{ $settings['nama_kabupaten'] ?? '' }}. Pusat informasi, transparansi, dan pelayanan publik masyarakat desa.">
    <meta name="keywords" content="desa {{ $settings['nama_desa'] ?? '' }}, website desa, pemerintah desa, {{ $settings['nama_kecamatan'] ?? '' }}, {{ $settings['nama_kabupaten'] ?? '' }}, pelayanan desa, potensi desa, transparansi desa">
    <meta name="author" content="Pemerintah {{ $settings['nama_desa'] ?? 'Desa' }}">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Beranda') | {{ $settings['nama_desa'] ?? 'Website Desa' }}">
    <meta property="og:description" content="Website Resmi {{ $settings['nama_desa'] ?? 'Desa' }} - Pusat informasi dan pelayanan digital terpadu untuk kemudahan masyarakat desa.">
    <meta property="og:image" content="{{ asset('images/'.($settings['logo_desa'] ?? 'logo_desa.png')) }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Beranda') | {{ $settings['nama_desa'] ?? 'Website Desa' }}">
    <meta property="twitter:description" content="Website Resmi {{ $settings['nama_desa'] ?? 'Desa' }} - Pusat informasi dan pelayanan digital terpadu untuk kemudahan masyarakat desa.">
    <meta property="twitter:image" content="{{ asset('images/'.($settings['logo_desa'] ?? 'logo_desa.png')) }}">

    <title>@yield('title', 'Beranda') | {{ $settings['nama_desa'] ?? 'Website Desa' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --coklat-tua:    #3D1F0A;
            --coklat-medium: #6B3F1F;
            --coklat-muda:   #A06B42;
            --gold:          #C9963A;
            --gold-light:    #E8B95A;
            --cream:         #F5ECD7;
            --cream-light:   #FAF6EF;
            --putih:         #FFFFFF;
            --teks-gelap:    #1A0F05;
            --teks-abu:      #6C757D;
        }
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--cream-light);
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        h1,h2,h3,h4,h5,.font-serif { font-family:'Playfair Display',serif; }

        .navbar-desa {
            background: transparent;
            border-bottom: none;
            padding: .75rem 0;
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            transition: background .4s ease, box-shadow .4s ease, padding .3s ease;
        }
        .navbar-desa.scrolled, 
        .navbar-desa.solid {
            background: var(--coklat-tua) !important;
            box-shadow: 0 2px 20px rgba(61,31,10,.4);
            padding: .4rem 0;
        }
        .navbar-desa .navbar-brand {
            color: var(--putih) !important;
            font-family: 'Playfair Display', serif;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: .85rem;
        }
        .brand-logo {
            width: 85px;
            height: 85px;
            border-radius: 50%;
            border: 3.5px solid var(--gold);
            background: rgba(255,255,255,.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.8rem;
            color: var(--coklat-tua);
            font-weight: bold;
            padding: 5px;
            backdrop-filter: blur(4px);
            flex-shrink: 0;
            box-shadow: 0 0 0 2px rgba(201,150,58,.3);
            transition: width 0.3s ease, height 0.3s ease;
        }
        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
        }
        
        .navbar-desa.scrolled .brand-logo,
        .navbar-desa.solid .brand-logo { width: 58px; height: 58px; }
        .brand-text .nama {
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
            text-shadow: 0 2px 10px rgba(0,0,0,.6);
            letter-spacing: .3px;
        }
        .brand-text .sub  {
            font-size: .9rem;
            color: var(--gold-light);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600;
            text-shadow: 0 1px 4px rgba(0,0,0,.4);
            letter-spacing: .3px;
        }
        /* RESPONSIVE MOBILE NAVBAR */
        @media (max-width: 768px) {
            .navbar-desa .navbar-brand { max-width: calc(100% - 60px); gap: .4rem; }
            .brand-logo { 
                width: 40px; 
                height: 40px; 
                background: transparent; 
                border: none; 
                box-shadow: none; 
                backdrop-filter: none;
                padding: 0;
            }
            .navbar-desa.scrolled .brand-logo { width: 35px; height: 35px; }
            .brand-text { min-width: 0; /* Penting untuk ellipsis */ }
            .brand-text .nama { 
                font-size: 1.05rem; 
                white-space: nowrap; 
                overflow: hidden; 
                text-overflow: ellipsis; 
            }
            .brand-text .sub { font-size: .75rem; }
            .navbar-toggler { padding: .25rem .5rem; }
        }
        .navbar-desa .nav-link {
            color: rgba(255,255,255,.9) !important;
            font-size: .875rem;
            font-weight: 600;
            padding: .45rem 1rem !important;
            border-radius: 20px;
            transition: all .25s;
            text-shadow: 0 1px 4px rgba(0,0,0,.5);
            letter-spacing: .2px;
            border: 1.5px solid transparent;
        }
        .navbar-desa .nav-link:hover {
            color: var(--gold) !important;
            background: rgba(201,150,58,.15);
            text-shadow: none;
            border-color: rgba(201,150,58,.3);
        }
        .navbar-desa .nav-link.active {
            color: var(--coklat-tua) !important;
            background: var(--gold) !important;
            text-shadow: none;
            border-color: var(--gold);
            font-weight: 700;
        }
        .navbar-toggler { border: none !important; box-shadow: none !important; padding-right:0; }
        .navbar-toggler-icon { filter: invert(1); }

        /* PERBAIKAN OFFCANVAS MENU DI HP */
        @media (max-width: 991px) {
            .offcanvas-lg {
                background: var(--coklat-tua);
                border-left: 1px solid rgba(201,150,58,0.2);
                width: 280px !important;
            }
            .offcanvas-header { border-bottom: 1px solid rgba(255,255,255,0.05); }
            .navbar-desa .nav-link {
                border-radius: 8px;
                padding: 0.8rem 1rem !important;
                border: none;
                border-bottom: 1px solid rgba(255,255,255,0.05);
                text-shadow: none;
                margin-bottom: 2px;
            }
            .navbar-desa .nav-link:last-child { border-bottom: none; }
            .navbar-desa .nav-link.active {
                background: rgba(201,150,58,0.15) !important;
                color: var(--gold) !important;
            }
            .navbar-desa .nav-link:hover {
                background: rgba(255,255,255,0.05);
                transform: translateX(5px);
                color: var(--gold) !important;
            }
        }

        /* SECTION TITLES */
        .section-title { font-family:'Playfair Display',serif; color:var(--coklat-medium); font-size:2rem; font-weight:700; position:relative; margin-bottom:.5rem; }
        .section-title::after { content:''; display:block; width:60px; height:3px; background:var(--gold); margin:.5rem auto 0; }
        .section-title.left::after { margin:.5rem 0 0; }
        .section-subtitle { color:var(--teks-abu); font-size:.95rem; margin-bottom:2.5rem; }

        /* CARDS */
        .card-desa { border:none; border-radius:12px; box-shadow:0 4px 20px rgba(61,31,10,.08); transition:transform .3s,box-shadow .3s; overflow:hidden; background:var(--putih); }
        .card-desa:hover { transform:translateY(-6px); box-shadow:0 12px 35px rgba(61,31,10,.15); }
        .card-desa img { height:200px; object-fit:cover; width:100%; }
        .card-desa .card-body { padding:1.25rem; }
        .badge-kategori { background:var(--cream); color:var(--coklat-medium); font-size:.72rem; font-weight:600; padding:.3rem .75rem; border-radius:20px; text-transform:uppercase; letter-spacing:.5px; }
        .card-desa .card-title { font-family:'Playfair Display',serif; color:var(--coklat-tua); font-size:1rem; font-weight:600; margin:.5rem 0; line-height:1.4; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
        .link-gold { color:var(--gold); font-weight:600; font-size:.88rem; text-decoration:none; }
        .link-gold:hover { color:var(--coklat-medium); }

        /* BUTTONS */
        .btn-desa-primary { background:var(--coklat-tua); color:var(--putih); border:2px solid var(--coklat-tua); border-radius:6px; padding:.6rem 1.5rem; font-weight:600; font-size:.9rem; transition:all .2s; text-decoration:none; display:inline-block; position:relative; z-index:20; cursor:pointer; }
        .btn-desa-primary:hover { background:var(--coklat-medium); border-color:var(--coklat-medium); color:var(--putih); transform:translateY(-1px); }
        .btn-desa-outline { background:transparent; color:var(--putih); border:2px solid var(--putih); border-radius:6px; padding:.6rem 1.5rem; font-weight:600; font-size:.9rem; transition:all .2s; text-decoration:none; display:inline-block; }
        .btn-desa-outline:hover { background:var(--putih); color:var(--coklat-tua); }
        .btn-gold { background:var(--gold); color:var(--coklat-tua); border:none; border-radius:6px; padding:.6rem 1.5rem; font-weight:700; transition:all .2s; }
        .btn-gold:hover { background:var(--gold-light); color:var(--coklat-tua); }

        /* BG COLORS */
        .bg-cream  { background-color:var(--cream)!important; }
        .bg-coklat { background-color:var(--coklat-tua)!important; }
        .text-gold { color:var(--gold)!important; }
        .text-coklat { color:var(--coklat-medium)!important; }

        /* STATS BAR */
        .stats-bar { background:var(--cream); border-bottom:1px solid rgba(201,150,58,.3); padding:2rem 0; }
        .stat-item { text-align:center; padding:.5rem 1rem; }
        .stat-item .stat-number { 
            display: inline-block;
            font-size: 2.4rem; 
            font-weight: 800; 
            color: var(--coklat-tua); 
            line-height: 1.2; 
            letter-spacing: -1px; 
            /* Efek Kaca (Glassmorphism) */
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 0.4rem 1.5rem;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 4px 15px rgba(61,31,10,.05);
            margin-bottom: 0.8rem;
        }
        .stat-item .stat-label  { font-size:.8rem; color:var(--teks-abu); font-weight:500; text-transform:uppercase; letter-spacing:1px; }
        .stat-item .stat-unit   { font-size:.9rem; color:var(--coklat-medium); font-weight:600; }

        /* FOOTER MODERN & PROFESIONAL */
        footer { background:#2A1608; color:rgba(255,255,255,.8); padding:5rem 0 2rem; position:relative; }
        footer::before { content:''; position:absolute; top:0; left:0; width:100%; height:4px; background:linear-gradient(90deg, var(--gold) 0%, var(--gold-light) 100%); }
        .footer-title { color:var(--putih); font-size:1rem; font-weight:700; margin-bottom:1.5rem; letter-spacing:2px; text-transform:uppercase; }
        .footer-links { list-style:none; padding:0; margin:0; }
        .footer-links li { margin-bottom:.8rem; }
        .footer-links a { color:rgba(255,255,255,.7); text-decoration:none; transition:all .3s ease; display:inline-block; }
        .footer-links a:hover { color:var(--gold-light); transform:translateX(8px); }
        .footer-contact-item { display:flex; align-items:flex-start; gap:1rem; margin-bottom:1.2rem; color:rgba(255,255,255,.7); font-size:.9rem; }
        .footer-contact-item i { color:var(--gold); font-size:1.2rem; margin-top:-2px; }
        footer .social-icon { width:42px; height:42px; background:rgba(255,255,255,.05); border-radius:50%; display:inline-flex; align-items:center; justify-content:center; color:var(--putih); font-size:1.1rem; transition:all .3s ease; margin-right:.5rem; text-decoration:none; }
        footer .social-icon:hover { background:var(--gold); color:#2A1608; transform:translateY(-5px); box-shadow:0 10px 20px rgba(201,150,58,.3); }
        footer .footer-bottom { border-top:1px solid rgba(255,255,255,.08); padding-top:2rem; margin-top:3rem; font-size:.85rem; color:rgba(255,255,255,.5); }

        /* PAGE HEADER */
        .page-header { background:linear-gradient(135deg,var(--coklat-tua) 0%,var(--coklat-medium) 100%); padding:3rem 0; color:var(--putih); position:relative; overflow:hidden; }
        .page-header::before { content:''; position:absolute; top:-50%; right:-10%; width:400px; height:400px; background:rgba(201,150,58,.1); border-radius:50%; }
        .page-header h1 { font-family:'Playfair Display',serif; font-size:2rem; }
        .page-header .breadcrumb-item a { color:var(--gold-light); }
        .page-header .breadcrumb-item.active { color:rgba(255,255,255,.7); }
        .page-header .breadcrumb-item+.breadcrumb-item::before { color:rgba(255,255,255,.5); }

        .img-placeholder { background:linear-gradient(135deg,var(--cream),var(--coklat-muda)); display:flex; align-items:center; justify-content:center; color:var(--coklat-medium); font-size:3rem; }

        /* FLOATING ACTION BUTTON (PENGADUAN) */
        .fab-pengaduan {
            position: fixed;
            bottom: 2rem;
            left: 2rem; /* Sesuai letak di screenshot (kiri bawah) */
            background-color: #7373DB; /* Warna ungu dari screenshot */
            color: #fff;
            width: 50px;
            height: 50px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 0 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            cursor: pointer;
            z-index: 1050;
            overflow: hidden;
            transition: width 0.4s ease;
            text-decoration: none;
        }
        .fab-pengaduan i {
            font-size: 1.2rem;
            flex-shrink: 0;
            width: 20px;
        }
        .fab-pengaduan span {
            white-space: nowrap;
            margin-left: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .fab-pengaduan:hover {
            width: 200px;
            color: #fff;
        }
        .fab-pengaduan:hover span {
            opacity: 1;
            transition-delay: 0.1s;
        }

        @media(max-width:768px) {
            .section-title { font-size:1.5rem; }
            .stat-item .stat-number { font-size:1.7rem; }
        }
        /* VISITOR COUNTER WIDGET */
        .visitor-widget-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1045;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            pointer-events: none; /* Cegah container tak terlihat menutupi klik menu */
        }
        .visitor-btn {
            pointer-events: auto; /* Kembalikan event klik untuk tombol */
            background: #50c878; /* Hijau cerah elegan */
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.6rem 1rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        .visitor-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            background: #42b267;
        }
        .visitor-popup {
            background: #4b5563; /* Dark gray like reference */
            color: #f3f4f6;
            padding: 1.25rem;
            border-radius: 12px;
            width: 260px;
            pointer-events: auto; /* Kembalikan event klik untuk popup */
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            margin-bottom: 12px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            font-size: 0.95rem;
        }
        .visitor-popup.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .visitor-btn .toggle-icon {
            transition: transform 0.3s ease;
        }
        .visitor-btn.active .toggle-icon {
            transform: rotate(180deg);
        }

        @media (max-width: 767.98px) {
            .visitor-widget-container {
                bottom: 15px;
                right: 15px;
            }
            .visitor-btn {
                padding: 0.4rem 0.6rem;
                border-radius: 8px;
            }
            .visitor-btn .bi-door-open {
                font-size: 1.5rem !important;
            }
            .visitor-btn small {
                font-size: 0.65rem !important;
            }
            .visitor-btn span {
                font-size: 0.75rem !important;
            }
            .visitor-btn .visitor-count-text {
                font-size: 1.2rem !important;
                margin-left: 0.5rem !important;
            }
        }
        /* CUSTOM PAGINATION */
        .pagination {
            gap: 0.5rem;
        }
        .page-item .page-link {
            border: 1px solid #e5e7eb;
            border-radius: 8px !important;
            color: var(--teks-gelap);
            padding: 0.5rem 1rem;
            font-weight: 500;
            background-color: transparent;
            transition: all 0.3s ease;
            box-shadow: none !important;
        }
        .page-item:not(.active) .page-link:hover {
            background-color: #f3f4f6;
            border-color: #d1d5db;
        }
        .page-item.active .page-link {
            background-color: var(--teks-gelap);
            border-color: var(--teks-gelap);
            color: white;
        }
        .page-item.disabled .page-link {
            color: #9ca3af;
            background-color: transparent;
            border-color: #e5e7eb;
        }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar navbar-desa navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            @php $logo = $settings['logo_desa'] ?? ''; @endphp
            {{-- Lingkaran = div.brand-logo (DIAM), gambar di dalamnya yang FLIP --}}
            <div class="brand-logo">
                @if($logo && file_exists(public_path('images/'.$logo)))
                    <img src="{{ asset('images/'.$logo) }}" alt="Logo Desa">
                @elseif(file_exists(public_path('images/logo_desa.png')))
                    <img src="{{ asset('images/logo_desa.png') }}" alt="Logo Desa">
                @elseif(file_exists(public_path('images/logo_desa.jpg')))
                    <img src="{{ asset('images/logo_desa.jpg') }}" alt="Logo Desa">
                @else
                    🏡
                @endif
            </div>
            <div class="brand-text">
                <div class="nama">{{ $settings['nama_desa'] ?? 'Desa Nusantara' }}</div>
                <div class="sub">{{ $settings['nama_kabupaten'] ?? 'Website Resmi Desa' }}</div>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas-lg offcanvas-end" tabindex="-1" id="navMenu">
            <div class="offcanvas-header d-lg-none d-flex align-items-center justify-content-between px-4 py-3">
                <h5 class="offcanvas-title text-white font-serif mb-0 d-flex align-items-center gap-2">
                    <img src="{{ asset('images/logo_desa.png') }}" alt="Logo" width="30">
                    Menu Utama
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#navMenu" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav gap-1 justify-content-end w-100 px-3 px-lg-0 pb-4 pb-lg-0">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('profil') ? 'active' : '' }}" href="{{ route('profil') }}">Profil Desa</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('berita*') ? 'active' : '' }}" href="{{ route('berita.index') }}">Berita</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('potensi*') ? 'active' : '' }}" href="{{ route('potensi.index') }}">Potensi</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('transparansi') ? 'active' : '' }}" href="{{ route('transparansi') }}">Transparansi</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}" href="{{ route('kontak') }}">Kontak</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<main>@yield('content')</main>

<footer>
    <div class="container">
        <div class="row g-5">
            <!-- Kolom 1: Brand & Profil Singkat -->
            <div class="col-lg-5 pe-lg-5">
                <div class="d-flex align-items-center mb-4">
                    <img src="{{ asset('images/logo_desa.png') }}" alt="Logo Desa" style="width:65px; height:auto; object-fit:contain" class="me-3 drop-shadow-sm">
                    <div>
                        <h4 class="mb-0 font-serif text-white fw-bold" style="font-size: 1.4rem;">{{ $settings['nama_desa'] ?? 'Desa Nusantara' }}</h4>
                        <div style="color:var(--gold); font-size:.85rem; letter-spacing:1px; text-transform:uppercase;" class="mt-1">{{ $settings['nama_kabupaten'] ?? '' }}</div>
                    </div>
                </div>
                <p class="mb-4 text-white-50" style="line-height: 1.8; font-size: .95rem;">
                    Website Resmi {{ $settings['nama_desa'] ?? 'Desa Nusantara' }} hadir sebagai pusat informasi dan pelayanan digital terpadu untuk kemudahan masyarakat desa demi mewujudkan transparansi dan kemajuan bersama.
                </p>
                <div class="d-flex">
                    <a href="{{ $settings['facebook'] ?? '#' }}" class="social-icon"><i class="bi bi-facebook"></i></a>
                    <a href="{{ $settings['instagram'] ?? '#' }}" class="social-icon"><i class="bi bi-instagram"></i></a>
                    <a href="{{ $settings['youtube'] ?? '#' }}" class="social-icon"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

            <!-- Kolom 2: Tautan Cepat -->
            <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                <h5 class="footer-title">Tautan Cepat</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="{{ route('profil') }}">Profil Desa</a></li>
                    <li><a href="{{ route('berita.index') }}">Berita & Pengumuman</a></li>
                    <li><a href="{{ route('potensi.index') }}">Potensi Desa</a></li>
                    <li><a href="{{ route('transparansi') }}">Transparansi APBDes</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Kontak & Pengaduan -->
            <div class="col-lg-4 col-md-6 mt-5 mt-lg-0">
                <h5 class="footer-title">Kontak Kami</h5>
                <div class="footer-contact-item">
                    <i class="bi bi-geo-alt-fill"></i>
                    <div>
                        <strong>Alamat Kantor</strong><br>
                        {{ $settings['alamat'] ?? '-' }}<br>
                        {{ $settings['nama_kecamatan'] ?? '' }}, {{ $settings['nama_kabupaten'] ?? '' }}
                    </div>
                </div>
                <div class="footer-contact-item">
                    <i class="bi bi-telephone-fill"></i>
                    <div>
                        <strong>Telepon</strong><br>
                        {{ $settings['telepon'] ?? '-' }}
                    </div>
                </div>
                <div class="footer-contact-item">
                    <i class="bi bi-envelope-fill"></i>
                    <div>
                        <strong>Email</strong><br>
                        {{ $settings['email'] ?? '-' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container text-center">
            &copy; {{ date('Y') }} Website Resmi {{ $settings['nama_desa'] ?? 'Desa Nusantara' }}. Hak Cipta Dilindungi.
        </div>
    </div>
</footer>

<!-- FLOATING ACTION BUTTON -->
<button type="button" class="fab-pengaduan border-0" data-bs-toggle="modal" data-bs-target="#pengaduanModal">
    <i class="bi bi-headset"></i>
    <span>Kirim Aduan/Saran</span>
</button>

<!-- MODAL PENGADUAN -->
<div class="modal fade" id="pengaduanModal" tabindex="-1" aria-labelledby="pengaduanModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
      <div class="modal-header bg-cream border-0" style="padding: 1.5rem;">
        <h5 class="modal-title fw-bold text-coklat-tua d-flex align-items-center gap-2" id="pengaduanModalLabel">
            <i class="bi bi-megaphone-fill text-gold fs-4"></i> Layanan Aduan & Saran
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="padding: 2rem 1.5rem;">
        <form action="{{ route('kontak.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-floating mb-3">
                <input type="text" class="form-control rounded-4" id="nama" name="nama" placeholder="Nama Lengkap" required>
                <label for="nama"><i class="bi bi-person me-1"></i> Nama Lengkap <span class="text-danger">*</span></label>
            </div>
            
            <div class="form-floating mb-3">
                <input type="tel" class="form-control rounded-4" id="telepon" name="telepon" placeholder="No. Telepon / WhatsApp" required>
                <label for="telepon"><i class="bi bi-whatsapp me-1"></i> No. WhatsApp <span class="text-danger">*</span></label>
            </div>
            
            <div class="row g-3 mb-3">
                <div class="col-6">
                    <div class="form-floating">
                        <select class="form-select rounded-4" id="subjek" name="subjek" required>
                            <option value="Pengaduan">Pengaduan</option>
                            <option value="Saran">Saran / Masukan</option>
                        </select>
                        <label for="subjek"><i class="bi bi-list-check me-1"></i> Jenis <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating">
                        <select class="form-select rounded-4" id="kategori" name="kategori" required>
                            <option value="Infrastruktur">Infrastruktur</option>
                            <option value="Pelayanan">Pelayanan</option>
                            <option value="Keamanan">Keamanan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <label for="kategori"><i class="bi bi-tags me-1"></i> Kategori <span class="text-danger">*</span></label>
                    </div>
                </div>
            </div>
            
            <div class="form-floating mb-3">
                <textarea class="form-control rounded-4" id="pesan" name="pesan" placeholder="Tulis pesan..." style="height: 120px" required></textarea>
                <label for="pesan"><i class="bi bi-chat-text me-1"></i> Isi Pesan <span class="text-danger">*</span></label>
            </div>
            
            <div class="mb-4">
                <label for="lampiran" class="form-label text-muted small fw-bold mb-2">Unggah Bukti/Foto (Max 2MB)</label>
                <input class="form-control form-control-sm rounded-4" style="background-color: var(--cream-light); border-color: rgba(61,31,10,0.1);" type="file" id="lampiran" name="lampiran" accept="image/jpeg,image/png,application/pdf">
            </div>
            
            <button type="submit" class="btn btn-gold w-100 rounded-pill py-2 fw-bold text-uppercase" style="letter-spacing: 1px;">
                <i class="bi bi-send-fill me-2"></i> Kirim & Lanjutkan ke WA
            </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
// Initialize AOS Animation
AOS.init({
    duration: 800,
    easing: 'ease-out-cubic',
    once: true,
    offset: 50,
});

// Navbar: transparan di atas hero, solid saat scroll
(function() {
    const navbar = document.querySelector('.navbar-desa');
    const isHeroPage = document.querySelector('.hero-swiper') !== null;

    if (!isHeroPage) {
        // Halaman tanpa hero → langsung solid
        navbar.classList.add('solid');
    } else {
        // Halaman dengan hero → transparan dulu, solid saat scroll
        window.addEventListener('scroll', function() {
            if (window.scrollY > 60) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }
})();
</script>

<script>
    @if(session('success'))
        alert("{{ session('success') }}");
    @endif

    @if(session('wa_link'))
        window.location.href = "{!! session('wa_link') !!}";
    @endif
</script>

@stack('scripts')
<!-- VISITOR COUNTER WIDGET -->
<div class="visitor-widget-container">
    <div class="visitor-popup" id="visitorPopup">
        <h6 class="mb-3 text-white fw-bold border-bottom pb-2 border-secondary">Jumlah Kunjungan</h6>
        <div class="d-flex justify-content-between mb-2"><span>Hari Ini</span> <span class="fw-bold">{{ number_format($visitorStats['today'] ?? 0, 0, ',', '.') }}</span></div>
        <div class="d-flex justify-content-between mb-2"><span>Kemarin</span> <span class="fw-bold">{{ number_format($visitorStats['yesterday'] ?? 0, 0, ',', '.') }}</span></div>
        <div class="d-flex justify-content-between mb-2"><span>Minggu Ini</span> <span class="fw-bold">{{ number_format($visitorStats['this_week'] ?? 0, 0, ',', '.') }}</span></div>
        <div class="d-flex justify-content-between mb-2"><span>Minggu Lalu</span> <span class="fw-bold">{{ number_format($visitorStats['last_week'] ?? 0, 0, ',', '.') }}</span></div>
        <div class="d-flex justify-content-between mb-2"><span>Bulan Ini</span> <span class="fw-bold">{{ number_format($visitorStats['this_month'] ?? 0, 0, ',', '.') }}</span></div>
        <div class="d-flex justify-content-between mb-2"><span>Bulan Lalu</span> <span class="fw-bold">{{ number_format($visitorStats['last_month'] ?? 0, 0, ',', '.') }}</span></div>
        <div class="d-flex justify-content-between mt-3 pt-2 border-top border-secondary text-gold fw-bold"><span>Total Kunjungan</span> <span>{{ number_format($visitorStats['total'] ?? 0, 0, ',', '.') }}</span></div>
    </div>
    
    <button class="visitor-btn" onclick="toggleVisitorPopup()">
        <div class="d-flex align-items-center">
            <i class="bi bi-door-open display-6 mb-0 lh-1"></i>
            <div class="text-start lh-sm ms-2">
                <small class="d-block fw-bold text-light">Kunjungan</small>
                <span class="d-block fw-bold">Hari Ini <i class="bi bi-chevron-up ms-1 toggle-icon"></i></span>
            </div>
            <div class="fs-4 fw-bold ms-3 visitor-count-text">{{ number_format($visitorStats['today'] ?? 0, 0, ',', '.') }}</div>
        </div>
    </button>
</div>

<script>
    function toggleVisitorPopup() {
        const popup = document.getElementById('visitorPopup');
        const btn = document.querySelector('.visitor-btn');
        popup.classList.toggle('show');
        btn.classList.toggle('active');
    }
</script>

</body>
</html>
