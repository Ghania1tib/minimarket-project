<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir/Staff - Toko Saudara 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 280px;
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
            margin: 0;
            padding: 0;
            background: var(--gradient-bg);
            font-family: var(--font-family);
            min-height: 100vh;
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .content-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: margin-left 0.3s ease;
            background: var(--gradient-bg);
            min-height: 100vh;
        }

        .content-container {
            background: white;
            border-radius: var(--border-radius-lg);
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
        }

        .text-theme-primary {
            color: var(--color-primary) !important;
        }

        .bg-theme-light {
            background-color: var(--color-light) !important;
        }

        .navbar-custom {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .navbar-custom .navbar-brand {
            color: white !important;
            font-weight: bold;
        }

        .navbar-custom .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .navbar-custom .nav-link:hover {
            color: white !important;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                margin-left: 0;
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="main-wrapper">
        <!-- Sidebar -->
        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'owner')
            @include('layouts.sidebar-admin')
        @elseif(Auth::user()->role === 'kasir' || Auth::user()->role === 'staff')
            @include('layouts.sidebar-kasir')
        @endif

        <div class="content-wrapper">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-custom">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('dashboard.staff') }}">
                        <i class="fas fa-cash-register me-2"></i>Dashboard <strong>KASIR</strong>
                    </a>
                    <div class="navbar-nav ms-auto d-flex align-items-center">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">
                                <i class="fas fa-home me-1"></i> Beranda
                            </a>
                        </li>
                        <span class="nav-link text-theme-primary me-3 d-none d-md-block small">
                            Halo, <strong>{{ Auth::user()->nama_lengkap }} ({{ Auth::user()->role }})</strong>
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-sign-out-alt"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </nav>

            <!-- Content -->
            <div class="content-container">
                <h1 class="mb-3 text-theme-primary" style="font-size: 1.75rem;">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard Kasir/Staff
                </h1>
                <hr class="mt-0 mb-4">

                <!-- Quick Actions -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-theme-light">
                        <h5 class="text-theme-primary fw-bold mb-0" style="font-size: 1.15rem;">
                            <i class="fas fa-bolt me-2"></i> Aksi Cepat
                        </h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-3">
                            @php
                                $quickActions = [
                                    [
                                        'route' => 'pos.new',
                                        'icon' => 'fas fa-cash-register',
                                        'title' => 'POS Baru',
                                        'color' => 'primary',
                                    ],

                                    [
                                        'route' => 'inventory.check',
                                        'icon' => 'fas fa-search',
                                        'title' => 'Cek Stok Cepat',
                                        'color' => 'secondary',
                                    ],
                                    [
                                        'route' => 'payment.verification.orders.index',
                                        'icon' => 'fas fa-clipboard-list',
                                        'title' => 'Manajemen Pesanan',
                                        'color' => 'info',
                                    ],
                                    [
                                        'route' => 'payment.verification.index',
                                        'icon' => 'fas fa-check-circle',
                                        'title' => 'Verifikasi Pembayaran',
                                        'color' => 'warning',
                                    ],
                                ];
                            @endphp
                            @foreach ($quickActions as $action)
                                <div class="col-xl-2 col-md-4 col-sm-6">
                                    <a href="{{ route($action['route']) }}"
                                        class="btn btn-{{ $action['color'] }} w-100 text-center d-flex flex-column align-items-center py-3"
                                        style="border-radius: 10px;">
                                        <i class="{{ $action['icon'] }} fa-2x mb-2"></i>
                                        <span class="fw-bold" style="font-size: 0.85em;">{{ $action['title'] }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4 g-3">
                    <div class="col-md-3">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body text-center p-3">
                                <div class="text-warning mb-2">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                                <h6 class="card-title text-muted mb-1 small">VERIFIKASI DIBUTUHKAN</h6>
                                <h3 class="text-warning mb-0 fw-bold">
                                    @php
                                        $pendingVerification = \App\Models\Order::where(
                                            'status_pembayaran',
                                            'menunggu_verifikasi',
                                        )
                                            ->where('tipe_pesanan', 'website')
                                            ->count();
                                    @endphp
                                    {{ $pendingVerification }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body text-center p-3">
                                <div class="text-theme-primary mb-2">
                                    <i class="fas fa-boxes fa-2x"></i>
                                </div>
                                <h6 class="card-title text-muted mb-1 small">TOTAL PRODUK</h6>
                                <h3 class="text-theme-primary mb-0 fw-bold">
                                    @php $productCount = class_exists('App\Models\Product') ? \App\Models\Product::count() : 12; @endphp
                                    {{ $productCount }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body text-center p-3">
                                <div class="text-danger mb-2">
                                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                                </div>
                                <h6 class="card-title text-muted mb-1 small">STOK MENIPIS</h6>
                                <h3 class="text-danger mb-0 fw-bold">
                                    @php
                                        $lowStockCount = 0;
                                        if (class_exists('App\Models\Product')) {
                                            $lowStockCount = \App\Models\Product::where(
                                                'stok',
                                                '<=',
                                                \Illuminate\Support\Facades\DB::raw('stok_kritis'),
                                            )->count();
                                        }
                                    @endphp
                                    {{ $lowStockCount }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body text-center p-3">
                                <div class="text-secondary mb-2">
                                    <i class="fas fa-tags fa-2x"></i>
                                </div>
                                <h6 class="card-title text-muted mb-1 small">KATEGORI</h6>
                                <h3 class="text-secondary mb-0 fw-bold">
                                    @php $categoryCount = class_exists('App\Models\Category') ? \App\Models\Category::count() : 5; @endphp
                                    {{ $categoryCount }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Row -->
                <div class="row g-3">
                    <!-- Stok Menipis -->
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-theme-light">
                                <h6 class="text-danger fw-bold mb-0" style="font-size: 1rem;">
                                    <i class="fas fa-exclamation-triangle me-2"></i> Stok Menipis
                                </h6>
                            </div>
                            <div class="card-body p-3">
                                @if ($lowStockCount > 0)
                                    <div class="list-group list-group-flush">
                                        @php
                                            $lowStockProducts = \App\Models\Product::where(
                                                'stok',
                                                '<=',
                                                \Illuminate\Support\Facades\DB::raw('stok_kritis'),
                                            )
                                                ->orderBy('stok', 'asc')
                                                ->take(5)
                                                ->get();
                                        @endphp
                                        @foreach ($lowStockProducts as $product)
                                            <div
                                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                                <div>
                                                    <h6 class="mb-0">{{ $product->nama_produk }}</h6>
                                                    <small class="text-muted">Min: {{ $product->stok_kritis }}</small>
                                                </div>
                                                <span class="badge bg-danger rounded-pill">{{ $product->stok }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ route('produk.index') }}" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-list me-1"></i>Lihat Semua Produk
                                        </a>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                        <p class="mb-0 text-muted small">Stok aman, tidak ada produk dengan stok
                                            menipis.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                  <!-- Aktivitas Terbaru -->
<div class="col-md-6">
    <div class="card h-100 shadow-sm">
        <div class="card-header bg-theme-light">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="text-theme-primary fw-bold mb-0" style="font-size: 1rem;">
                    <i class="fas fa-history me-2"></i> Aktivitas Terbaru
                </h6>
                <button onclick="location.reload()" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-3">
            @if($recentActivities->count() > 0)
                @foreach($recentActivities as $activity)
                    <div class="d-flex justify-content-between align-items-center p-3 mb-2 bg-light rounded">
                        <div>
                            <strong style="font-size: 0.9em;">{{ $activity['title'] }}</strong>
                            <p class="mb-1 text-{{ $activity['color'] }} fw-bold">
                                {{ $activity['description'] }}
                            </p>
                            <small class="text-muted">{{ $activity['user'] }}</small>
                        </div>
                        <small class="text-muted">{{ $activity['time']->format('H:i') }}</small>
                    </div>
                @endforeach
            @else
                <div class="text-center py-4">
                    <i class="fas fa-history fa-2x text-muted mb-2"></i>
                    <p class="mb-0 text-muted small">Belum ada aktivitas terbaru</p>
                </div>
            @endif
        </div>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
