<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Dashboard') | Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Trix Editor -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>

    <!-- Driver.js (Onboarding Tour) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css"/>
    <style>
        trix-toolbar [data-trix-button-group="file-tools"] { display: none; }
        
        /* Premium Trix Editor Styling */
        trix-editor {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            background: #f8fafc;
            min-height: 400px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
        }
        trix-editor:focus {
            outline: none;
            border-color: var(--gold);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(201, 150, 58, 0.15), inset 0 2px 4px rgba(0,0,0,0.01);
        }
        
        /* Trix Toolbar Customization */
        trix-toolbar {
            background: #ffffff;
            padding: 0.75rem;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            margin-bottom: 1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            display: flex; gap: 0.5rem; flex-wrap: wrap;
        }
        trix-toolbar .trix-button-group {
            border: none;
            background: #f1f5f9;
            border-radius: 8px;
            padding: 0.25rem;
            margin-bottom: 0;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);
        }
        trix-toolbar .trix-button {
            border: none;
            border-radius: 6px;
            background: transparent;
            color: #64748b;
            transition: all 0.2s ease;
            width: 2.5rem; height: 2.5rem;
            display: flex; align-items: center; justify-content: center;
        }
        trix-toolbar .trix-button:hover {
            background: #ffffff;
            color: var(--gold);
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
            transform: translateY(-1px);
        }
        trix-toolbar .trix-button.trix-active {
            background: var(--gold);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(201, 150, 58, 0.3);
        }
        trix-toolbar .trix-button::before {
            opacity: 0.8;
            filter: none; /* Remove default trix filters */
        }
        trix-toolbar .trix-button.trix-active::before {
            filter: brightness(0) invert(1);
        }
        /* Add subtle icon on empty editor */
        trix-editor:empty::before {
            content: "✨ Mulai ketikkan berita yang menarik di sini...";
            color: #94a3b8;
            font-style: italic;
        }
    </style>
    
    <style>
        :root {
            --coklat-tua:    #3D1F0A;
            --coklat-medium: #6B3F1F;
            --gold:          #C9963A;
            --gold-light:    #E8B95A;
            --cream:         #F5ECD7;
            --sidebar-w:     260px;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f4f6f9; }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            background: linear-gradient(180deg, #3D1F0A 0%, #2C1507 100%); /* 1. Gradient halus */
            position: fixed;
            top: 0; left: 0;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 100;
            border-right: 3px solid var(--gold);
        }
        /* 4. Scrollbar tipis cantik */
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(201,150,58,.3); border-radius: 10px; }
        .sidebar::-webkit-scrollbar-thumb:hover { background: rgba(201,150,58,.6); }
        .sidebar { scrollbar-width: thin; scrollbar-color: rgba(201,150,58,.3) transparent; }

        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(201,150,58,.3);
            display: flex; align-items: center; gap: .75rem;
        }
        .sidebar-brand .icon { font-size: 1.8rem; }
        .sidebar-brand .text { color: #fff; font-weight: 700; font-size: .95rem; line-height: 1.2; }
        .sidebar-brand .sub  { color: var(--gold-light); font-size: .7rem; }

        .sidebar-menu { padding: 1rem 0; }
        .menu-label { color: rgba(255,255,255,.4); font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; padding: .75rem 1.5rem .25rem; }
        .sidebar-link {
            display: flex; align-items: center; gap: .75rem;
            padding: .7rem 1.25rem;
            margin: 2px 0.75rem;
            border-radius: 10px;
            color: rgba(255,255,255,.7);
            text-decoration: none;
            font-size: .875rem;
            font-weight: 500;
            transition: all .25s ease;
        }
        /* 3. Hover hidup — ikon geser + latar lembut */
        .sidebar-link:hover {
            color: rgba(255,255,255,.95);
            background: rgba(255,255,255,.07);
            padding-left: 1.45rem;
        }
        .sidebar-link:hover i { color: var(--gold-light); }
        /* 2. Menu aktif kapsul emas */
        .sidebar-link.active {
            color: var(--coklat-tua);
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            font-weight: 700;
            box-shadow: 0 3px 12px rgba(201,150,58,.25);
        }
        .sidebar-link.active i { color: var(--coklat-tua); }
        .sidebar-link i { font-size: 1.1rem; width: 20px; transition: color .25s ease; }

        /* TOPBAR */
        .topbar {
            margin-left: var(--sidebar-w);
            background: #fff;
            border-bottom: 1px solid #e9ecef;
            padding: .875rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky; top: 0; z-index: 99;
        }
        .topbar-title { font-weight: 700; color: var(--coklat-tua); font-size: 1rem; }
        .topbar-user { display: flex; align-items: center; gap: .5rem; font-size: .875rem; color: #6c757d; }
        .topbar-user .avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--cream); border: 2px solid var(--gold);
            display: flex; align-items: center; justify-content: center;
            color: var(--coklat-tua); font-weight: 700; font-size: .8rem;
        }

        /* MAIN CONTENT */
        .main-content { margin-left: var(--sidebar-w); padding: 1.5rem; min-height: 100vh; }
        
        /* DROPDOWN CUSTOM */
        @keyframes dropdownScale { 0% { opacity: 0; transform: scale(0.95); } 100% { opacity: 1; transform: scale(1); } }
        .dropdown-menu.show {
            transform-origin: top right;
            animation: dropdownScale 0.25s cubic-bezier(0.2, 0.8, 0.2, 1) forwards !important;
        }
        .custom-hover:hover { background: #f1f5f9 !important; transform: translateX(3px); transition: all 0.2s; }
        .custom-hover-danger:hover { background: #fef2f2 !important; transform: translateX(3px); transition: all 0.2s; }

        /* STAT CARDS */
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            border: none;
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
            display: flex; align-items: center; gap: 1rem;
        }
        .stat-card .stat-icon {
            width: 52px; height: 52px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
        }
        .stat-card .stat-number { font-size: 1.8rem; font-weight: 800; color: var(--coklat-tua); line-height: 1; }
        .stat-card .stat-label  { font-size: .8rem; color: #6c757d; font-weight: 500; }

        .card-admin { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.06); border: none; }
        .card-admin .card-header { background: var(--coklat-tua); color: #fff; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.25rem; font-weight: 600; }
        .card-admin .card-header .text-gold { color: var(--gold) !important; }

        .btn-sm-gold { background: var(--gold); color: var(--coklat-tua); border: none; border-radius: 6px; padding: .3rem .75rem; font-size: .8rem; font-weight: 600; }

        @media(max-width: 768px) {
            .sidebar { 
                transform: translateX(-100%); 
                transition: transform 0.3s ease; 
            }
            .sidebar.show { 
                transform: translateX(0); 
            }
            .topbar, .main-content { margin-left: 0; }
        }

        /* Mobile Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5); 
            z-index: 99;
            backdrop-filter: blur(2px);
        }
        .sidebar-overlay.show { display: block; }
    </style>
    @stack('styles')
</head>
<body>

<!-- Mobile Overlay -->
<div class="sidebar-overlay" id="sidebar-overlay"></div>

{{-- SIDEBAR --}}
<div class="sidebar">
    <div class="sidebar-brand">
        <div class="icon">
            <img src="{{ asset('images/logo_desa.png') }}" alt="Logo" style="width: 36px; height: 36px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));">
        </div>
        <div>
            <div class="text">Admin Panel</div>
            <div class="sub">{{ \App\Models\Setting::where('key', 'nama_desa')->value('value') ?? 'Website Desa' }}</div>
        </div>
    </div>
    <div class="sidebar-menu">
        <div class="menu-label">Utama</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid"></i> Dashboard
        </a>
        <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
            <i class="bi bi-box-arrow-up-right"></i> Lihat Website
        </a>

        <div class="menu-label mt-2">Konten</div>
        <a href="{{ route('admin.berita.index') }}" class="sidebar-link {{ request()->routeIs('admin.berita*') ? 'active' : '' }}">
            <i class="bi bi-newspaper"></i> Berita & Pengumuman
        </a>
        <a href="{{ route('admin.slider.index') }}" class="sidebar-link {{ request()->routeIs('admin.slider*') ? 'active' : '' }}">
            <i class="bi bi-images"></i> Slider Hero
        </a>
        <a href="{{ route('admin.potensi.index') }}" class="sidebar-link {{ request()->routeIs('admin.potensi*') ? 'active' : '' }}">
            <i class="bi bi-gem"></i> Potensi Desa
        </a>
        <a href="{{ route('admin.perangkat.index') }}" class="sidebar-link {{ request()->routeIs('admin.perangkat*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Perangkat Desa
        </a>

        <div class="menu-label mt-2">Layanan & Keuangan</div>
        <a href="{{ route('admin.pengaduan.index') }}" class="sidebar-link {{ request()->routeIs('admin.pengaduan*') ? 'active' : '' }}">
            <i class="bi bi-chat-dots"></i> Pengaduan
        </a>
        <a href="{{ route('admin.apbdes.index') }}" class="sidebar-link {{ request()->routeIs('admin.apbdes*') ? 'active' : '' }}">
            <i class="bi bi-wallet2"></i> Transparansi APBDes
        </a>
        <a href="{{ route('admin.setting.index') }}" class="sidebar-link {{ request()->routeIs('admin.setting*') ? 'active' : '' }}">
            <i class="bi bi-gear"></i> Setting Desa
        </a>

        <div class="menu-label mt-2">Akun</div>
        <form method="POST" action="{{ route('logout') }}" id="form-logout">
            @csrf
            <button type="button" id="btn-logout" class="sidebar-link w-100 border-0 text-start" style="background:none; cursor:pointer;">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </form>
    </div>
</div>

{{-- TOPBAR --}}
<div class="topbar">
    <div class="d-flex align-items-center gap-2">
        <button id="sidebar-toggle" class="btn btn-light d-md-none border-0 p-1" style="background: transparent; color: var(--coklat-tua);">
            <i class="bi bi-list" style="font-size: 1.8rem; line-height: 1;"></i>
        </button>
        <div class="topbar-title mb-0">@yield('title', 'Dashboard')</div>
    </div>
    
    <div class="flex-grow-1 mx-4 overflow-hidden d-none d-md-block">
        <marquee behavior="scroll" direction="left" scrollamount="5" style="color: var(--gold); font-weight: 500; font-size: 0.85rem; padding-top: 4px;">
            <i class="bi bi-geo-alt-fill me-1"></i> Alamat: {{ \App\Models\Setting::where('key', 'alamat_desa')->value('value') ?? 'Alamat belum diatur. Silakan atur di menu Setting Desa.' }}
        </marquee>
    </div>

    <div class="topbar-user dropdown" id="admin-profile-menu">
        <div class="d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
            <div class="d-none d-md-block text-start">
                <span class="d-block fw-bold" style="color: var(--coklat-tua); line-height: 1;">{{ auth()->user()->name ?? 'Admin' }}</span>
                <small class="text-muted" style="font-size: 0.75rem;">Administrator</small>
            </div>
            <i class="bi bi-chevron-down ms-1 text-muted" style="font-size: 0.8rem;"></i>
        </div>
        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 p-0" style="border-radius: 16px; min-width: 260px; overflow: hidden;">
            <li>
                <div class="dropdown-header text-center p-4" style="background: linear-gradient(135deg, var(--coklat-tua) 0%, #2c1507 100%);">
                    <div class="avatar mx-auto mb-3" style="width: 56px; height: 56px; font-size: 1.5rem; background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%); border: 3px solid rgba(255,255,255,0.2); color: var(--coklat-tua); box-shadow: 0 4px 10px rgba(0,0,0,0.3);">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <h6 class="mb-1 fw-bold text-white">{{ auth()->user()->name ?? 'Admin' }}</h6>
                    <small style="color: rgba(255,255,255,0.7); font-size: 0.75rem;">{{ auth()->user()->email ?? 'admin@desa.id' }}</small>
                </div>
            </li>
            <li class="p-2 bg-white">
                <a class="dropdown-item rounded-3 py-2 px-3 mb-1 d-flex align-items-center custom-hover" href="{{ route('admin.profile.index') }}">
                    <div class="me-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: #f8fafc; color: var(--coklat-tua);">
                        <i class="bi bi-person-gear"></i>
                    </div>
                    <span class="fw-semibold text-dark" style="font-size: 0.9rem;">Pengaturan Akun</span>
                </a>
                <a class="dropdown-item rounded-3 py-2 px-3 d-flex align-items-center text-danger custom-hover-danger" href="#" id="dropdown-logout">
                    <div class="me-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: #fef2f2; color: #ef4444;">
                        <i class="bi bi-box-arrow-right"></i>
                    </div>
                    <span class="fw-semibold" style="font-size: 0.9rem;">Keluar dari Panel</span>
                </a>
            </li>
        </ul>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="main-content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3">
            {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3">
            {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Sidebar Toggle Logic for Mobile
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.querySelector('.sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        if(sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('show');
                sidebarOverlay.classList.toggle('show');
            });
        }
        if(sidebarOverlay) {
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            });
        }

        // Logout Logic
        function confirmLogout(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Keluar dari Panel?',
                text: "Anda harus login kembali untuk masuk.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3D1F0A', // Warna Coklat Tua
                cancelButtonColor: '#f1f5f9', // Abu-abu terang
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: '<span style="color: #475569">Batal</span>',
                customClass: {
                    confirmButton: 'px-4 rounded-pill',
                    cancelButton: 'px-4 rounded-pill border-0',
                    popup: 'rounded-4 mx-3' // mx-3 memberikan jarak aman di HP
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-logout').submit();
                }
            })
        }

        let btnLogout = document.getElementById('btn-logout');
        if(btnLogout) btnLogout.addEventListener('click', confirmLogout);

        let dropLogout = document.getElementById('dropdown-logout');
        if(dropLogout) dropLogout.addEventListener('click', confirmLogout);
    </script>
    
    <!-- Driver.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>
    
    @if(!session('tour_admin_completed'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const driver = window.driver.js.driver;
            const driverObj = driver({
                showProgress: false,
                animate: true,
                doneBtnText: 'Mengerti',
                steps: [
                    { 
                        element: '#admin-profile-menu', 
                        popover: { 
                            title: 'Profil & Pengaturan', 
                            description: 'Klik di sini untuk melihat profil Anda, mengubah pengaturan akun, atau melakukan Logout dengan aman.', 
                            side: "left", 
                            align: 'start' 
                        } 
                    }
                ]
            });
            
            // Mulai tour dengan delay sedikit agar animasi awal selesai
            setTimeout(() => {
                driverObj.drive();
            }, 500);
        });
    </script>
    @php session(['tour_admin_completed' => true]) @endphp
    @endif
    
    @stack('scripts')
</body>
</html>
