<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --color-primary: #004f7c;
            --color-accent: #ff6347;
            --color-light: #ffb6c1;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .content-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .cart-item {
            border-bottom: 1px solid #e0e0e0;
            padding: 20px 0;
            transition: all 0.3s ease;
        }

        .cart-item:hover {
            background: #f8f9fa;
            border-radius: 10px;
            padding-left: 15px;
            padding-right: 15px;
        }

        .btn-primary-custom {
            background: linear-gradient(45deg, #004f7c, #0066a5);
            border: none;
            font-weight: bold;
            padding: 10px 25px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 79, 124, 0.4);
        }

        .btn-accent {
            background: linear-gradient(45deg, #ff6347, #ff4500);
            border: none;
            color: white;
            font-weight: bold;
            padding: 12px 30px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-accent:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 99, 71, 0.4);
            color: white;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #e0e0e0;
        }

        .quantity-input {
            width: 80px;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            text-align: center;
        }

        .summary-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            border: none;
        }

        .empty-cart {
            padding: 60px 20px;
        }

        .empty-cart i {
            font-size: 80px;
            color: #6c757d;
            margin-bottom: 20px;
        }

        footer {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            margin-top: 50px;
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- NAV BAR -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top navbar-custom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="fas fa-shopping-basket me-2"></i> MINI<span style="color: var(--color-accent);">MARKET</span>
            </a>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('produk.index') }}">Semua Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('kategori.index') }}">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="{{ route('cart.index') }}">Keranjang</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-dark position-relative me-3">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count">
                            {{ $cartItems->count() }}
                        </span>
                    </a>
                    @auth
                        <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-primary-custom">
                            <i class="fas fa-user-circle me-1"></i> Akun Saya
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary-custom">
                            <i class="fas fa-user me-1"></i> Masuk
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="content-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0"><i class="fas fa-shopping-cart me-2"></i> Keranjang Belanja</h2>
            @if(!$cartItems->isEmpty())
                <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin mengosongkan keranjang?')">
                        <i class="fas fa-trash me-1"></i> Kosongkan Keranjang
                    </button>
                </form>
            @endif
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($cartItems->isEmpty())
            <div class="text-center empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <h3 class="text-muted mt-3">Keranjang belanja Anda kosong</h3>
                <p class="text-muted">Silakan tambahkan produk ke keranjang Anda</p>
                <a href="{{ route('home') }}" class="btn btn-primary-custom btn-lg mt-3">
                    <i class="fas fa-shopping-bag me-2"></i> Mulai Belanja
                </a>
            </div>
        @else
            <div class="row">
                <div class="col-lg-8">
                    @foreach($cartItems as $item)
                        <div class="cart-item">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="{{ $item->product->full_gambar_url }}"
                                         alt="{{ $item->product->nama_produk }}"
                                         class="product-image">
                                </div>
                                <div class="col-md-4">
                                    <h6 class="fw-bold mb-1">{{ $item->product->nama_produk }}</h6>
                                    <small class="text-muted">
                                        {{ $item->product->category->nama_kategori ?? 'Umum' }}
                                    </small>
                                    <div class="mt-2">
                                        @if($item->product->stok < 10 && $item->product->stok > 0)
                                            <span class="badge bg-warning">Stok Terbatas</span>
                                        @elseif($item->product->stok <= 0)
                                            <span class="badge bg-danger">Stok Habis</span>
                                        @else
                                            <span class="badge bg-success">Tersedia</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <p class="fw-bold text-primary mb-0">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                                </div>
                                <div class="col-md-2">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex align-items-center">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="jumlah" value="{{ $item->jumlah }}"
                                               min="1" max="{{ $item->product->stok }}"
                                               class="form-control quantity-input">
                                        <button type="submit" class="btn btn-sm btn-outline-primary ms-2" title="Update">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>
                                    <small class="text-muted">Stok: {{ $item->product->stok }}</small>
                                </div>
                                <div class="col-md-2 text-end">
                                    <p class="fw-bold text-success mb-1">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus produk dari keranjang?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="col-lg-4">
                    <div class="card summary-card shadow-lg">
                        <div class="card-body">
                            <h5 class="card-title mb-4"><i class="fas fa-receipt me-2"></i> Ringkasan Belanja</h5>

                            <div class="d-flex justify-content-between mb-3">
                                <span>Total Item:</span>
                                <span class="fw-bold">{{ $cartItems->sum('jumlah') }} item</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span>Subtotal:</span>
                                <span class="fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span>Biaya Pengiriman:</span>
                                <span class="fw-bold">Rp 15.000</span>
                            </div>

                            <hr style="border-color: rgba(255,255,255,0.3);">

                            <div class="d-flex justify-content-between mb-4">
                                <span class="fw-bold fs-5">Total:</span>
                                <span class="fw-bold fs-5">Rp {{ number_format($total + 15000, 0, ',', '.') }}</span>
                            </div>

                            <a href="{{ route('checkout') }}" class="btn btn-light w-100 btn-lg fw-bold">
                                <i class="fas fa-credit-card me-2"></i> Lanjut ke Pembayaran
                            </a>

                            <a href="{{ route('home') }}" class="btn btn-outline-light w-100 mt-2">
                                <i class="fas fa-arrow-left me-2"></i> Lanjutkan Belanja
                            </a>
                        </div>
                    </div>

                    <div class="card mt-3 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <h6><i class="fas fa-shield-alt text-success me-2"></i> Transaksi Aman</h6>
                            <p class="small text-muted mb-0">Data pembayaran Anda dilindungi dengan enkripsi</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- FOOTER -->
    <footer class="text-center text-lg-start">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase"><i class="fas fa-shopping-basket me-2"></i> Minimarket</h5>
                    <p>Belanja mudah, cepat, dan terpercaya. Jaminan produk segar dan berkualitas.</p>
                    <div class="mt-3">
                        <a href="#" class="text-dark me-3"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-dark me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-dark me-3"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-dark"><i class="fab fa-whatsapp fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Informasi</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('about') }}" class="text-dark text-decoration-none">Tentang Kami</a></li>
                        <li><a href="{{ route('contact') }}" class="text-dark text-decoration-none">Hubungi Kami</a></li>
                        <li><a href="{{ route('terms') }}" class="text-dark text-decoration-none">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Bantuan</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-dark text-decoration-none">Cara Belanja</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Pembayaran</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Pengiriman</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Akun Anda</h5>
                    <ul class="list-unstyled">
                        @auth
                        <li><a href="{{ route('pelanggan.profil') }}" class="text-dark text-decoration-none">Profil</a></li>
                        <li><a href="{{ route('pelanggan.pesanan') }}" class="text-dark text-decoration-none">Pesanan</a></li>
                        <li><a href="{{ route('cart.index') }}" class="text-dark text-decoration-none">Keranjang</a></li>
                        @else
                        <li><a href="{{ route('login') }}" class="text-dark text-decoration-none">Masuk</a></li>
                        <li><a href="{{ route('signup') }}" class="text-dark text-decoration-none">Daftar</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center p-3 bg-dark text-white">
            &copy; 2024 Minimarket. All rights reserved.
        </div>
    </footer>

    <script>
        // Update cart count
        function updateCartCount() {
            fetch('{{ route("cart.count") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').textContent = data.count;
                });
        }

        // Auto update quantity
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();

            // Add loading state to update buttons
            const updateForms = document.querySelectorAll('form[action*="/cart/update"]');
            updateForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const button = this.querySelector('button[type="submit"]');
                    button.innerHTML = '<span class="loading-spinner"></span>';
                    button.disabled = true;
                });
            });
        });
    </script>
</body>
</html>
