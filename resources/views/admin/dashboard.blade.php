<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --color-primary: #5E548E;
            --color-secondary: #9F86C0;
            --color-accent: #E0B1CB;
            --color-danger: #E07A5F;
            --color-success: #70C1B3;
            --color-light: #F0E6EF;
            --color-white: #ffffff;
            --gradient-bg: linear-gradient(135deg, #F0E6EF 0%, #D891EF 100%);
            --font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            --border-radius-lg: 15px;
            --border-radius-sm: 8px;
        }

        body {
            background: var(--gradient-bg);
            font-family: var(--font-family);
            min-height: 100vh;
        }

        .navbar {
            background-color: var(--color-accent);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand,
        .navbar-nav .nav-link {
            font-weight: 700;
            color: var(--color-primary) !important;
        }

        .card {
            border-radius: var(--border-radius-lg);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: none;
            background: var(--color-white);
            margin-bottom: 20px;
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

        .stats-sales { border-top-color: var(--color-success); color: var(--color-success); }
        .stats-products { border-top-color: var(--color-secondary); color: var(--color-secondary); }
        .stats-lowstock { border-top-color: var(--color-danger); color: var(--color-danger); }
        .stats-categories { border-top-color: var(--color-primary); color: var(--color-primary); }
        .stats-users { border-top-color: #6f42c1; color: #6f42c1; }
        .stats-revenue { border-top-color: var(--color-success); color: var(--color-success); }

        .quick-action-btn {
            background-color: var(--color-primary);
            color: white;
            border: none;
            border-radius: var(--border-radius-sm);
            padding: 20px 15px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
            height: 100%;
        }

        .quick-action-btn:hover {
            background-color: var(--color-secondary);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(94, 84, 142, 0.3);
            color: white;
        }

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

        .section-title {
            color: var(--color-primary);
            font-weight: 700;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--color-accent);
            padding-left: 15px;
            font-size: 1.25rem;
        }

        .activity-item {
            border-left: 3px solid var(--color-accent);
            padding-left: 15px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .activity-item:hover {
            background: rgba(224, 177, 203, 0.1);
            border-left-color: var(--color-primary);
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

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--color-accent);
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .management-card {
            border-left: 4px solid var(--color-accent);
        }

        .report-card {
            border-left: 4px solid var(--color-primary);
        }

        .progress {
            height: 8px;
            border-radius: 10px;
        }

        .badge-pill {
            border-radius: 15px;
            padding: 6px 12px;
        }

        .product-card {
            border: 1px solid rgba(94, 84, 142, 0.1);
            transition: all 0.3s ease;
        }

        .product-card:hover {
            border-color: var(--color-accent);
            box-shadow: 0 5px 15px rgba(224, 177, 203, 0.2);
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link me-3" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home me-1"></i>Home
                </a>
                <span class="navbar-text me-3">
                    <i class="fas fa-user me-1"></i>{{ Auth::user()->nama_lengkap }}
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
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="text-primary mb-1" style="color: var(--color-primary) !important;">Selamat Datang, {{ Auth::user()->nama_lengkap }}!</h3>
                                <p class="text-muted mb-0">Berikut adalah ringkasan aktivitas dan statistik toko Anda hari ini.</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="text-muted">
                                    <i class="fas fa-calendar me-2"></i>{{ now()->translatedFormat('l, d F Y') }}
                                </div>
                                <div class="text-muted">
                                    <i class="fas fa-clock me-2"></i>{{ now()->format('H:i') }} WIB
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-2 col-md-4">
                <div class="card stats-card stats-sales h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="card-title text-muted mb-2">PENJUALAN HARI INI</h6>
                                <h3 class="mb-1" style="color: var(--color-success) !important;">Rp 2.450.000</h3>
                                <small class="text-muted">68 transaksi</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-shopping-cart fa-2x opacity-25"></i>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="badge bg-success badge-pill">
                                <i class="fas fa-arrow-up me-1"></i>12.5%
                            </span>
                            <small class="text-muted ms-1">vs kemarin</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4">
                <div class="card stats-card stats-products h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="card-title text-muted mb-2">TOTAL PRODUK</h6>
                                <h3 class="mb-1" style="color: var(--color-secondary) !important;">
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

            <div class="col-xl-2 col-md-4">
                <div class="card stats-card stats-lowstock h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="card-title text-muted mb-2">STOK MENIPIS</h6>
                                <h3 class="mb-1" style="color: var(--color-danger) !important;">
                                    @php
                                        $lowStockCount = 0;
                                        if (class_exists('App\Models\Product')) {
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

            <div class="col-xl-2 col-md-4">
                <div class="card stats-card stats-categories h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="card-title text-muted mb-2">KATEGORI</h6>
                                <h3 class="mb-1" style="color: var(--color-primary) !important;">
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

            <div class="col-xl-2 col-md-4">
                <div class="card stats-card stats-users h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="card-title text-muted mb-2">PENGGUNA</h6>
                                <h3 class="mb-1" style="color: #6f42c1 !important;">
                                    @php
                                        $userCount = 0;
                                        if (class_exists('App\Models\User')) {
                                            $userCount = \App\Models\User::count();
                                        }
                                    @endphp
                                    {{ $userCount }}
                                </h3>
                                <small class="text-muted">Total pengguna</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-users fa-2x opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4">
                <div class="card stats-card stats-revenue h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="card-title text-muted mb-2">PENDAPATAN BULAN INI</h6>
                                <h3 class="mb-1" style="color: var(--color-success) !important;">Rp 48.5 Jt</h3>
                                <small class="text-muted">Target: Rp 50 Jt</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-chart-line fa-2x opacity-25"></i>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="progress">
                                <div class="progress-bar" style="background-color: var(--color-success); width: 97%" role="progressbar" aria-valuenow="97" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Management Data Master -->
            <div class="col-lg-6">
                <div class="card management-card h-100">
                    <div class="card-body">
                        <h5 class="section-title"><i class="fas fa-database me-2"></i>Management Data Master</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <a href="{{ route('produk.index') }}" class="quick-action-btn text-center">
                                    <i class="fas fa-box fa-3x mb-3 d-block"></i>
                                    <h6>Produk</h6>
                                    <small class="d-block opacity-75">CRUD Produk</small>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('kategori.index') }}" class="quick-action-btn text-center">
                                    <i class="fas fa-tags fa-3x mb-3 d-block"></i>
                                    <h6>Kategori</h6>
                                    <small class="d-block opacity-75">CRUD Kategori</small>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('user.index') }}" class="quick-action-btn text-center">
                                    <i class="fas fa-users fa-3x mb-3 d-block"></i>
                                    <h6>Akun Pengguna</h6>
                                    <small class="d-block opacity-75">CRUD User</small>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{route ('promo.index')}}" class="quick-action-btn text-center">
                                    <i class="fas fa-percentage fa-3x mb-3 d-block"></i>
                                    <h6>Promo & Diskon</h6>
                                    <small class="d-block opacity-75">CRUD Promo</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Laporan & Analisis -->
            <div class="col-lg-6">
                <div class="card report-card h-100">
                    <div class="card-body">
                        <h5 class="section-title"><i class="fas fa-chart-bar me-2"></i>Laporan & Analisis</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <a href="#" class="quick-action-btn text-center">
                                    <i class="fas fa-file-invoice-dollar fa-3x mb-3 d-block"></i>
                                    <h6>Laporan Penjualan</h6>
                                    <small class="d-block opacity-75">Lihat Laporan</small>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="#" class="quick-action-btn text-center">
                                    <i class="fas fa-history fa-3x mb-3 d-block"></i>
                                    <h6>Riwayat Stok</h6>
                                    <small class="d-block opacity-75">Lihat Riwayat</small>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="#" class="quick-action-btn text-center">
                                    <i class="fas fa-chart-pie fa-3x mb-3 d-block"></i>
                                    <h6>Analisis Produk</h6>
                                    <small class="d-block opacity-75">Statistik Produk</small>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="#" class="quick-action-btn text-center">
                                    <i class="fas fa-download fa-3x mb-3 d-block"></i>
                                    <h6>Export Data</h6>
                                    <small class="d-block opacity-75">Download Laporan</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart and Activity Section -->
        <div class="row mt-4">
            <!-- Chart Penjualan -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="section-title"><i class="fas fa-chart-line me-2"></i>Statistik Penjualan 7 Hari Terakhir</h5>
                        <div class="chart-container">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aktivitas Terbaru -->
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="section-title"><i class="fas fa-history me-2"></i>Aktivitas Terbaru</h5>

                        <div class="activity-item">
                            <div class="d-flex w-100 justify-content-between">
                                <strong>Transaksi #00125</strong>
                                <small>10:30</small>
                            </div>
                            <p class="mb-1 text-success">Rp 250.000 - Tunai</p>
                            <small class="text-muted">Kasir: Budi</small>
                        </div>

                        <div class="activity-item">
                            <div class="d-flex w-100 justify-content-between">
                                <strong>Produk Baru</strong>
                                <small>09:45</small>
                            </div>
                            <p class="mb-1 text-info">Indomie Goreng ditambahkan</p>
                            <small class="text-muted">Admin: Sari</small>
                        </div>

                        <div class="activity-item">
                            <div class="d-flex w-100 justify-content-between">
                                <strong>Stok Diperbarui</strong>
                                <small>09:15</small>
                            </div>
                            <p class="mb-1 text-warning">Aqua 600ml stok +50</p>
                            <small class="text-muted">Sistem</small>
                        </div>

                        <div class="activity-item">
                            <div class="d-flex w-100 justify-content-between">
                                <strong>User Baru</strong>
                                <small>08:30</small>
                            </div>
                            <p class="mb-1 text-primary">Kasir baru: Rina</p>
                            <small class="text-muted">Admin: Andi</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock and Popular Products -->
        <div class="row mt-4">
            <!-- Produk Stok Menipis -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="section-title"><i class="fas fa-exclamation-triangle me-2"></i>Produk Stok Menipis</h5>

                        @php
                            $lowStockProducts = [];
                            if (class_exists('App\Models\Product')) {
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

            <!-- Produk Terpopuler -->
            <div class="col-lg-6">
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
                                    <div class="col-md-6 mb-3">
                                        <div class="card product-card h-100">
                                            @if(isset($product->gambar_url) && $product->gambar_url)
                                                <img src="{{ asset('storage/' . $product->gambar_url) }}" class="card-img-top" alt="{{ $product->nama_produk }}" style="height: 100px; object-fit: cover;">
                                            @else
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 100px;">
                                                    <i class="fas fa-image fa-2x text-muted"></i>
                                                </div>
                                            @endif
                                            <div class="card-body p-2">
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
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: [1200000, 1900000, 1500000, 2200000, 2450000, 3000000, 2800000],
                        borderColor: '#5E548E',
                        backgroundColor: 'rgba(94, 84, 142, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>
