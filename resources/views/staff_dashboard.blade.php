@extends('layouts.app')

@section('title', 'Dashboard Kasir/Staff')

@section('navbar')
    {{-- Navbar Khusus Staff --}}
    <nav class="navbar navbar-expand-lg fixed-top navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard.staff') }}">
                <i class="fas fa-cash-register me-2"></i>Dashboard **KASIR**
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

        <h1 class="mb-3 text-theme-primary" style="font-size: 1.75rem;"><i class="fas fa-tachometer-alt me-2"></i> Dashboard Kasir/Staff</h1>
        <hr class="mt-0 mb-4">

        <div class="card mb-4 shadow-sm">
            <div class="card-body p-3">
                <h5 class="text-theme-primary fw-bold mb-3" style="font-size: 1.15rem;"><i class="fas fa-bolt me-2"></i> Quick Actions (Aksi Cepat)</h5>
                <div class="row g-2">
                    @php
                        $quickActions = [
                            ['route' => 'pos.new', 'icon' => 'fas fa-cash-register', 'title' => 'POS Baru'],
                            ['route' => 'produk.index', 'icon' => 'fas fa-boxes', 'title' => 'Manajemen Produk'],
                            ['route' => 'kategori.index', 'icon' => 'fas fa-tags', 'title' => 'Manajemen Kategori'],
                            ['route' => 'member.index', 'icon' => 'fas fa-users', 'title' => 'Kelola Member'],
                            ['route' => '#', 'icon' => 'fas fa-search', 'title' => 'Cek Stok Cepat'],
                            ['route' => '#', 'icon' => 'fas fa-chart-bar', 'title' => 'Laporan Singkat'],
                        ];
                    @endphp
                    @foreach ($quickActions as $action)
                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <a href="{{ $action['route'] === '#' ? '#' : route($action['route']) }}" class="btn btn-primary-custom w-100 text-center d-block" style="padding: 10px 5px;">
                                <i class="{{ $action['icon'] }} fa-xl mb-1 d-block"></i>
                                <span style="font-size: 0.85em;">{{ $action['title'] }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row mb-4 g-3">
            <div class="col-md-3">
                <div class="card p-2 text-center h-100" style="border-top: 4px solid var(--color-success); background: var(--color-light);">
                    <div class="text-success mb-1"><i class="fas fa-shopping-cart fa-lg"></i></div>
                    <h6 class="card-title text-muted mb-0 small">PENJUALAN HARI INI</h6>
                    <h3 class="text-success mb-0 fw-bold" style="font-size: 1.4rem;">Rp 1.550.000</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-2 text-center h-100" style="border-top: 4px solid var(--color-primary); background: var(--color-light);">
                    <div class="text-theme-primary mb-1"><i class="fas fa-boxes fa-lg"></i></div>
                    <h6 class="card-title text-muted mb-0 small">TOTAL PRODUK</h6>
                    <h3 class="text-theme-primary mb-0 fw-bold" style="font-size: 1.4rem;">
                         @php $productCount = class_exists('App\Models\Product') ? \App\Models\Product::count() : 0; @endphp
                        {{ $productCount }}
                    </h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-2 text-center h-100" style="border-top: 4px solid var(--color-danger); background: var(--color-light);">
                    <div class="text-danger mb-1"><i class="fas fa-exclamation-triangle fa-lg"></i></div>
                    <h6 class="card-title text-muted mb-0 small">STOK MENIPIS</h6>
                     <h3 class="text-danger mb-0 fw-bold" style="font-size: 1.4rem;">
                        @php
                            $lowStockCount = 0;
                            if (class_exists('App\Models\Product')) {
                                $lowStockCount = \App\Models\Product::where('stok', '<=', \Illuminate\Support\Facades\DB::raw('stok_kritis'))->count();
                            }
                        @endphp
                        {{ $lowStockCount }}
                    </h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-2 text-center h-100" style="border-top: 4px solid var(--color-secondary); background: var(--color-light);">
                    <div class="text-secondary mb-1"><i class="fas fa-tags fa-lg"></i></div>
                    <h6 class="card-title text-muted mb-0 small">KATEGORI</h6>
                    <h3 class="text-secondary mb-0 fw-bold" style="font-size: 1.4rem;">
                        @php $categoryCount = class_exists('App\Models\Category') ? \App\Models\Category::count() : 0; @endphp
                        {{ $categoryCount }}
                    </h3>
                </div>
            </div>
        </div>


        <div class="row g-3">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-theme-light">
                        <h6 class="text-danger fw-bold mb-0" style="font-size: 1rem;"><i class="fas fa-exclamation-triangle me-2"></i> Stok Menipis</h6>
                    </div>
                    <div class="card-body p-3 small">
                        @if($lowStockCount > 0)
                            <div class="list-group list-group-flush">
                                @php
                                    $lowStockProducts = \App\Models\Product::where('stok', '<=', \Illuminate\Support\Facades\DB::raw('stok_kritis'))->orderBy('stok', 'asc')->take(5)->get();
                                @endphp
                                @foreach($lowStockProducts as $product)
                                    <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-1">
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

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-theme-light">
                        <h6 class="text-theme-primary fw-bold mb-0" style="font-size: 1rem;"><i class="fas fa-history me-2"></i> Aktivitas Terbaru</h6>
                    </div>
                    <div class="card-body p-3 small">
                        @php
                            $activities = [
                                ['title' => 'Transaksi #001', 'time' => '10:30', 'amount' => 'Rp 50.000', 'method' => 'Tunai'],
                                ['title' => 'Transaksi #002', 'time' => '10:25', 'amount' => 'Rp 120.000', 'method' => 'QRIS'],
                                ['title' => 'Transaksi #003', 'time' => '10:15', 'amount' => 'Rp 75.000', 'method' => 'Debit'],
                                ['title' => 'Transaksi #004', 'time' => '10:05', 'amount' => 'Rp 200.000', 'method' => 'Kredit'],
                            ];
                        @endphp
                        @foreach ($activities as $activity)
                        <div class="d-flex justify-content-between border-start border-theme-primary p-2 mb-2 bg-white rounded-sm">
                            <div>
                                <strong style="font-size: 0.9em;">{{ $activity['title'] }}</strong> <small class="text-muted">({{ $activity['method'] }})</small>
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
