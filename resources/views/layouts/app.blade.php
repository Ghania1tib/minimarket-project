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

        /* ========== NAVBAR STYLES (UPDATED) ========== */
        .navbar-custom {
            background-color: var(--color-accent);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1030;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        /* Navbar Brand - Logo & Toko Saudara */
        .navbar-custom .navbar-brand {
            font-weight: 800;
            color: var(--color-primary) !important;
            transition: color 0.3s;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }

        .navbar-custom .navbar-brand:hover {
            color: var(--color-secondary) !important;
        }

        .navbar-custom .navbar-brand img {
            transition: transform 0.3s;
        }

        .navbar-custom .navbar-brand:hover img {
            transform: scale(1.05);
        }

        /* Navbar Links - Semua menu termasuk Keranjang */
        .navbar-custom .nav-link {
            font-weight: 700;
            color: var(--color-primary) !important;
            transition: all 0.3s;
            padding: 8px 15px !important;
            border-radius: var(--border-radius-sm);
            position: relative;
        }

        .navbar-custom .nav-link:hover {
            color: var(--color-secondary) !important;
            background-color: rgba(94, 84, 142, 0.1);
        }

        .navbar-custom .nav-link.active {
            color: var(--color-secondary) !important;
            background-color: rgba(94, 84, 142, 0.15);
        }

        /* Khusus untuk Keranjang */
        .navbar-custom .nav-cart {
            color: var(--color-primary) !important;
            font-weight: 700;
        }

        /* Cart Badge */
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--color-danger);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            border: 2px solid var(--color-accent);
        }

        /* ========== NAVBAR BUTTONS (UPDATED) ========== */
        /* Button Masuk - Outline Style */
        .navbar-custom .btn-outline-nav {
            background-color: transparent;
            border: 2px solid var(--color-primary);
            color: var(--color-primary);
            font-weight: 700;
            border-radius: var(--border-radius-sm);
            padding: 8px 20px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-custom .btn-outline-nav:hover {
            background-color: var(--color-primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(94, 84, 142, 0.2);
        }

        /* Button Daftar - Solid Style */
        .navbar-custom .btn-nav {
            background-color: var(--color-primary);
            border: 2px solid var(--color-primary);
            color: white;
            font-weight: 700;
            border-radius: var(--border-radius-sm);
            padding: 8px 20px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-custom .btn-nav:hover {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(94, 84, 142, 0.2);
        }

        /* ========== GENERAL CONTENT ========== */
        .content-container {
            max-width: var(--container-width);
            margin: 20px auto;
            padding: 25px 15px;
            background-color: var(--color-white);
            border-radius: var(--border-radius-lg);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            flex: 1;
        }

        /* ========== BUTTON STYLES (UPDATED FOR CONSISTENCY) ========== */
        /* Primary Buttons */
        .btn-primary,
        .btn-primary-custom {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            color: white;
            font-weight: 600;
            border-radius: var(--border-radius-sm);
            transition: all 0.3s;
        }

        .btn-primary:hover,
        .btn-primary-custom:hover,
        .btn-primary:focus,
        .btn-primary-custom:focus {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(94, 84, 142, 0.2);
        }

        /* Outline Primary Buttons (for Filters) */
        .btn-outline-primary {
            color: var(--color-primary);
            border-color: var(--color-primary);
            font-weight: 600;
            border-radius: var(--border-radius-sm);
            transition: all 0.3s;
        }

        .btn-outline-primary:hover {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            color: white;
            transform: translateY(-2px);
        }

        /* Success Buttons (Add to Cart) */
        .btn-success,
        .btn-success-custom {
            background-color: var(--color-success);
            border-color: var(--color-success);
            color: white;
            font-weight: 600;
            border-radius: var(--border-radius-sm);
            transition: all 0.3s;
        }

        .btn-success:hover,
        .btn-success-custom:hover {
            background-color: #5fa89e;
            border-color: #5fa89e;
            transform: translateY(-2px);
        }

        /* Secondary Buttons (Clear Filters) */
        .btn-secondary,
        .btn-outline-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
            font-weight: 600;
            border-radius: var(--border-radius-sm);
            transition: all 0.3s;
        }

        .btn-outline-secondary {
            background-color: transparent;
            color: #6c757d;
        }

        .btn-secondary:hover,
        .btn-outline-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
            transform: translateY(-2px);
        }

        /* Info & Warning Buttons */
        .btn-info {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
        }

        .btn-warning {
            background-color: var(--color-danger);
            border-color: var(--color-danger);
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        /* ========== UTILITY CLASSES ========== */
        .text-theme-primary {
            color: var(--color-primary) !important;
        }

        .text-theme-secondary {
            color: var(--color-secondary) !important;
        }

        .bg-theme-primary {
            background-color: var(--color-primary) !important;
        }

        .bg-theme-secondary {
            background-color: var(--color-secondary) !important;
        }

        .bg-theme-accent {
            background-color: var(--color-accent) !important;
        }

        .bg-theme-light {
            background-color: var(--color-light) !important;
        }

        .border-theme-primary {
            border-color: var(--color-primary) !important;
        }

        /* ========== CARD STYLING ========== */
        .card {
            border-radius: var(--border-radius-lg);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--color-light);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .card-header {
            background-color: var(--color-light);
            color: var(--color-primary);
            font-weight: 600;
            border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0 !important;
            border-bottom: 1px solid var(--color-accent);
            padding: 0.75rem 1.25rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        /* ========== ALERTS ========== */
        .alert-fixed {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            min-width: 300px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* ========== FOOTER ========== */
        footer {
            background-color: var(--color-accent);
            color: var(--color-primary);
        }

        footer a {
            color: var(--color-primary);
            text-decoration: none;
            transition: color 0.3s;
        }

        footer a:hover {
            color: var(--color-secondary);
            text-decoration: underline;
        }

        /* ========== LANDING PAGE SPECIFIC ========== */
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

        /* ========== DROPDOWN STYLES (for Filters) ========== */
        .dropdown-menu {
            border-radius: var(--border-radius-sm);
            border: 1px solid var(--color-light);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            color: var(--color-primary);
            padding: 8px 16px;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: var(--color-light);
            color: var(--color-primary);
        }

        .dropdown-item.active {
            background-color: var(--color-primary) !important;
            color: white !important;
        }

        /* ========== FORM CONTROLS ========== */
        .form-control {
            border: 1px solid var(--color-light);
            border-radius: var(--border-radius-sm);
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 0.25rem rgba(94, 84, 142, 0.25);
        }

        /* ========== BADGES ========== */
        .badge.bg-primary {
            background-color: var(--color-primary) !important;
        }

        .badge.bg-success {
            background-color: var(--color-success) !important;
        }

        .badge.bg-warning {
            background-color: var(--color-danger) !important;
            color: white !important;
        }

        .badge.bg-danger {
            background-color: #dc3545 !important;
        }
                /* Floating WhatsApp Button */
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 25px;
            right: 25px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }

        .whatsapp-float:hover {
            background-color: #128C7E;
            color: #FFF;
            transform: scale(1.1);
            text-decoration: none;
        }

        .whatsapp-float i {
            margin: 0;
        }

        /* WhatsApp Pulse Animation */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(37, 211, 102, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }

        /* Responsive WhatsApp Button */
        @media (max-width: 768px) {
            .whatsapp-float {
                width: 50px;
                height: 50px;
                bottom: 20px;
                right: 20px;
                font-size: 25px;
            }
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
<br>
    @yield('navbar')

    <div class="main-content flex-grow-1">
        @yield('content')
    </div>


    {{-- Floating WhatsApp Button --}}
    <a href="https://wa.me/6281234567890?text=Halo%20Toko%20Saudara%202%2C%20saya%20ingin%20bertanya%20tentang%20produk%20anda"
       class="whatsapp-float"
       target="_blank"
       title="Hubungi Kami via WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

{{-- Footer --}}
<footer class="mt-5">
    <div class="container p-3">
        <div class="row g-3">
            <!-- Tentang Toko -->
            <div class="col-lg-5 col-md-6 mb-3 mb-md-0">
                <div class="d-flex align-items-center mb-2">
<div class="logo-container" style="display: inline-flex; align-items: center; margin-right: 10px;">
                <div class="logo" style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #5E548E 0%, #9F86C0 100%); display: flex; align-items: center; justify-content: center; color: white; border: 3px solid #9F86C0; box-shadow: 0 5px 15px rgba(94, 84, 142, 0.3);">
                    <img src="{{ asset('storage/logo-toko.png') }}"
                         alt="Toko Saudara Logo"
                         height="40"
                         style="border-radius: 50%;"
                         onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiByeD0iOCIgZmlsbD0iIzVFMzQ4RSIvPgo8cGF0aCBkPSJNMTggMTVIMjJWMjVIMThWMTVaTTI1IDE1SDI5VjI1SDI1VjE1Wk0xMSAxNUgxNVYyNUgxMVYxNVoiIGZpbGw9IndoaXRlIi8+Cjwvc3ZnPg=='">
                </div>
            </div>
                    <div>
                        <h6 class="text-theme-primary fw-bold mb-0">TOKO SAUDARA 2</h6>
                        <small class="text-theme-secondary">Belanja Praktis & Terpercaya</small>
                    </div>
                </div>
            </div>

            <!-- Informasi -->
            <div class="col-lg-3 col-md-6 mb-3 mb-md-0">
                <h6 class="text-uppercase text-theme-primary fw-bold mb-2 small">Informasi</h6>
                <ul class="list-unstyled mb-0 small">
                    <li class="mb-1"><a href="{{ route('about') }}" class="text-theme-primary text-decoration-none">Tentang Kami</a></li>
                    <li class="mb-1"><a href="{{ route('contact') }}" class="text-theme-primary text-decoration-none">Hubungi Kami</a></li>
                    <li><a href="{{ route('terms') }}" class="text-theme-primary text-decoration-none">Syarat & Ketentuan</a></li>
                </ul>
            </div>

            <!-- Kontak & Jam Operasional -->
            <div class="col-lg-4 col-md-12">
                <h6 class="text-uppercase text-theme-primary fw-bold mb-2 small">Jam Operasional</h6>
                <ul class="list-unstyled mb-3 small">
                    <li class="mb-1 text-theme-primary">
                        <strong>Senin - Jumat:</strong> 08:00 - 22:00
                    </li>
                    <li class="text-theme-primary">
                        <strong>Sabtu - Minggu:</strong> 09:00 - 22:00
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="text-center p-2" style="background-color: var(--color-secondary); color: white !important;">
        <p class="mb-0 small">&copy; {{ date('Y') }} Toko Saudara 2. All Rights Reserved.</p>
    </div>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- WhatsApp Number Configuration --}}
    <script>
        // Anda bisa mengganti nomor WhatsApp di sini
        const whatsappNumber = '6281234567890'; // Ganti dengan nomor WhatsApp bisnis Anda
        const defaultMessage = 'Halo Toko Saudara 2, saya ingin bertanya tentang produk anda';

        // Update semua link WhatsApp
        document.addEventListener('DOMContentLoaded', function() {
            const whatsappLinks = document.querySelectorAll('a[href*="wa.me"]');
            whatsappLinks.forEach(link => {
                link.href = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(defaultMessage)}`;
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
