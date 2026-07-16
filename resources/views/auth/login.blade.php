<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - {{ \App\Models\Setting::where('key', 'nama_desa')->value('value') ?? 'Panel Desa' }}</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --gold: #c9963a;
            --gold-light: #e4b764;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            /* Background gambar full screen */
            background: url("{{ asset('images/sliders/slider1.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            position: relative;
            overflow: hidden; /* No scrolling */
        }
        /* Overlay gelap agar teks terbaca */
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(20, 10, 0, 0.4); 
            z-index: 0;
        }

        .login-container {
            position: relative;
            z-index: 1;
            display: flex;
            width: 100%;
            height: 100vh;
        }

        /* ---------------------------------
           DESKTOP DESIGN (Split Screen)
        -----------------------------------*/
        .login-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 5rem 6rem;
            color: #ffffff;
        }
        
        .login-left h1 {
            font-weight: 800;
            font-size: 3.5rem;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 10px rgba(0,0,0,0.5);
        }

        .login-left p.lead {
            font-size: 1.2rem;
            max-width: 600px;
            color: rgba(255, 255, 255, 0.9);
            text-shadow: 0 2px 5px rgba(0,0,0,0.5);
            margin-bottom: 3rem;
        }

        /* Panel Glass Kanan (Desktop) */
        .login-right {
            width: 500px;
            background: rgba(25, 15, 5, 0.3); /* Gelap kaca */
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-left: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: -15px 0 35px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .glass-card {
            width: 100%;
            padding: 3rem 4rem;
            color: #ffffff;
        }

        /* Logo CSS */
        .village-logo {
            width: 130px;
            height: 130px;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .village-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.4));
        }

        .village-logo-mobile {
            display: none; /* Sembunyi di Desktop */
        }

        /* Text Form */
        .glass-card h2 {
            font-weight: 800;
            margin-bottom: 0.2rem;
            letter-spacing: 0.5px;
        }
        .glass-card p.subtitle {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.95rem;
            margin-bottom: 2.5rem;
        }

        /* Form Inputs Glass */
        .form-control, .input-group-text {
            background: rgba(0, 0, 0, 0.2) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
            padding: 0.8rem 1rem;
        }
        .form-control:focus {
            background: rgba(0, 0, 0, 0.3) !important;
            border-color: var(--gold-light) !important;
            box-shadow: 0 0 0 4px rgba(201, 150, 58, 0.2) !important;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        .input-group-text {
            color: var(--gold-light) !important;
            border-right: none !important;
        }
        .form-control.with-icon {
            border-left: none !important;
        }
        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0.4rem;
        }

        /* Checkbox Glass */
        .form-check-input {
            background-color: rgba(0,0,0,0.2);
            border-color: rgba(255,255,255,0.3);
        }
        .form-check-input:checked {
            background-color: var(--gold);
            border-color: var(--gold);
        }
        .form-check-label {
            color: rgba(255, 255, 255, 0.85);
        }

        /* Tombol Emas */
        .btn-login {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border: none;
            color: white;
            padding: 1rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s;
            box-shadow: 0 8px 20px rgba(201, 150, 58, 0.3);
        }
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(201, 150, 58, 0.4);
            color: white;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #fca5a5;
            border-radius: 12px;
            padding: 10px;
            font-size: 0.85rem;
            backdrop-filter: blur(5px);
        }

        /* ---------------------------------
           MOBILE DESIGN (Centered Glass Card)
        -----------------------------------*/
        @media (max-width: 991px) {
            .login-container {
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 1.5rem;
            }
            .login-left {
                display: none; /* Sembunyikan teks besar di mobile */
            }
            
            /* Pada mobile, login-right kehilangan bentuk panel tingginya */
            .login-right {
                width: 100%;
                max-width: 450px;
                background: transparent; 
                backdrop-filter: none;
                -webkit-backdrop-filter: none;
                border: none;
                box-shadow: none;
            }

            /* Efek kaca dipindah ke glass-card untuk mobile */
            .glass-card {
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.3);
                border-radius: 24px;
                box-shadow: 0 25px 45px rgba(0, 0, 0, 0.2);
                padding: 2.5rem 2rem;
                text-align: center;
            }

            .village-logo-mobile {
                display: flex; /* Muncul di Mobile */
                width: 90px;
                height: 90px;
                margin: 0 auto 1.5rem auto;
            }
            .village-logo-mobile img {
                width: 100%;
                height: 100%;
                object-fit: contain;
                filter: drop-shadow(0 8px 12px rgba(0,0,0,0.4));
            }

            .glass-card form {
                text-align: left; /* Kembalikan text form rata kiri */
            }
            
            .glass-card h2 { font-size: 1.6rem; }
            .mb-4 { margin-bottom: 1.2rem !important; }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <!-- DESKTOP KIRI -->
        <div class="login-left">
            <div class="village-logo">
                <img src="{{ asset('images/logo_desa.png') }}" alt="Logo Desa">
            </div>
            <h1>Sistem Informasi<br>Manajemen Desa</h1>
            <p class="lead">Kelola seluruh potensi, data aparatur, dan layanan pengaduan warga dalam satu pintu panel digital yang modern dan transparan.</p>
            <div class="mt-4">
                <a href="/" class="btn btn-outline-light px-4 py-2" style="border-radius: 20px; font-weight: 500;">
                    <i class="bi bi-globe me-2"></i> Kunjungi Website Utama
                </a>
            </div>
        </div>

        <!-- KANAN / MOBILE CENTER -->
        <div class="login-right">
            <div class="glass-card">
                
                <!-- Muncul hanya di mobile -->
                <div class="village-logo-mobile">
                    <img src="{{ asset('images/logo_desa.png') }}" alt="Logo Desa">
                </div>
                
                @php
                    $namaDesa = \App\Models\Setting::where('key', 'nama_desa')->value('value');
                @endphp
                
                <h2>Panel Admin</h2>
                <p class="subtitle">{{ $namaDesa ? $namaDesa : 'Sistem Informasi Manajemen Desa' }}</p>

                <!-- Pesan Error -->
                @if ($errors->any())
                    <div class="alert-error mb-4">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" name="email" class="form-control with-icon" placeholder="admin@desa.id" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Kata Sandi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" name="password" id="password" class="form-control with-icon" placeholder="••••••••" required>
                            <button class="btn" type="button" id="togglePassword" style="background: rgba(0, 0, 0, 0.2); border: 1px solid rgba(255, 255, 255, 0.2); border-left: none; color: rgba(255,255,255,0.7);">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4 d-flex align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label small" for="remember">
                                Ingat Saya
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login w-100 mb-3">Masuk Sistem <i class="bi bi-box-arrow-in-right ms-2"></i></button>
                    <div class="text-center">
                        <p class="mb-0" style="font-size: 0.8rem; color: rgba(255,255,255,0.6);">
                            &copy; {{ date('Y') }} {{ $namaDesa ?? 'Pemerintah Desa' }}.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>
