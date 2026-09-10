<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Desa Tanjung Harapan</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --coklat-tua: #3D1F0A;
            --coklat-medium: #6B3F1F;
            --gold: #D4A342;
            --gold-hover: #C19135;
            --bg-light: #F4F7FA;
            --text-dark: #1F2937;
            --text-gray: #6B7280;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-light);
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }
        
        /* HEADER (Top Nav replacement) */
        .top-header {
            background-color: #ffffff;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            z-index: 10;
        }
        .header-logo {
            width: 50px;
            height: 50px;
            object-fit: contain;
            margin-right: 1rem;
        }
        .header-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        .header-title {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--coklat-tua);
            letter-spacing: -0.5px;
        }
        .header-subtitle {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--coklat-medium);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* MAIN WRAPPER */
        .main-wrapper {
            flex: 1;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            width: 100%;
            max-width: 1300px;
            height: 100%;
            max-height: 800px;
            background-color: #ffffff;
            border-radius: 1.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
            display: flex;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
        }

        /* LEFT PANEL (Brown & Gold) */
        .login-left {
            flex: 6;
            background-color: var(--coklat-tua);
            position: relative;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #ffffff;
            overflow: hidden;
        }
        
        /* Hexagon / Geometric Background Pattern */
        .login-left::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='52' height='30' viewBox='0 0 52 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23c9963a' fill-opacity='0.05'%3E%3Cpath d='M13 0l13 15-13 15H0L13 0zm26 0l13 15-13 15H26l13-15L26 0z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: 1;
        }
        /* Gradient Overlay for better text readability */
        .login-left::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(61, 31, 10, 0.9) 0%, rgba(107, 63, 31, 0.7) 100%);
            z-index: 2;
        }

        .left-content {
            position: relative;
            z-index: 3;
            max-width: 600px;
        }
        .left-content h3 {
            font-weight: 500;
            font-size: 1.8rem;
            margin-bottom: 0.2rem;
            color: #f3f4f6;
        }
        .left-content h1 {
            font-weight: 800;
            font-size: 3.5rem;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }
        .left-content h1 span {
            color: var(--gold);
        }
        .left-content p.desc {
            font-size: 1.1rem;
            line-height: 1.6;
            color: rgba(255,255,255,0.85);
            margin-bottom: 3.5rem;
            max-width: 500px;
        }

        /* Features */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }
        .feature-item .icon-circle {
            width: 45px;
            height: 45px;
            border: 1px solid var(--gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }
        .feature-item h6 {
            font-weight: 700;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }
        .feature-item p {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.6);
            line-height: 1.5;
            margin-bottom: 0;
        }

        /* RIGHT PANEL (Form) */
        .login-right {
            flex: 4;
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
        }
        
        .form-wrapper {
            width: 100%;
            max-width: 380px;
        }

        .form-wrapper h2 {
            font-weight: 800;
            color: var(--text-dark);
            text-align: center;
            margin-bottom: 2.5rem;
            font-size: 1.8rem;
        }

        /* Form Inputs (SAIRA Style) */
        .form-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-dark);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }
        .input-group {
            background-color: #F0F4F8;
            border-radius: 8px;
            border: 1px solid transparent;
            transition: all 0.2s ease;
            margin-bottom: 1.5rem;
        }
        .input-group:focus-within {
            border-color: var(--gold);
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(212, 163, 66, 0.1);
        }
        .form-control {
            background: transparent;
            border: none;
            padding: 0.9rem 1rem;
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.95rem;
        }
        .form-control:focus {
            background: transparent;
            box-shadow: none;
        }
        .form-control::placeholder {
            font-weight: 400;
            color: #9CA3AF;
        }
        .input-group-text {
            background: transparent;
            border: none;
            color: #9CA3AF;
            padding-right: 1rem;
        }
        .input-group:focus-within .input-group-text {
            color: var(--gold);
        }

        /* Checkbox & Links */
        .form-check-input {
            border-color: #D1D5DB;
            cursor: pointer;
        }
        .form-check-input:checked {
            background-color: var(--gold);
            border-color: var(--gold);
        }
        .form-check-label {
            font-size: 0.85rem;
            color: var(--text-gray);
            cursor: pointer;
        }

        /* Button */
        .btn-login {
            background-color: var(--gold);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 1rem;
            border-radius: 8px;
            border: none;
            transition: all 0.2s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        .btn-login:hover {
            background-color: var(--gold-hover);
            transform: translateY(-1px);
        }

        /* Alerts */
        .alert-error {
            background-color: #FEF2F2;
            border-left: 4px solid #EF4444;
            color: #991B1B;
            padding: 1rem;
            border-radius: 4px;
            font-size: 0.85rem;
            margin-bottom: 2rem;
        }

        /* Mobile Adjustments */
        @media (max-width: 991px) {
            .main-wrapper {
                padding: 0;
            }
            .login-container {
                border-radius: 0;
                border: none;
                flex-direction: column;
                height: 100vh;
                max-height: none;
            }
            .login-left {
                display: none; /* Hide left panel completely on mobile to match clean form look */
            }
            .login-right {
                flex: 1;
                padding: 2rem;
            }
            .form-wrapper {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- TOP HEADER -->
    <header class="top-header">
        <img src="{{ asset('images/logo_desa.png') }}" alt="Logo Kampar" class="header-logo">
        <div class="header-text">
            <span class="header-title">PORTAL DESA</span>
            <span class="header-subtitle">Pemerintah Kab. Kampar</span>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="main-wrapper">
        <div class="login-container">
            
            <!-- LEFT PANEL -->
            <div class="login-left">
                <div class="left-content">
                    <h3>Selamat Datang di</h3>
                    <h1>Portal Admin <span>Desa</span></h1>
                    <p class="desc">Akses layanan administrasi, informasi kependudukan, pengumuman, dan berbagai kebutuhan manajemen desa dalam satu platform terpadu.</p>
                    
                    <div class="features-grid">
                        <div class="feature-item">
                            <div class="icon-circle">
                                <i class="bi bi-laptop"></i>
                            </div>
                            <h6>Layanan Terintegrasi</h6>
                            <p>Manajemen data desa, kependudukan, dan layanan surat dalam satu atap.</p>
                        </div>
                        <div class="feature-item">
                            <div class="icon-circle">
                                <i class="bi bi-megaphone"></i>
                            </div>
                            <h6>Informasi Terkini</h6>
                            <p>Dapatkan dan publikasikan informasi terbaru seputar kegiatan desa.</p>
                        </div>
                        <div class="feature-item">
                            <div class="icon-circle">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <h6>Kemudahan Akses</h6>
                            <p>Sistem tertutup yang aman untuk tata kelola Pemerintah Desa.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT PANEL (FORM) -->
            <div class="login-right">
                <div class="form-wrapper">
                    <h2>Masuk ke Portal</h2>

                    @if ($errors->any())
                        <div class="alert-error">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <div class="input-group">
                                <input type="email" name="email" class="form-control" placeholder="admin@tanjungharapan.desa.id" value="{{ old('email') }}" required autofocus autocomplete="username">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required autocomplete="current-password">
                                <button type="button" class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                    <i class="bi bi-lock"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">
                                    Ingat Saya
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-login w-100">
                            MASUK KE DASHBOARD <i class="bi bi-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // Ganti icon lock/unlock
            if(type === 'text') {
                this.innerHTML = '<i class="bi bi-unlock"></i>';
            } else {
                this.innerHTML = '<i class="bi bi-lock"></i>';
            }
        });
    </script>
</body>
</html>
