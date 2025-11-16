<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #004f7c;
            --secondary-blue: #003366;
            --accent-pink: #ffb6c1;
            --light-pink: #ffdde1;
            --light-blue: #a1c4fd;
            --gradient-bg: linear-gradient(135deg, #ffdde1 0%, #a1c4fd 100%);
            --card-gradient: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

        body {
            background: var(--gradient-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: none;
            background: var(--card-gradient);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .stats-card {
            border-top: 4px solid;
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: currentColor;
            opacity: 0.3;
        }

        .stats-sales { border-top-color: #28a745; color: #28a745; }
        .stats-products { border-top-color: #17a2b8; color: #17a2b8; }
        .stats-lowstock { border-top-color: #ff6b6b; color: #ff6b6b; }
        .stats-categories { border-top-color: #6f42c1; color: #6f42c1; }

        .quick-action-btn {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 15px 10px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
        }

        .quick-action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 79, 124, 0.3);
            color: white;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
        }

        .section-title {
            color: var(--primary-blue);
            font-weight: 700;
            margin-bottom: 1rem;
            border-left: 4px solid var(--accent-pink);
            padding-left: 10px;
        }

        .activity-item {
            border-left: 3px solid var(--accent-pink);
            padding-left: 15px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .activity-item:hover {
            background: rgba(255, 182, 193, 0.1);
            border-left-color: var(--primary-blue);
        }

        .product-card {
            border: 1px solid rgba(0, 79, 124, 0.1);
            transition: all 0.3s ease;
        }

        .product-card:hover {
            border-color: var(--accent-pink);
            box-shadow: 0 5px 15px rgba(255, 182, 193, 0.2);
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--accent-pink);
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard.staff') }}">
                <i class="fas fa-cash-register me-2"></i>Dashboard Kasir
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    <i class="fas fa-user me-1"></i>Halo, <strong>{{ Auth::user()->nama_lengkap }}</strong>
                </span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm logout-btn">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card stats-card stats-sales h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="card-title text-muted mb-2">PENJUALAN HARI INI</h6>
                                <h3 class="text-success mb-1">Rp 1.550.000</h3>
                                <small class="text-muted">45 transaksi</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-shopping-cart fa-2x opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stats-card stats-products h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="card-title text-muted mb-2">TOTAL PRODUK</h6>
                                <h3 class="text-info mb-1">
                                    @php
                                        $productCount = 0;
                                        if (class_exists('App\Models\Product')) {
                                            $productCount = \App\Models\Product::count();
                                        }
                                    @endphp
                                    {{ $productCount }}
                                </h3>
                                <small class="text-muted">Produk aktif</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-boxes fa-2x opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stats-card stats-lowstock h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="card-title text-muted mb-2">STOK MENIPIS</h6>
                                <h3 class="text-warning mb-1">
                                    @php
                                        $lowStockCount = 0;
                                        if (class_exists('App\Models\Product')) {
                                            // PERBAIKAN: Menggunakan 'stok_kritis' bukan 'stok_minimal'
                                            $lowStockCount = \App\Models\Product::where('stok', '<=', \Illuminate\Support\Facades\DB::raw('stok_kritis'))->count();
                                        }
                                    @endphp
                                    {{ $lowStockCount }}
                                </h3>
                                <small class="text-muted">Perlu restock</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-exclamation-triangle fa-2x opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stats-card stats-categories h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="card-title text-muted mb-2">KATEGORI</h6>
                                <h3 class="text-primary mb-1">
                                    @php
                                        $categoryCount = 0;
                                        if (class_exists('App\Models\Category')) {
                                            $categoryCount = \App\Models\Category::count();
                                        }
                                    @endphp
                                    {{ $categoryCount }}
                                </h3>
                                <small class="text-muted">Kategori produk</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-tags fa-2x opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="section-title"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                        <div class="row g-3">
                            <div class="col-md-2 col-sm-4 col-6">
                                <a href="{{ route('pos.new') }}" class="quick-action-btn text-center">
                                    <i class="fas fa-cash-register fa-2x mb-2 d-block"></i>
                                    <span>POS</span>
                                </a>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6">
                                <a href="{{ route('produk.index') }}" class="quick-action-btn text-center">
                                    <i class="fas fa-boxes fa-2x mb-2 d-block"></i>
                                    <span>Produk</span>
                                </a>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6">
                                <a href="{{ route('kategori.index') }}" class="quick-action-btn text-center">
                                    <i class="fas fa-tags fa-2x mb-2 d-block"></i>
                                    <span>Kategori</span>
                                </a>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6">
                                <a href="#" class="quick-action-btn text-center">
                                    <i class="fas fa-search fa-2x mb-2 d-block"></i>
                                    <span>Cek Stok</span>
                                </a>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6">
                                <a href="{{ route('member.index') }}" class="quick-action-btn text-center">
                                    <i class="fas fa-users fa-2x mb-2 d-block"></i>
                                    <span>Member</span>
                                </a>
                            </div>
                            <div class="col-md-2 col-sm-4 col-6">
                                <a href="{{ route('laporan.kasir') }}" class="quick-action-btn text-center">
                                    <i class="fas fa-chart-bar fa-2x mb-2 d-block"></i>
                                    <span>Laporan</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Stok Menipis -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="section-title"><i class="fas fa-exclamation-triangle me-2"></i>Stok Menipis</h5>

                        @php
                            $lowStockProducts = [];
                            if (class_exists('App\Models\Product')) {
                                // PERBAIKAN: Menggunakan 'stok_kritis' bukan 'stok_minimal'
                                $lowStockProducts = \App\Models\Product::where('stok', '<=', \Illuminate\Support\Facades\DB::raw('stok_kritis'))
                                    ->orderBy('stok', 'asc')
                                    ->take(5)
                                    ->get();
                            }
                        @endphp

                        @if(count($lowStockProducts) > 0)
                            <div class="list-group list-group-flush">
                                @foreach($lowStockProducts as $product)
                                    <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                        <div>
                                            <h6 class="mb-1">{{ $product->nama_produk }}</h6>
                                            <small class="text-muted">Stok: {{ $product->stok }} | Minimal: {{ $product->stok_kritis }}</small>
                                        </div>
                                        <span class="badge bg-danger rounded-pill">{{ $product->stok }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('produk.index') }}" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-list me-1"></i>Lihat Semua
                                </a>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-check-circle"></i>
                                <p class="mb-0">Tidak ada produk dengan stok menipis.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Aktivitas Terbaru -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="section-title"><i class="fas fa-history me-2"></i>Aktivitas Terbaru</h5>

                        <div class="activity-item">
                            <div class="d-flex w-100 justify-content-between">
                                <strong>Transaksi #001</strong>
                                <small>10:30</small>
                            </div>
                            <p class="mb-1 text-success">Rp 50.000 - Tunai</p>
                        </div>

                        <div class="activity-item">
                            <div class="d-flex w-100 justify-content-between">
                                <strong>Transaksi #002</strong>
                                <small>10:25</small>
                            </div>
                            <p class="mb-1 text-success">Rp 120.000 - QRIS</p>
                        </div>

                        <div class="activity-item">
                            <div class="d-flex w-100 justify-content-between">
                                <strong>Transaksi #003</strong>
                                <small>10:15</small>
                            </div>
                            <p class="mb-1 text-success">Rp 75.000 - Debit</p>
                        </div>

                        <div class="activity-item">
                            <div class="d-flex w-100 justify-content-between">
                                <strong>Transaksi #004</strong>
                                <small>10:05</small>
                            </div>
                            <p class="mb-1 text-success">Rp 200.000 - Kredit</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produk Terpopuler -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="section-title"><i class="fas fa-star me-2"></i>Produk Terpopuler</h5>

                        <div class="row">
                            @php
                                $popularProducts = [];
                                if (class_exists('App\Models\Product')) {
                                    $popularProducts = \App\Models\Product::orderBy('created_at', 'desc')
                                        ->take(4)
                                        ->get();
                                }
                            @endphp

                            @if(count($popularProducts) > 0)
                                @foreach($popularProducts as $product)
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <div class="card product-card h-100">
                                            @if(isset($product->gambar_url) && $product->gambar_url)
                                                <img src="{{ asset('storage/' . $product->gambar_url) }}" class="card-img-top" alt="{{ $product->nama_produk }}" style="height: 120px; object-fit: cover;">
                                            @else
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 120px;">
                                                    <i class="fas fa-image fa-2x text-muted"></i>
                                                </div>
                                            @endif
                                            <div class="card-body">
                                                <h6 class="card-title">{{ \Illuminate\Support\Str::limit($product->nama_produk ?? 'Produk', 20) }}</h6>
                                                <p class="card-text mb-1 text-success fw-bold">
                                                    Rp {{ number_format($product->harga_jual ?? 0, 0, ',', '.') }}
                                                </p>
                                                <small class="text-muted">Stok: {{ $product->stok ?? 0 }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12">
                                    <div class="empty-state">
                                        <i class="fas fa-box-open"></i>
                                        <p class="mb-0">Belum ada produk terpopuler</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animasi sederhana untuk cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>
