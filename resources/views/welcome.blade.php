<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minimarket - Belanja Kebutuhan Harian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ======================================================= */
        /* VARIABEL WARNA TEMA */
        /* ======================================================= */
        :root {
            --color-primary: #004f7c;
            --color-accent: #ff6347;
            --color-light: #ffb6c1;
        }

        body {
            background: linear-gradient(to right, #ffdde1, #a1c4fd);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar-custom {
            background-color: var(--color-light);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            color: var(--color-primary) !important;
        }

        .navbar-nav .nav-link {
            color: var(--color-primary) !important;
        }

        .content-container {
            max-width: 1300px;
            margin: 20px auto;
            padding: 30px 15px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            flex: 1;
        }

        /* Banner Slider */
        .carousel-item {
            height: 300px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .carousel-caption {
            top: 50%;
            left: 5%;
            transform: translateY(-50%);
            background: none;
            text-align: left;
            padding: 0;
            margin: 0;
            width: 50%;
            color: white;
        }

        .carousel-caption h2,
        .carousel-caption p {
            color: white;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        /* Flash Sale Styling */
        .flash-sale-section {
            background: linear-gradient(to right, #fff5f5, #ffe0e6);
            border-radius: 15px;
            padding: 20px;
            border: 2px solid var(--color-accent);
        }

        .countdown-box {
            background-color: var(--color-accent);
            color: white;
            padding: 5px 12px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 1.2rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Card Produk Styling */
        .product-card {
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s, box-shadow 0.2s;
            overflow: hidden;
            height: 100%;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .product-image-container {
            height: 180px;
            background-color: white;
            overflow: hidden;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }

        .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.3s;
        }

        .product-card:hover .product-image-container img {
            transform: scale(1.05);
        }

        .old-price {
            text-decoration: line-through;
            color: #999;
            font-size: 0.9rem;
        }

        .badge-diskon {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #dc3545;
            font-size: 0.9rem;
            padding: 5px 8px;
            border-radius: 5px;
            z-index: 10;
        }

        .btn-primary-custom {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            font-weight: bold;
        }

        .btn-primary-custom:hover {
            background-color: #003366;
            border-color: #003366;
        }

        .btn-accent {
            background-color: var(--color-accent);
            border-color: var(--color-accent);
            color: white;
            font-weight: bold;
        }

        .btn-accent:hover {
            background-color: #e55337;
            border-color: #e55337;
            color: white;
        }

        .btn-success-custom {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
            font-weight: bold;
        }

        .btn-success-custom:hover {
            background-color: #218838;
            border-color: #1e7e34;
            color: white;
        }

        .text-theme {
            color: var(--color-primary) !important;
        }

        /* Kategori Card Styling */
        .category-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            transition: all 0.2s;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .category-card:hover {
            border-color: var(--color-accent);
            box-shadow: 0 4px 10px rgba(255, 99, 71, 0.2);
            transform: translateY(-2px);
        }

        /* Stok habis */
        .out-of-stock {
            position: relative;
        }

        .out-of-stock::after {
            content: "STOK HABIS";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #dc3545;
            font-size: 1.2rem;
        }

        /* Loading spinner */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, .3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        footer {
            background-color: var(--color-light);
            color: var(--color-primary);
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            margin-top: auto;
        }

        /* Alert custom position */
        .alert-fixed {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            min-width: 300px;
        }

        /* Cart badge */
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>

    <!-- Error Alert Section -->
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

    <!-- NAV BAR -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top navbar-custom">
        <div class="container-fluid content-container" style="background-color: transparent; box-shadow: none;">

            <a class="navbar-brand" href="{{ route('home') }}"><i class="fas fa-shopping-basket me-2"></i> MINI<span
                    style="color: var(--color-accent);">MARKET</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('produk.index') }}">Semua Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('kategori.index') }}">Kategori</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-dark me-3 position-relative">
                        <i class="fas fa-shopping-cart"></i> Keranjang
                        <span class="cart-badge" id="cart-count-badge">0</span>
                    </a>
                    @auth
                        @if (Auth::user()->role === 'pelanggan')
                            <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-primary-custom btn-primary">
                                <i class="fas fa-user-circle me-1"></i> Akun Saya
                            </a>
                        @else
                            {{-- PERBAIKAN: Gunakan route yang sesuai berdasarkan role --}}
                            @if (Auth::user()->role === 'admin' || Auth::user()->role === 'owner')
                                <a href="{{ route('owner.dashboard') }}" class="btn btn-primary-custom btn-primary">
                                    <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                                </a>
                            @elseif(Auth::user()->role === 'kasir')
                                <a href="{{ route('dashboard.staff') }}" class="btn btn-primary-custom btn-primary">
                                    <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                                </a>
                            @else
                                {{-- Fallback ke route dashboard umum --}}
                                <a href="{{ route('dashboard') }}" class="btn btn-primary-custom btn-primary">
                                    <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                                </a>
                            @endif
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary-custom btn-primary">
                            <i class="fas fa-user me-1"></i> Masuk
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    <!-- END NAV BAR -->

    <div class="content-container">

        <!-- HERO CAROUSEL -->
        <div id="heroCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach ($heroBanners as $key => $banner)
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $key }}"
                        class="{{ $key === 0 ? 'active' : '' }}" aria-current="{{ $key === 0 ? 'true' : 'false' }}"
                        aria-label="Slide {{ $key + 1 }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach ($heroBanners as $key => $banner)
                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}"
                        style="height: 300px; background-color: {{ $banner['color'] }}; display: flex; align-items: center;">
                        <div class="carousel-caption">
                            <h2 class="display-5 fw-bold">{{ $banner['title'] }}</h2>
                            <p class="lead">{{ $banner['subtitle'] }}</p>
                            <a href="{{ $banner['link'] }}" class="btn btn-warning mt-3 fw-bold">Lihat Promo <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <!-- END HERO CAROUSEL -->

        <!-- FLASH SALE SECTION -->
        <div class="flash-sale-section mb-5 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0 text-danger"><i class="fas fa-bolt me-2"></i> FLASH SALE MENDADAK</h3>
                <div class="d-flex align-items-center">
                    <span class="text-dark me-2 fw-bold">Berakhir dalam:</span>
                    <span class="countdown-box" id="flash-sale-countdown">{{ $countdownString }}</span>
                </div>
            </div>

            <div class="row g-3">
                @foreach ($flashSaleProducts as $product)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card product-card text-center" data-product-id="{{ $product['id'] }}">
                            <span class="badge-diskon badge text-white">
                                -{{ $product['discount_rate'] }}%
                            </span>

                            <div class="product-image-container">
                                <img src="{{ $product['img_url'] }}" alt="{{ $product['name'] }}"
                                    class="img-fluid">
                            </div>

                            <div class="card-body p-3 d-flex flex-column justify-content-between">
                                <div>
                                    <small class="text-muted d-block mb-1">{{ $product['category_name'] }}</small>
                                    <h6 class="card-title fw-bold mb-1">{{ $product['name'] }}</h6>
                                </div>
                                <div>
                                    <p class="old-price mb-0">Rp {{ number_format($product['price'], 0, ',', '.') }}
                                    </p>
                                    <p class="card-text text-danger fw-bold fs-5">Rp
                                        {{ number_format($product['discount_price'], 0, ',', '.') }}</p>
                                    <button class="btn btn-accent btn-sm w-100 fw-bold add-to-cart-btn"
                                        data-product-id="{{ $product['id'] }}">
                                        <i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- END FLASH SALE SECTION -->

        <!-- POPULAR CATEGORIES -->
        <h3 class="mb-4 text-theme"><i class="fas fa-layer-group me-2"></i> Kategori Populer</h3>
        <div class="row g-4 mb-5 text-center">
            @if (empty($popularCategories) || $popularCategories->isEmpty())
                <div class="col-12 text-center py-5">
                    <i class="fas fa-tags fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Belum ada kategori dengan produk.</h4>
                    <p class="text-muted">Silakan tambahkan kategori dan produk terlebih dahulu.</p>
                    @auth
                        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'owner')
                            <a href="{{ route('kategori.create') }}" class="btn btn-primary-custom mt-3">
                                <i class="fas fa-plus me-1"></i> Tambah Kategori
                            </a>
                        @endif
                    @endauth
                </div>
            @else
                @foreach ($popularCategories as $category)
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <a href="{{ route('kategori.show', $category->id) }}"
                            class="text-decoration-none d-block p-4 category-card shadow-sm">
                            <div style="font-size: 2.5rem;" class="mb-2">
                                @if ($category->icon_url && filter_var($category->icon_url, FILTER_VALIDATE_URL))
                                    <img src="{{ $category->icon_url }}" alt="{{ $category->nama_kategori }}"
                                        style="width: 50px; height: 50px; object-fit: contain;">
                                @elseif($category->icon_url)
                                    <img src="{{ asset('storage/' . $category->icon_url) }}"
                                        alt="{{ $category->nama_kategori }}"
                                        style="width: 50px; height: 50px; object-fit: contain;">
                                @else
                                    <i class="fas fa-box text-theme"></i>
                                @endif
                            </div>
                            <p class="fw-bold mb-0 text-dark">{{ $category->nama_kategori }}</p>
                            <small class="text-muted">
                                {{ $category->products_count ?? 0 }} produk
                            </small>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
        <!-- END POPULAR CATEGORIES -->

        <!-- FEATURED PRODUCTS -->
        <h3 class="mb-4 text-theme"><i class="fas fa-star me-2"></i> Produk Unggulan Minggu Ini</h3>
        <div class="row g-4 mb-5">
            @if (empty($produkUnggulan) || $produkUnggulan->isEmpty())
                <div class="col-12 text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Belum ada produk yang tersedia.</h4>
                    @auth
                        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'owner')
                            <a href="{{ route('produk.create') }}" class="btn btn-primary-custom mt-3">
                                <i class="fas fa-plus me-1"></i> Tambah Produk
                            </a>
                        @endif
                    @endauth
                </div>
            @else
                @foreach ($produkUnggulan as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card product-card {{ $product->stok <= 0 ? 'out-of-stock' : '' }}"
                            data-product-id="{{ $product->id }}">
                            @if ($product->stok <= 0)
                                <div class="out-of-stock-overlay"></div>
                            @endif

                            <div class="product-image-container">
                                <img src="{{ $product->full_gambar_url }}" alt="{{ $product->nama_produk }}"
                                    class="img-fluid">
                            </div>

                            <div class="card-body p-3 d-flex flex-column justify-content-between">
                                <div>
                                    <small class="text-muted d-block mb-1">
                                        {{ $product->category->nama_kategori ?? 'Umum' }}
                                    </small>
                                    <h6 class="card-title fw-bold">{{ $product->nama_produk }}</h6>
                                    @if ($product->stok <= 0)
                                        <span class="badge bg-danger">Stok Habis</span>
                                    @elseif($product->stok < 10)
                                        <span class="badge bg-warning">Stok Terbatas</span>
                                    @else
                                        <span class="badge bg-success">Tersedia</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="card-text text-theme fw-bold fs-5 mb-2">
                                        {{ $product->harga_jual_formatted }}
                                    </p>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('produk.show', $product->id) }}"
                                            class="btn btn-primary-custom btn-sm">
                                            <i class="fas fa-eye me-1"></i> Lihat Detail
                                        </a>
                                        @if ($product->stok > 0)
                                            <button class="btn btn-success-custom btn-sm add-to-cart-btn"
                                                data-product-id="{{ $product->id }}">
                                                <i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang
                                            </button>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>
                                                <i class="fas fa-times me-1"></i> Stok Habis
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <!-- END FEATURED PRODUCTS -->

        <!-- INFO SECTION -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card text-center h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-theme mb-3">
                            <i class="fas fa-shipping-fast fa-3x"></i>
                        </div>
                        <h5 class="card-title">Gratis Ongkir</h5>
                        <p class="card-text">Minimal pembelian Rp 100.000 untuk area tertentu</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-theme mb-3">
                            <i class="fas fa-shield-alt fa-3x"></i>
                        </div>
                        <h5 class="card-title">Jaminan Kualitas</h5>
                        <p class="card-text">Produk segar dan berkualitas terjamin</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-theme mb-3">
                            <i class="fas fa-headset fa-3x"></i>
                        </div>
                        <h5 class="card-title">Bantuan 24/7</h5>
                        <p class="card-text">Customer service siap membantu kapan saja</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- END INFO SECTION -->

    </div>

    <!-- FOOTER -->
    <footer class="text-center text-lg-start mt-5"
        style="background-color: var(--color-light); color: var(--color-primary);">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase"><i class="fas fa-shopping-basket me-2"></i> Minimarket</h5>
                    <p style="color: var(--color-primary);">Jaminan kesegaran produk dan pengiriman tepat waktu
                        langsung ke pintu rumah Anda.</p>
                    <div class="mt-3">
                        <a href="#" class="text-dark me-3"><i class="fab fa-facebook fa-2x"></i></a>
                        <a href="#" class="text-dark me-3"><i class="fab fa-instagram fa-2x"></i></a>
                        <a href="#" class="text-dark me-3"><i class="fab fa-twitter fa-2x"></i></a>
                        <a href="#" class="text-dark"><i class="fab fa-whatsapp fa-2x"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Informasi</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="{{ route('about') }}"
                                class="text-dark text-decoration-none">Tentang Kami</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}"
                                class="text-dark text-decoration-none">Hubungi Kami</a></li>
                        <li class="mb-2"><a href="{{ route('terms') }}"
                                class="text-dark text-decoration-none">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Akun Anda</h5>
                    <ul class="list-unstyled mb-0">
                        @auth
                            <li class="mb-2"><a href="{{ route('pelanggan.profil') }}"
                                    class="text-dark text-decoration-none">Profil</a></li>
                            <li class="mb-2"><a href="{{ route('pelanggan.pesanan') }}"
                                    class="text-dark text-decoration-none">Riwayat Pesanan</a></li>
                            <li><a href="{{ route('cart.index') }}"
                                    class="text-dark text-decoration-none">Keranjang Belanja</a></li>
                        @else
                            <li class="mb-2"><a href="{{ route('login') }}"
                                    class="text-dark text-decoration-none">Masuk</a></li>
                            <li class="mb-2"><a href="{{ route('signup') }}"
                                    class="text-dark text-decoration-none">Daftar</a></li>
                            <li><a href="{{ route('cart.index') }}" class="text-dark text-decoration-none">Lihat
                                    Keranjang</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center p-3" style="background-color: #ff91a4;">
            &copy; 2024 Minimarket. All Rights Reserved.
        </div>
    </footer>
    <!-- END FOOTER -->

        <script>
        // PERBAIKAN: Debug function untuk memastikan JavaScript berjalan
        console.log('JavaScript loaded successfully');

        // Fungsi untuk menambahkan produk ke keranjang
        function addToCart(productId) {
            console.log('🛒 Attempting to add product to cart:', productId);

            if (!productId) {
                console.error('❌ Product ID is missing');
                showAlert('Error: Product ID tidak valid', 'error');
                return;
            }

            // Tampilkan loading state
            const buttons = document.querySelectorAll(`.add-to-cart-btn[data-product-id="${productId}"]`);
            if (buttons.length === 0) {
                console.error('❌ No add-to-cart buttons found for product:', productId);
                return;
            }

            buttons.forEach(button => {
                const originalText = button.innerHTML;
                button.innerHTML = '<span class="loading-spinner"></span> Menambahkan...';
                button.disabled = true;

                // Set timeout untuk reset jika request gagal
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                }, 5000);
            });

            // PERBAIKAN: Gunakan absolute URL untuk menghindari routing issues
            const url = `/cart/add/${productId}`;
            console.log('📤 Sending request to:', url);

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({}),
                credentials: 'same-origin' // PERBAIKAN: Include cookies
            })
            .then(response => {
                console.log('📥 Response received:', response.status, response.statusText);

                if (response.status === 401) {
                    console.log('🔐 Unauthorized - redirecting to login');
                    showAlert('Silakan login terlebih dahulu', 'warning');
                    setTimeout(() => {
                        window.location.href = '{{ route('login') }}';
                    }, 1500);
                    return null;
                }

                if (response.status === 404) {
                    console.error('❌ Product not found');
                    return { success: false, message: 'Produk tidak ditemukan' };
                }

                if (response.status === 400) {
                    return response.json().then(data => {
                        console.error('❌ Client error:', data);
                        return data;
                    }).catch(() => {
                        return { success: false, message: 'Stok tidak mencukupi' };
                    });
                }

                if (response.status === 500) {
                    console.error('❌ Server error');
                    return { success: false, message: 'Terjadi kesalahan server' };
                }

                if (!response.ok) {
                    console.error('❌ Network error:', response.status);
                    throw new Error(`Network response was not ok: ${response.status}`);
                }

                return response.json();
            })
            .then(data => {
                console.log('✅ Response data:', data);

                // Reset button state
                buttons.forEach(button => {
                    if (data && data.success) {
                        button.innerHTML = '<i class="fas fa-check me-1"></i> Ditambahkan!';
                        button.classList.remove('btn-accent', 'btn-success-custom');
                        button.classList.add('btn-success');
                        button.disabled = true;

                        // Reset setelah 2 detik
                        setTimeout(() => {
                            button.innerHTML = '<i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang';
                            button.classList.remove('btn-success');
                            if (button.closest('.flash-sale-section')) {
                                button.classList.add('btn-accent');
                            } else {
                                button.classList.add('btn-success-custom');
                            }
                            button.disabled = false;
                        }, 2000);
                    } else {
                        // Reset jika gagal
                        button.innerHTML = '<i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang';
                        button.disabled = false;
                    }
                });

                if (data && data.success) {
                    console.log('🎉 Product added successfully');
                    showAlert(data.message, 'success');
                    updateCartCount();
                } else if (data && data.message) {
                    console.error('❌ Server error message:', data.message);
                    showAlert(data.message, 'error');
                } else if (!data) {
                    console.log('ℹ️ No data returned (already handled)');
                    return;
                }
            })
            .catch(error => {
                console.error('💥 Fetch Error:', error);
                showAlert('Terjadi kesalahan saat menambahkan produk: ' + error.message, 'error');

                // Reset button state on error
                buttons.forEach(button => {
                    button.innerHTML = '<i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang';
                    button.disabled = false;
                });
            });
        }

        // Fungsi untuk memperbarui jumlah keranjang di navbar
        function updateCartCount() {
            console.log('🔄 Updating cart count...');

            fetch('{{ route("cart.count") }}', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('🛒 Cart count data:', data);
                const cartBadge = document.getElementById('cart-count-badge');
                if (cartBadge) {
                    cartBadge.textContent = data.count;
                    if (data.count > 0) {
                        cartBadge.style.display = 'flex';
                    } else {
                        cartBadge.style.display = 'none';
                    }
                    console.log('✅ Cart count updated to:', data.count);
                }
            })
            .catch(error => {
                console.error('❌ Error updating cart count:', error);
            });
        }

        // Fungsi untuk menampilkan alert
        function showAlert(message, type) {
            console.log(`📢 Alert [${type}]:`, message);

            // Hapus alert sebelumnya
            const existingAlerts = document.querySelectorAll('.alert-fixed');
            existingAlerts.forEach(alert => {
                if (alert.style.opacity !== '0') {
                    alert.remove();
                }
            });

            const alertClass = type === 'success' ? 'alert-success' :
                             type === 'error' ? 'alert-danger' :
                             type === 'warning' ? 'alert-warning' : 'alert-info';
            const icon = type === 'success' ? 'fa-check-circle' :
                        type === 'error' ? 'fa-exclamation-circle' :
                        type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle';

            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show alert-fixed" role="alert" style="z-index: 9999;">
                    <i class="fas ${icon} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            document.body.insertAdjacentHTML('afterbegin', alertHtml);

            // Hapus alert setelah 5 detik
            setTimeout(() => {
                const alert = document.querySelector('.alert-fixed');
                if (alert) {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s';
                    setTimeout(() => alert.remove(), 500);
                }
            }, 5000);
        }

        // Fungsi untuk countdown flash sale
        function startFlashSaleCountdown() {
            const countdownElement = document.getElementById('flash-sale-countdown');
            if (!countdownElement) return;

            let time = 23 * 60 * 60 + 59 * 60 + 59;

            function updateCountdown() {
                const hours = Math.floor(time / 3600);
                const minutes = Math.floor((time % 3600) / 60);
                const seconds = time % 60;

                countdownElement.textContent =
                    `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                if (time <= 0) {
                    clearInterval(countdownInterval);
                    countdownElement.textContent = "00:00:00";
                    showAlert('Flash sale telah berakhir!', 'warning');
                } else {
                    time--;
                }
            }

            updateCountdown();
            const countdownInterval = setInterval(updateCountdown, 1000);
        }

        // PERBAIKAN: Event listener yang lebih robust
        function initializeCartFunctionality() {
            console.log('🔧 Initializing cart functionality...');

            // Update jumlah keranjang saat halaman dimuat
            updateCartCount();

            // Start flash sale countdown
            startFlashSaleCountdown();

            // Event listener untuk tombol tambah ke keranjang
            document.addEventListener('click', function(e) {
                // Debug click event
                console.log('🖱️ Click event on:', e.target);

                const addToCartBtn = e.target.closest('.add-to-cart-btn');
                if (addToCartBtn) {
                    e.preventDefault();
                    e.stopPropagation();

                    const productId = addToCartBtn.getAttribute('data-product-id');
                    console.log('🎯 Add to cart button clicked, product ID:', productId);

                    if (productId) {
                        addToCart(productId);
                    } else {
                        console.error('❌ No product ID found on button');
                    }
                }
            });

            console.log('✅ Cart functionality initialized');
        }

        // Initialize ketika DOM siap
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeCartFunctionality);
        } else {
            initializeCartFunctionality();
        }

        // Handle visibility change untuk update cart count
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                console.log('🔍 Page visible, updating cart count');
                updateCartCount();
            }
        });

        // Global error handlers
        window.addEventListener('error', function(e) {
            console.error('🌍 Global error:', e.error);
        });

        window.addEventListener('unhandledrejection', function(e) {
            console.error('🔮 Unhandled promise rejection:', e.reason);
        });

        // PERBAIKAN: Test function untuk manual testing
        window.testAddToCart = function(productId = 1) {
            console.log('🧪 Manual test: add product', productId, 'to cart');
            addToCart(productId);
        };

        console.log('🚀 All JavaScript functions defined successfully');
    </script>

</body>

</html>
