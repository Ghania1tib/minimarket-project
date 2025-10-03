
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>minimarket - Beranda</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(to right, #ffdde1, #a1c4fd);
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
        }

        .navbar {
            background-color: #ffb6c1;
        }

        .navbar .nav-link {
            color: #003366 !important;
            font-weight: 500;
        }

        .navbar-brand {
            font-weight: bold;
            color: #003366 !important;
        }

        .container h1 {
            color: #004f7c;
            font-weight: bold;
        }

        .card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform .2s;
        }

        .card:hover {
            transform: scale(1.03);
        }

        /* Tambahan styling untuk banner */
        .hero-banner-card {
            min-height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            color: white;
            padding: 25px;
            border-radius: 15px;
            background-color: #004f7c; /* Warna default jika gambar tidak ada */
        }
    </style>
</head>

<body>
    {{-- ======================================================= --}}
    {{-- HEADER (NAVBAR) --}}
    {{-- ======================================================= --}}
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fa-solid fa-cart-shopping"></i> Supermarket 4</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                {{-- Tambahkan Search Bar agar sesuai dengan standar supermarket web --}}
                <form class="d-flex mx-auto w-50 my-2 my-lg-0" role="search">
                    <input class="form-control me-2" type="search" placeholder="Cari produk (mis. Minyak Goreng, Bawang)" aria-label="Search">
                    <button class="btn btn-outline-dark" type="submit"><i class="bi bi-search"></i></button>
                </form>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-geo-alt"></i> Lokasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('kategori.index') }}"><i class="bi bi-tags"></i> Kategori</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-person-circle"></i> Akun</a></li>
                    {{-- Ikon Keranjang Belanja --}}
                    <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-cart"></i> Keranjang (0)</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">

        {{-- ======================================================= --}}
        {{-- BAGIAN 1: HERO SECTION (PROMOSI UTAMA) --}}
        {{-- Asumsi data $heroBanners dikirim dari Controller --}}
        {{-- ======================================================= --}}
        <h1 class="text-center mb-5">Belanja Segar & Hemat Setiap Hari</h1>
        <div class="row g-4 mb-5">
            @if(isset($heroBanners) && count($heroBanners) > 0)
                @foreach ($heroBanners as $banner)
                    <div class="col-md-6">
                        <a href="{{ $banner['link'] }}" class="text-decoration-none">
                            <div class="hero-banner-card shadow-lg" style="background-color: {{ $loop->index % 2 == 0 ? '#ff6347' : '#3cb371' }};">
                                <h3>{{ $banner['title'] }}</h3>
                                <p class="mb-2">{{ $banner['subtitle'] }}</p>
                                <span class="btn btn-light btn-sm text-dark fw-bold">Belanja Sekarang <i class="bi bi-arrow-right"></i></span>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                 <div class="col-12"><div class="alert alert-warning text-center">Tidak ada promosi utama saat ini.</div></div>
            @endif
        </div>

        <hr class="my-5">

        {{-- ======================================================= --}}
        {{-- BAGIAN 2: KATEGORI POPULER (NAVIGASI CEPAT) --}}
        {{-- Asumsi data $popularCategories dikirim dari Controller --}}
        {{-- ======================================================= --}}
        <h2 class="text-center mb-4 text-primary">Jelajahi Kategori Favorit Anda</h2>
        <div class="row text-center justify-content-center g-3 mb-5">
            @if(isset($popularCategories) && count($popularCategories) > 0)
                @foreach ($popularCategories as $category)
                    <div class="col-md-2 col-4">
                        <a href="{{ $category['link'] }}" class="card p-3 shadow-sm text-decoration-none h-100">
                            <div style="font-size: 2rem;">{{ $category['icon'] }}</div>
                            <p class="mt-2 mb-0 fw-bold text-dark">{{ $category['name'] }}</p>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>

        <hr class="my-5">

        {{-- ======================================================= --}}
        {{-- BAGIAN 3: FLASH SALE (PENJUALAN TERBATAS) --}}
        {{-- Asumsi data $flashSaleProducts dikirim dari Controller --}}
        {{-- ======================================================= --}}
    <h2 class="mb-4 text-danger text-center">
    <i class="bi bi-lightning-fill"></i> FLASH SALE!
    {{-- Tampilkan string hitung mundur dari Controller --}}
    <small class="text-muted fs-6">
        Berakhir dalam:
        {{-- Jika waktu sudah berakhir, tampilkan pesan --}}
        @if ($countdownString === '00:00:00')
            SUDAH BERAKHIR!
        @else
            {{ $countdownString }}
        @endif
    </small>
    </h2>
