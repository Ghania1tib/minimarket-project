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
            color: white; /* Pastikan teks terlihat di atas warna solid */
        }

        .carousel-caption h2, .carousel-caption p {
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

        footer {
            background-color: var(--color-light);
            color: var(--color-primary);
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 0 !important;
        }
    </style>
</head>

<body>

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
                    <a href="/cart" class="btn btn-outline-dark me-3"><i class="fas fa-shopping-cart"></i> Keranjang
                        (0)</a>
                    @auth
                        <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-primary-custom btn-primary"><i
                                class="fas fa-user-circle me-1"></i> Akun Saya</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary-custom btn-primary"><i
                                class="fas fa-user"></i> Masuk</a>
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
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
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
                    <span class="countdown-box">{{ $countdownString }}</span>
                </div>
            </div>

            <div class="row g-3">
                @foreach ($flashSaleProducts as $product)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card product-card text-center">
                            <span class="badge-diskon badge text-white">
                                -{{ $product['discount_rate'] }}%
                            </span>

                            <div class="product-image-container">
                                <img src="{{ $product['img_url'] }}" alt="{{ $product['name'] }}" class="img-fluid">
                            </div>

                            <div class="card-body p-3 d-flex flex-column justify-content-between">
                                <div>
                                    <small class="text-muted d-block mb-1">{{ $product['category_name'] }}</small>
                                    <h6 class="card-title fw-bold mb-1">{{ $product['name'] }}</h6>
                                </div>
                                <div>
                                    <p class="old-price mb-0">Rp {{ number_format($product['price'], 0, ',', '.') }}</p>
                                    <p class="card-text text-danger fw-bold fs-5">Rp
                                        {{ number_format($product['discount_price'], 0, ',', '.') }}</p>
                                    <a href="{{ $product['link'] }}" class="btn btn-accent btn-sm w-100 fw-bold">Beli
                                        Sekarang <i class="fas fa-tag"></i></a>
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
            @if ($popularCategories->isEmpty())
                <div class="col-12 text-center py-5">
                    <i class="fas fa-tags fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Belum ada kategori dengan produk.</h4>
                </div>
            @else
                @foreach ($popularCategories as $category)
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <a href="{{ route('kategori.show', $category->id) }}"
                            class="text-decoration-none d-block p-4 category-card shadow-sm">
                            <div style="font-size: 2.5rem;" class="mb-2">
                                @if ($category->icon_url)
                                    <img src="{{ asset('storage/' . $category->icon_url) }}" alt="{{ $category->nama_kategori }}" style="width: 50px; height: 50px; object-fit: contain;">
                                @else
                                    <i class="fas fa-box text-theme"></i>
                                @endif
                            </div>
                            <p class="fw-bold mb-0 text-dark">{{ $category->nama_kategori }}</p>
                            <small class="text-muted">{{ $category->products_count }} produk</small>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
        <!-- END POPULAR CATEGORIES -->

        <!-- FEATURED PRODUCTS -->
        <h3 class="mb-4 text-theme"><i class="fas fa-star me-2"></i> Produk Unggulan Minggu Ini</h3>
        <div class="row g-4 mb-5">
            @if ($produkUnggulan->isEmpty())
                <div class="col-12 text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Belum ada produk yang tersedia.</h4>
                    <a href="{{ route('produk.create') }}" class="btn btn-primary-custom mt-3">Tambah Produk</a>
                </div>
            @else
                @foreach ($produkUnggulan as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card product-card">
                            <div class="product-image-container">
                                <img src="{{ $product->full_gambar_url }}" alt="{{ $product->nama_produk }}"
                                    class="img-fluid">
                            </div>

                            <div class="card-body p-3 d-flex flex-column justify-content-between">
                                <div>
                                    <small class="text-muted d-block mb-1">{{ $product->category->nama_kategori ?? 'Umum' }}</small>
                                    <h6 class="card-title fw-bold">{{ $product->nama_produk }}</h6>
                                </div>
                                <div>
                                    <p class="card-text text-theme fw-bold fs-5 mb-2">
                                        {{ $product->harga_jual_formatted }}</p>
                                    <a href="{{ route('produk.show', $product->id) }}"
                                        class="btn btn-primary-custom btn-sm w-100"><i class="fas fa-plus me-1"></i> Lihat
                                        Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <!-- END FEATURED PRODUCTS -->

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
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Informasi</h5>
                    <ul class="list-unstyled mb-0">
                        <li><a href="{{ route('about') }}" class="text-dark text-decoration-none">Tentang Kami</a></li>
                        <li><a href="{{ route('contact') }}" class="text-dark text-decoration-none">Hubungi Kami</a></li>
                        <li><a href="{{ route('terms') }}" class="text-dark text-decoration-none">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Akun Anda</h5>
                    <ul class="list-unstyled mb-0">
                        @auth
                        <li><a href="{{ route('pelanggan.profil') }}" class="text-dark text-decoration-none">Profil</a></li>
                        <li><a href="{{ route('pelanggan.riwayat') }}" class="text-dark text-decoration-none">Riwayat Pesanan</a></li>
                        @else
                        <li><a href="{{ route('login') }}" class="text-dark text-decoration-none">Masuk</a></li>
                        <li><a href="{{ route('signup') }}" class="text-dark text-decoration-none">Daftar</a></li>
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

</body>

</html>
