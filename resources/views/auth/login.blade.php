<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Desa Tanjung Harapan</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --coklat-tua: #3D1F0A;
            --coklat-medium: #6B3F1F;
            --gold: #C9963A;
            --cream-light: #FAF6EF;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--cream-light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 1rem;
        }
        .login-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(61, 31, 10, 0.08);
            overflow: hidden;
            width: 100%;
            max-width: 1000px;
            display: flex;
            min-height: 550px;
        }
        
        /* Left Panel - Branding */
        .login-brand {
            background: linear-gradient(145deg, var(--coklat-tua) 0%, var(--coklat-medium) 100%);
            width: 45%;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
        }
        .login-brand::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23c9963a' fill-opacity='0.08'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
            z-index: 0;
        }
        .login-brand > * {
            z-index: 1;
            position: relative;
        }
        .brand-logo {
            width: 120px;
            height: 120px;
            object-fit: contain;
            margin-bottom: 2rem;
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.3));
        }
        .brand-title {
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 1.5rem;
        }
        .brand-subtitle {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gold);
            margin-bottom: 0.5rem;
            letter-spacing: 0.5px;
        }
        .brand-location {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.7);
            line-height: 1.5;
        }

        /* Right Panel - Form */
        .login-form-wrapper {
            width: 55%;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .form-header {
            margin-bottom: 2.5rem;
        }
        .form-header h3 {
            font-weight: 700;
            color: var(--coklat-tua);
            margin-bottom: 0.5rem;
        }
        .form-header p {
            color: #6c757d;
            font-size: 0.95rem;
        }

        /* Clean Inputs */
        .form-label {
            font-weight: 600;
            color: var(--coklat-tua);
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }
        .input-group {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: #f8fafc;
        }
        .input-group:focus-within {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(201, 150, 58, 0.1);
            background: #ffffff;
        }
        .input-group-text {
            background: transparent;
            border: none;
            color: #94a3b8;
            padding-left: 1.2rem;
        }
        .input-group:focus-within .input-group-text {
            color: var(--gold);
        }
        .form-control {
            border: none;
            background: transparent;
            padding: 0.8rem 1rem;
            color: var(--coklat-tua);
            font-weight: 500;
        }
        .form-control:focus {
            box-shadow: none;
            background: transparent;
        }
        .form-control::placeholder {
            color: #cbd5e1;
            font-weight: 400;
        }
        
        .btn-toggle-password {
            background: transparent;
            border: none;
            color: #94a3b8;
            padding-right: 1.2rem;
        }
        .btn-toggle-password:hover {
            color: var(--coklat-tua);
        }

        .form-check-input {
            border-color: #cbd5e1;
        }
        .form-check-input:checked {
            background-color: var(--gold);
            border-color: var(--gold);
        }
        .form-check-label {
            color: #64748b;
            font-size: 0.9rem;
        }

        .btn-login {
            background: var(--coklat-tua);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.9rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }
        .btn-login:hover {
            background: var(--coklat-medium);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(107, 63, 31, 0.2);
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #ef4444;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.85rem;
            margin-bottom: 2rem;
        }

        /* Mobile specific adjustments */
        .mobile-brand {
            display: none;
            text-align: center;
            margin-bottom: 2.5rem;
        }
        .mobile-brand img {
            width: 80px;
            margin-bottom: 1rem;
        }
        .mobile-brand h3 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--coklat-tua);
            margin-bottom: 0.3rem;
        }
        .mobile-brand p.sub {
            color: var(--gold);
            font-weight: 600;
            margin-bottom: 0.2rem;
        }
        .mobile-brand p.loc {
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 0;
        }

        @media (max-width: 991px) {
            .login-card {
                flex-direction: column;
                max-width: 500px;
            }
            .login-brand {
                display: none; /* Hide left panel on mobile */
            }
            .login-form-wrapper {
                width: 100%;
                padding: 2.5rem 2rem;
            }
            .form-header {
                display: none; /* Replaced by mobile-brand */
            }
            .mobile-brand {
                display: block;
            }
        }
    </style>
</head>
<body>

    <div class="login-card">
        <!-- BRANDING PANEL (KIRI) -->
        <div class="login-brand">
            <img src="{{ asset('images/logo_desa.png') }}" alt="Logo Kampar" class="brand-logo">
            <h1 class="brand-title">Selamat Datang di Portal Admin</h1>
            <div class="brand-details">
                <div class="brand-subtitle">Desa Tanjung Harapan</div>
                <div class="brand-location">
                    Kecamatan Kampar Kiri<br>
                    Kabupaten Kampar
                </div>
            </div>
        </div>

        <!-- FORM PANEL (KANAN) -->
        <div class="login-form-wrapper">
            
            <!-- Muncul khusus di layar HP (Mobile) -->
            <div class="mobile-brand">
                <img src="{{ asset('images/logo_desa.png') }}" alt="Logo Kampar">
                <h3>Portal Admin</h3>
                <p class="sub">Desa Tanjung Harapan</p>
                <p class="loc">Kec. Kampar Kiri, Kab. Kampar</p>
            </div>

            <!-- Header khusus PC -->
            <div class="form-header">
                <h3>Otentikasi Sistem</h3>
                <p>Silakan masukkan kredensial Anda untuk melanjutkan.</p>
            </div>

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
                
                <div class="mb-4">
                    <label class="form-label">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="admin@tanjungharapan.desa.id" value="{{ old('email') }}" required autofocus autocomplete="username">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required autocomplete="current-password">
                        <button class="btn-toggle-password" type="button" id="togglePassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            Ingat sesi saya
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-login w-100">
                    Masuk ke Dashboard <i class="bi bi-arrow-right ms-2"></i>
                </button>
                
                <div class="text-center mt-4">
                    <a href="/" class="text-decoration-none" style="font-size: 0.85rem; color: #94a3b8;">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </form>
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