<div class="row g-4 mb-5">
            @if(isset($flashSaleProducts) && count($flashSaleProducts) > 0)
                @foreach ($flashSaleProducts as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card h-100">
                            <img src="https://via.placeholder.com/300x200?text=Flash+Sale" class="card-img-top" alt="{{ $product['name'] }}">
                            <div class="card-body text-center">
                                <h5 class="card-title text-truncate">{{ $product['name'] }}</h5>
                                <p class="text-danger fw-bold fs-5">Rp{{ number_format($product['discount_price'], 0, ',', '.') }}</p>
                                <p class="text-muted mb-2"><s>Rp{{ number_format($product['price'], 0, ',', '.') }}</s></p>
                                <span class="badge bg-danger mb-3">-{{ round((($product['price'] - $product['discount_price']) / $product['price']) * 100) }}%</span>
                                <a href="#" class="btn btn-sm btn-outline-danger w-100"><i class="bi bi-cart-plus"></i> Tambah</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                 <div class="col-12"><div class="alert alert-info text-center">Tidak ada produk Flash Sale saat ini.</div></div>
            @endif
        </div>

        <hr class="my-5">

        {{-- ======================================================= --}}
        {{-- BAGIAN 4: PRODUK TERBARU (Sesuai dengan kode asli Anda) --}}
        {{-- ======================================================= --}}
        <h2 class="text-center mb-4 text-success"><i class="bi bi-box-seam"></i> Produk Terbaru Kami</h2>
        <div class="row g-4">
            @if(isset($produk) && count($produk) > 0)
                @foreach ($produk as $item)
                    <div class="col-md-4 col-lg-3 col-sm-6">
                        <div class="card h-100">
                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" alt="{{ $item->nama }}" style="height: 150px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="{{ $item->nama }}" style="height: 150px; object-fit: cover;">
                            @endif
                            <div class="card-body text-center">
                                <h5 class="card-title text-truncate">{{ $item->nama }}</h5>
                                <p class="card-text fw-bold">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                <p class="text-muted small">{{ $item->kategori->nama ?? 'Tanpa Kategori' }}</p>
                                <a href="{{ route('produk.show', $item->id) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <a href="#" class="btn btn-success btn-sm"><i class="bi bi-cart-plus"></i> Beli</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12"><div class="alert alert-info text-center">Tidak ada produk untuk ditampilkan saat ini.</div></div>
            @endif
        </div>
    </div>

    {{-- ======================================================= --}}
    {{-- FOOTER (Tambahan) --}}
    {{-- ======================================================= --}}
    <footer class="bg-light text-center text-lg-start mt-5">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase"><i class="fa-solid fa-cart-shopping"></i> Supermarket 4</h5>
                    <p>
                        Jaminan kesegaran produk dan pengiriman tepat waktu langsung ke pintu rumah Anda.
                    </p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Informasi</h5>
                    <ul class="list-unstyled mb-0">
                        <li><a href="/about" class="text-dark text-decoration-none">About Us</a></li>
                        <li><a href="/contact" class="text-dark text-decoration-none">Contact Us</a></li>
                        <li><a href="/terms" class="text-dark text-decoration-none">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Bantuan</h5>
                    <ul class="list-unstyled mb-0">
                        <li><a href="#!" class="text-dark text-decoration-none">FAQ</a></li>
                        <li><a href="#!" class="text-dark text-decoration-none">Layanan Pelanggan</a></li>
                        <li><a href="#!" class="text-dark text-decoration-none">Cek Pesanan</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center p-3" style="background-color: #ffb6c1;">
            © 2024 Supermarket 4. All Rights Reserved.
        </div>
    </footer>
</body>
</html>
