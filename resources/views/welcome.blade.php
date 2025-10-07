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
        }

        /* Flash Sale Styling */
        .flash-sale-section {
            background: linear-gradient(to right, #fff5f5, #ffe0e6);
            border-radius: 10px;
            padding: 20px;
            border: 2px dashed var(--color-light);
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

        /* ======================================================= */
        /* KUNCI PERBAIKAN: CARD PRODUK & GAMBAR */
        /* ======================================================= */
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
            /* Tinggi yang seragam untuk semua gambar */
            background-color: white;
            /* Background putih untuk 'whitespace' */
            overflow: hidden;
            border-bottom: 1px solid #eee;
            /* Flexbox untuk menengahkan gambar */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            /* Sedikit padding internal */
        }

        .product-image-container img {
            width: 100%;
            height: 100%;
            /* FIX: Menggunakan 'contain' agar gambar tidak terpotong */
            object-fit: contain;
            transition: transform 0.3s;
        }

        .product-card:hover .product-image-container img {
            transform: scale(1.02);
            /* Sedikit efek saat hover */
        }

        /* ======================================================= */

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

        .text-theme {
            color: var(--color-primary) !important;
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

    <nav class="navbar navbar-expand-lg navbar-light sticky-top navbar-custom">
        <div class="container-fluid content-container" style="background-color: transparent; box-shadow: none;">

            <a class="navbar-brand" href="{{ route('home') }}"><i class="fas fa-shopping-basket me-2"></i> MINI<span
                    style="color: #ff6347;">MARKET</span></a>
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
                        <a class="nav-link" href="/produk">Semua Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/promo">Promo</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="/cart" class="btn btn-outline-dark me-2"><i class="fas fa-shopping-cart"></i> Keranjang
                        (3)</a>
                    <a href="{{ route('login') }}" class="btn btn-primary-custom btn-primary"><i
                            class="fas fa-user"></i> Masuk</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="content-container">

        <div id="heroCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
            <div class="carousel-inner">
                @php
                    $heroBanners = [
                        [
                            'title' => 'Diskon Besar Akhir Pekan',
                            'subtitle' => 'Hemat hingga 50% untuk semua kebutuhan dapur!',
                            'link' => '/promosi/weekend',
                            'color' => 'background-color: #004f7c;',
                        ],
                        [
                            'title' => 'Gratis Ongkir',
                            'subtitle' => 'Minimum belanja Rp150.000, kirim cepat dan aman.',
                            'link' => '/promo/ongkir',
                            'color' => 'background-color: #ff6347;',
                        ],
                    ];
                @endphp
                @foreach ($heroBanners as $key => $banner)
                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}"
                        style="height: 300px; {{ $banner['color'] }} display: flex; align-items: center;">
                        <div class="carousel-caption">
                            <h2>{{ $banner['title'] }}</h2>
                            <p>{{ $banner['subtitle'] }}</p>
                            <a href="{{ $banner['link'] }}" class="btn btn-warning mt-2 fw-bold">Lihat Promo <i
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

        <div class="flash-sale-section mb-5 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0 text-danger"><i class="fas fa-bolt me-2"></i> FLASH SALE MENDADAK</h3>
                @php $countdownString = '02:45:30'; @endphp
                <div class="d-flex align-items-center">
                    <span class="text-dark me-2 fw-bold">Berakhir dalam:</span>
                    <span class="countdown-box">{{ $countdownString }}</span>
                </div>
            </div>

            <div class="row g-3">
                @php
                    $flashSaleProducts = [
                        [
                            'name' => 'Minyak Goreng 2L',
                            'price' => 35000,
                            'discount_price' => 29900,
                            'img_url' =>
                                'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full/catalog-image/110/MTA-159491873/fortune_minyak-goreng-fortune-2l_full01.jpg?w=1200',
                        ],
                        [
                            'name' => 'Telur Ayam 1 Tray',
                            'price' => 52000,
                            'discount_price' => 45500,
                            'img_url' =>
                                'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//catalog-image/103/MTA-112958842/jaya_telur_telur_ayam_negeri_ukuran_kecil_-30_butir-_full01_c5g6mj21.jpg?w=1200',
                        ],
                        [
                            'name' => 'Deterjen Cair 800ml',
                            'price' => 25000,
                            'discount_price' => 19900,
                            'img_url' =>
                                'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//84/MTA-3322254/so-klin_detergent-cair-soklin-800-refill-anti-bacterial_full02.jpg?w=1200',
                        ],
                        [
                            'name' => 'Apel Fuji Segar (1 Kg)',
                            'price' => 40000,
                            'discount_price' => 32000,
                            'img_url' =>
                                'https://image.astronauts.cloud/product-images/2024/11/apelfuji_c5babdf7-cb3c-4e03-a482-83e43e9e0f69_900x900.jpg',
                        ],
                    ];
                @endphp
                @foreach ($flashSaleProducts as $product)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card product-card text-center">
                            <span class="badge-diskon badge text-white">
                                -{{ round((($product['price'] - $product['discount_price']) / $product['price']) * 100) }}%
                            </span>

                            <div class="product-image-container">
                                <img src="{{ $product['img_url'] }}" alt="{{ $product['name'] }}" class="img-fluid">
                            </div>

                            <div class="card-body p-3">
                                <h6 class="card-title fw-bold mb-1">{{ $product['name'] }}</h6>
                                <p class="old-price mb-0">Rp {{ number_format($product['price'], 0, ',', '.') }}</p>
                                <p class="card-text text-danger fw-bold fs-5">Rp
                                    {{ number_format($product['discount_price'], 0, ',', '.') }}</p>
                                <a href="/produk/detail" class="btn btn-danger btn-sm w-100 fw-bold">Beli Sekarang <i
                                        class="fas fa-tag"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <h3 class="mb-4 text-theme"><i class="fas fa-layer-group me-2"></i> Kategori Populer</h3>
        <div class="row g-4 mb-5 text-center">
            @php
                $popularCategories = [
                    ['name' => 'Buah & Sayur', 'icon' => '🍎', 'link' => '/kategori/sayur'],
                    ['name' => 'Daging & Seafood', 'icon' => '🥩', 'link' => '/kategori/daging'],
                    ['name' => 'Sembako', 'icon' => '🍚', 'link' => '/kategori/sembako'],
                    ['name' => 'Minuman', 'icon' => '🥤', 'link' => '/kategori/minuman'],
                    ['name' => 'Kebersihan', 'icon' => '🧼', 'link' => '/kategori/kebersihan'],
                    ['name' => 'Snack & Cokelat', 'icon' => '🍫', 'link' => '/kategori/snack'],
                ];
            @endphp
            @foreach ($popularCategories as $category)
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <a href="{{ $category['link'] }}" class="text-decoration-none d-block p-3 card shadow-sm"
                        style="border-top: 3px solid var(--color-primary);">
                        <span style="font-size: 2.5rem;">{{ $category['icon'] }}</span>
                        <p class="fw-bold mt-2 mb-0 text-dark">{{ $category['name'] }}</p>
                    </a>
                </div>
            @endforeach
        </div>

        <h3 class="mb-4 text-theme"><i class="fas fa-star me-2"></i> Produk Unggulan Minggu Ini</h3>
        <div class="row g-4 mb-5">
            @php
                $produk = [
                    [
                        'name' => 'Gula Pasir 1 Kg',
                        'price' => 16000,
                        'category' => 'Sembako',
                        'img_url' =>
                            'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//90/MTA-3408533/gulaku_gula-pasir-gulaku-1kg-kuning_full02.jpg?w=1200',
                    ],
                    [
                        'name' => 'Susu UHT Cokelat 1L',
                        'price' => 18500,
                        'category' => 'Minuman',
                        'img_url' =>
                            'https://images.tokopedia.net/img/cache/700/product-1/2020/10/6/9494691/9494691_b13ed655-7431-4d4e-9c20-9ad489c6db45_720_720.jpg',
                    ],
                    [
                        'name' => 'Beras Premium 5 Kg',
                        'price' => 65000,
                        'category' => 'Sembako',
                        'img_url' =>
                            'https://www.pastisania.com/storage/app/media/Product%20Images/beras-premium-sania-5-kg.webp',
                    ],
                    [
                        'name' => 'Sabun Mandi Batang',
                        'price' => 5000,
                        'category' => 'Kebersihan',
                        'img_url' =>
                            'https://media.monotaro.id/mid01/big/Alat%20%26%20Kebutuhan%20Kebersihan/Cuci%20Tangan%2C%20Cuci%20Mulut%2C%20Pembersih%20Tangan/Sabun%20Cuci%20Tangan/Nuvo%20Sabun%20Batang/Nuvo%20Sabun%20Batang%20Family%20Carring%20Biru%2072g%201pc/pnS000037923-3.jpg',
                    ],
                    [
                        'name' => 'Ikan Tuna Fillet (250g)',
                        'price' => 45000,
                        'category' => 'Daging & Seafood',
                        'img_url' => 'https://www.sentraikanlaut.com/assets/Ikan-Tuna-Fillet-500-Gram-1.webp',
                    ],
                    [
                        'name' => 'Nanas Madu Lokal',
                        'price' => 22000,
                        'category' => 'Buah & Sayur',
                        'img_url' => 'https://s3-publishing-cmn-svc-prd.s3.ap-southeast-1.amazonaws.com/article/WmyfGQSMe1s8bYopJ-3Lv/original/052500500_1605602630-Menilik-Manfaat-Nanas-Madu-bagi-Kesehatan-Anda-shutterstock_1503954347.jpg',
                    ],

                    [
                        'name' => 'Kerupuk Udang Besar',
                        'price' => 15000,
                        'category' => 'Snack',
                        'img_url' =>
                            'https://solvent-production.s3.amazonaws.com/media/images/products/2023/12/BRM_0695.JPG',
                    ],
                    [
                        'name' => 'Kopi Instan Sachet',
                        'price' => 20000,
                        'category' => 'Minuman',
                        'img_url' =>
                            'https://mcgrocer.com/cdn/shop/files/nescaf-3-in-1-instant-coffee-sachets-16x16g-41369430360302.jpg?v=1744213691',
                    ],
                ];
            @endphp
            @foreach ($produk as $item)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card product-card">

                        <div class="product-image-container">
                            <img src="{{ $item['img_url'] }}" alt="{{ $item['name'] }}" class="img-fluid">
                        </div>

                        <div class="card-body p-3">
                            <small class="text-muted d-block mb-1">{{ $item['category'] }}</small>
                            <h6 class="card-title fw-bold">{{ $item['name'] }}</h6>
                            <p class="card-text text-primary fw-bold fs-5 mb-2"
                                style="color: var(--color-accent) !important;">Rp
                                {{ number_format($item['price'], 0, ',', '.') }}</p>
                            <a href="/produk/detail/{{ $loop->index }}"
                                class="btn btn-primary-custom btn-sm w-100"><i class="fas fa-plus me-1"></i> Tambah
                                Keranjang</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

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
                        <li><a href="/about" class="text-dark text-decoration-none">Tentang Kami</a></li>
                        <li><a href="/contact" class="text-dark text-decoration-none">Hubungi Kami</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Akun Anda</h5>
                    <ul class="list-unstyled mb-0">
                        <li><a href="/profile" class="text-dark text-decoration-none">Profil</a></li>
                        <li><a href="/orders" class="text-dark text-decoration-none">Riwayat Pesanan</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center p-3" style="background-color: #ff91a4;">
            &copy; 2024 Minimarket. All Rights Reserved.
        </div>
    </footer>

</body>

</html>
