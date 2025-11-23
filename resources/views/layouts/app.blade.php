<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Beranda') - Toko Saudara 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --color-primary: #5E548E;
            /* Dark Lilac - Teks Utama/Button */
            --color-secondary: #9F86C0;
            /* Medium Lilac - Aksen Sekunder */
            --color-accent: #E0B1CB;
            /* Nude Pink - Navbar/Highlight */
            --color-danger: #E07A5F;
            /* Soft Coral - Flash Sale/Error */
            --color-success: #70C1B3;
            /* Soft Teal - Sukses/Add to Cart */
            --color-light: #F0E6EF;
            /* Very Light Lilac - BG */
            --color-white: #ffffff;
            --gradient-bg: linear-gradient(135deg, #F0E6EF 0%, #D891EF 100%);
            --font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            --border-radius-lg: 15px;
            --border-radius-sm: 8px;
            --container-width: 1200px;
            /* Ukuran container lebih kecil */
        }

        body {
            background: var(--gradient-bg);
            font-family: var(--font-family);
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding-top: 65px;
        }

        /* Navbar & Typography */
        .navbar-custom {
            background-color: var(--color-accent);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1030;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .navbar-brand,
        .navbar-nav .nav-link {
            font-weight: 700;
            color: var(--color-primary) !important;
            transition: color 0.3s;
        }

        /* General Content Container */
        .content-container {
            max-width: var(--container-width);
            margin: 20px auto;
            padding: 25px 15px;
            /* Padding dikurangi */
            background-color: var(--color-white);
            border-radius: var(--border-radius-lg);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            flex: 1;
        }

        /* Custom Button Styling */
        .btn-primary-custom {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            font-weight: 600;
            border-radius: var(--border-radius-sm);
        }

        .btn-primary-custom:hover {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
        }

        .btn-accent {
            background-color: var(--color-danger);
            border-color: var(--color-danger);
            color: white;
            font-weight: 600;
            border-radius: var(--border-radius-sm);
        }

        .btn-success-custom {
            background-color: var(--color-success);
            border-color: var(--color-success);
            color: white;
            font-weight: 600;
            border-radius: var(--border-radius-sm);
        }

        /* Tambahkan di bagian style */
        .btn-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }

        .btn-success {
            background-color: var(--color-success);
            border-color: var(--color-success);
        }

        .btn-info {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
        }

        .btn-warning {
            background-color: var(--color-danger);
            border-color: var(--color-danger);
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        /* Utility Classes */
        .text-theme-primary {
            color: var(--color-primary) !important;
        }

        .bg-theme-accent {
            background-color: var(--color-accent) !important;
        }

        .bg-theme-light {
            background-color: var(--color-light) !important;
        }

        /* Card Styling (DENSITY ADJUSTMENT) */
        .card {
            border-radius: var(--border-radius-lg);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--color-light);
            transition: transform 0.2s;
            /* Tambah transisi */
        }

        .card:hover {
            transform: translateY(-2px);
            /* Efek hover kecil */
        }

        .card-header {
            background-color: var(--color-light);
            color: var(--color-primary);
            font-weight: 600;
            border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0 !important;
            border-bottom: 1px solid var(--color-accent);
            padding: 0.75rem 1.25rem;
            /* Padding header dikurangi */
        }

        .card-body {
            padding: 1.25rem;
            /* Padding body default */
        }

        /* Alerts (fixed position for flash/session messages) */
        .alert-fixed {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            min-width: 300px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Footer */
        footer {
            background-color: var(--color-accent);
            color: var(--color-primary);
        }

        /* Landing Page Specific Styles */
        .hero-section {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            color: white;
            border-radius: var(--border-radius-lg);
            padding: 3rem 2rem;
            margin-bottom: 2rem;
        }

        .feature-card {
            background: white;
            border-radius: var(--border-radius-lg);
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--color-primary);
            margin-bottom: 1rem;
        }

        .product-card {
            border: 1px solid var(--color-light);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            transition: transform 0.3s;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .category-card {
            display: block;
            background: white;
            border-radius: var(--border-radius-lg);
            padding: 1.5rem;
            text-align: center;
            border: 1px solid var(--color-light);
            transition: all 0.3s;
            text-decoration: none;
            color: inherit;
        }

        .category-card:hover {
            background: var(--color-light);
            text-decoration: none;
            color: inherit;
            transform: translateY(-3px);
        }
    </style>
    @stack('styles')
</head>

<body>

    {{-- Alert Section --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show alert-fixed" role="alert">
            <strong>Error:</strong> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show alert-fixed" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show alert-fixed" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @yield('navbar')

    <div class="main-content flex-grow-1">
        @yield('content')
    </div>

    {{-- Footer (Konten lengkap tetap sama) --}}
    <footer class="text-center text-lg-start mt-5">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase text-theme-primary fw-bold">
                        <i class="fas fa-store me-2"></i> TOKO SAUDARA 2
                    </h5>
                    <p class="text-theme-primary">
                        Toko Saudara 2: Belanja cepat, mudah, dan terpercaya. Jaminan produk segar dan berkualitas.
                    </p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase text-theme-primary">Informasi</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="{{ route('about') }}">Tentang Kami</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}">Hubungi Kami</a></li>
                        <li class="mb-2"><a href="{{ route('terms') }}">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase text-theme-primary">Akun</h5>
                    <ul class="list-unstyled mb-0">
                        @auth
                            <li><a href="{{ route('pelanggan.dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ route('pelanggan.profil') }}">Profil</a></li>
                        @else
                            <li><a href="{{ route('login') }}">Masuk</a></li>
                            <li><a href="{{ route('signup') }}">Daftar</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase text-theme-primary">Media Sosial</h5>
                    <div class="mt-3">
                        <a href="#" class="me-3"><i class="fab fa-facebook fa-2x"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-instagram fa-2x"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-twitter fa-2x"></i></a>
                        <a href="#"><i class="fab fa-whatsapp fa-2x"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center p-3" style="background-color: var(--color-secondary); color: white !important;">
            &copy; 2024 Toko Saudara 2. All Rights Reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
