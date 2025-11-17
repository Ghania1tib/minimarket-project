@extends('layouts.app')

@section('title', 'Dashboard Kasir/Staff')

@section('navbar')
    {{-- Navbar Khusus Staff --}}
    <nav class="navbar navbar-expand-lg fixed-top navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard.staff') }}">
                <i class="fas fa-cash-register me-2"></i>Dashboard <strong>KASIR</strong>
            </a>
            <div class="navbar-nav ms-auto d-flex align-items-center">
                <span class="nav-link text-theme-primary me-3 d-none d-md-block small">
                    Halo, <strong>{{ Auth::user()->nama_lengkap }} ({{ Auth::user()->role }})</strong>
                </span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>
@endsection

@section('content')
    <div class="content-container">
        <h1 class="mb-3 text-theme-primary" style="font-size: 1.75rem;">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard Kasir/Staff
        </h1>
        <hr class="mt-0 mb-4">

        <!-- Quick Actions -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-theme-light">
                <h5 class="text-theme-primary fw-bold mb-0" style="font-size: 1.15rem;">
                    <i class="fas fa-bolt me-2"></i> Quick Actions (Aksi Cepat)
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
                                'route' => 'produk.index',
                                'icon' => 'fas fa-boxes',
                                'title' => 'Manajemen Produk',
                                'color' => 'success',
                            ],
                            [
                                'route' => 'kategori.index',
                                'icon' => 'fas fa-tags',
                                'title' => 'Manajemen Kategori',
                                'color' => 'info',
                            ],
                            [
                                'route' => 'member.index',
                                'icon' => 'fas fa-users',
                                'title' => 'Kelola Member',
                                'color' => 'warning',
                            ],
                            [
                                'route' => 'inventory.check',
                                'icon' => 'fas fa-search',
                                'title' => 'Cek Stok Cepat',
                                'color' => 'secondary',
                            ],
                            [
                                'route' => 'cashier.report',
                                'icon' => 'fas fa-chart-bar',
                                'title' => 'Laporan Singkat',
                                'color' => 'danger',
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
                        <div class="text-success mb-2">
                            <i class="fas fa-shopping-cart fa-2x"></i>
                        </div>
                        <h6 class="card-title text-muted mb-1 small">PENJUALAN HARI INI</h6>
                        <h3 class="text-success mb-0 fw-bold">Rp 1.550.000</h3>
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
                                <p class="mb-0 text-muted small">Stok aman, tidak ada produk dengan stok menipis.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Aktivitas Terbaru -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-theme-light">
                        <h6 class="text-theme-primary fw-bold mb-0" style="font-size: 1rem;">
                            <i class="fas fa-history me-2"></i> Aktivitas Terbaru
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        @php
                            $activities = [
                                [
                                    'title' => 'Transaksi #001',
                                    'time' => '10:30',
                                    'amount' => 'Rp 50.000',
                                    'method' => 'Tunai',
                                ],
                                [
                                    'title' => 'Transaksi #002',
                                    'time' => '10:25',
                                    'amount' => 'Rp 120.000',
                                    'method' => 'QRIS',
                                ],
                                [
                                    'title' => 'Transaksi #003',
                                    'time' => '10:15',
                                    'amount' => 'Rp 75.000',
                                    'method' => 'Debit',
                                ],
                                [
                                    'title' => 'Transaksi #004',
                                    'time' => '10:05',
                                    'amount' => 'Rp 200.000',
                                    'method' => 'Kredit',
                                ],
                            ];
                        @endphp
                        @foreach ($activities as $activity)
                            <div class="d-flex justify-content-between align-items-center p-3 mb-2 bg-light rounded">
                                <div>
                                    <strong style="font-size: 0.9em;">{{ $activity['title'] }}</strong>
                                    <small class="text-muted d-block">({{ $activity['method'] }})</small>
                                    <p class="mb-0 text-success fw-bold">{{ $activity['amount'] }}</p>
                                </div>
                                <small class="text-muted">{{ $activity['time'] }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
