@extends('layouts.admin-base')

@section('title', 'Dashboard Admin - Minimarket')

@section('content')
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="text-primary mb-2" style="color: var(--color-primary) !important;">
                                Selamat Datang, {{ Auth::user()->nama_lengkap }}!
                            </h3>
                            <p class="text-muted mb-0">
                                Berikut adalah ringkasan aktivitas dan statistik toko Anda hari ini.
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="d-flex flex-column align-items-end">
                                <div class="text-muted mb-1">
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
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4 justify-content-center">
        <!-- Card Menunggu Verifikasi -->
        <div class="col-xl-2 col-md-4 mb-3">
            <div class="card stats-card stats-warning h-100">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-muted mb-2">MENUNGGU VERIFIKASI</h6>
                            <h3 class="mb-1" style="color: #ffc107 !important;">
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
                            <small class="text-muted">Pembayaran Online</small>
                        </div>
                        <div class="align-self-center ms-2">
                            <i class="fas fa-clock fa-2x opacity-25"></i>
                        </div>
                    </div>
                    @if ($pendingVerification > 0)
                        <div class="mt-3">
                            <a href="{{ route('payment.verification.index') }}" class="btn btn-warning btn-sm w-100">
                                <i class="fas fa-check-circle me-1"></i>Verifikasi Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-3">
            <div class="card stats-card stats-products h-100">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
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
                        <div class="align-self-center ms-2">
                            <i class="fas fa-boxes fa-2x opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-3">
            <div class="card stats-card stats-lowstock h-100">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-muted mb-2">STOK MENIPIS</h6>
                            <h3 class="mb-1" style="color: var(--color-danger) !important;">
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
                            <small class="text-muted">Perlu restock</small>
                        </div>
                        <div class="align-self-center ms-2">
                            <i class="fas fa-exclamation-triangle fa-2x opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-3">
            <div class="card stats-card stats-categories h-100">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-muted mb-2">KATEGORI</h6>
                            <h3 class="text-secondary mb-0 fw-bold">
                                @php $categoryCount = class_exists('App\Models\Category') ? \App\Models\Category::count() : 5; @endphp
                                {{ $categoryCount }}
                            </h3>
                            <small class="text-muted">Kategori produk</small>
                        </div>
                        <div class="align-self-center ms-2">
                            <i class="fas fa-tags fa-2x opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-3">
            <div class="card stats-card stats-users h-100">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
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
                        <div class="align-self-center ms-2">
                            <i class="fas fa-users fa-2x opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="row mb-4">
        <!-- Aksi Cepat -->
        <div class="col-lg-8 mb-4">
            <div class="card management-card h-100">
                <div class="card-body p-4">
                    <h5 class="section-title mb-4">
                        <i class="fas fa-database me-2"></i>Aksi Cepat
                    </h5>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <a href="{{ route('kategori.index') }}" class="quick-action-btn text-center d-block p-4">
                                <i class="fas fa-tags fa-3x mb-3 d-block"></i>
                                <h6 class="mb-2">Kategori</h6>
                                <small class="d-block opacity-75">Kelola Kategori</small>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('payment.verification.orders.index') }}"
                               class="quick-action-btn text-center d-block p-4 position-relative">
                                <i class="fas fa-clipboard-list fa-3x mb-3 d-block"></i>
                                <h6 class="mb-2">Manajemen Pesanan</h6>
                                <small class="d-block opacity-75">Kelola Pesanan</small>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('payment.verification.index') }}"
                               class="quick-action-btn text-center d-block p-4 position-relative">
                                <i class="fas fa-check-circle fa-3x mb-3 d-block"></i>
                                <h6 class="mb-2">Verifikasi Pembayaran</h6>
                                <small class="d-block opacity-75">Verifikasi Online</small>
                                @php
                                    $pendingVerification = \App\Models\Order::where(
                                        'status_pembayaran',
                                        'menunggu_verifikasi',
                                    )
                                        ->where('tipe_pesanan', 'website')
                                        ->count();
                                @endphp
                                @if ($pendingVerification > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning py-2 px-3">
                                        {{ $pendingVerification }}
                                    </span>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body p-4">
                    <h5 class="section-title mb-4">
                        <i class="fas fa-history me-2"></i>Aktivitas Terbaru
                    </h5>

                    @if(isset($recentActivities) && $recentActivities->count() > 0)
                        <div class="activity-container">
                            @foreach($recentActivities as $activity)
                                <div class="activity-item mb-3 pb-3 border-bottom">
                                    <div class="d-flex w-100 justify-content-between align-items-start mb-1">
                                        <strong class="text-dark">{{ $activity['title'] }}</strong>
                                        <small class="text-muted">{{ $activity['time']->format('H:i') }}</small>
                                    </div>
                                    <p class="mb-1 text-{{ $activity['color'] }} small">{{ $activity['description'] }}</p>
                                    <small class="text-muted">
                                        @if($activity['user'])
                                            <i class="fas fa-user me-1"></i>{{ $activity['user'] }}
                                        @else
                                            <i class="fas fa-robot me-1"></i>Sistem
                                        @endif
                                    </small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state text-center py-5">
                            <i class="fas fa-history fa-3x mb-3 text-muted opacity-50"></i>
                            <p class="mb-0 text-muted">Belum ada aktivitas terbaru</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock and Popular Products -->
    <div class="row mt-2">
        <!-- Produk Stok Menipis -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-body p-4">
                    <h5 class="section-title mb-4">
                        <i class="fas fa-exclamation-triangle me-2"></i>Produk Stok Menipis
                    </h5>

                    @php
                        $lowStockProducts = [];
                        if (class_exists('App\Models\Product')) {
                            $lowStockProducts = \App\Models\Product::where(
                                'stok',
                                '<=',
                                \Illuminate\Support\Facades\DB::raw('stok_kritis'),
                            )
                                ->orderBy('stok', 'asc')
                                ->take(5)
                                ->get();
                        }
                    @endphp

                    @if (count($lowStockProducts) > 0)
                        <div class="list-group list-group-flush">
                            @foreach ($lowStockProducts as $product)
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-3">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 text-dark">{{ $product->nama_produk }}</h6>
                                        <small class="text-muted">
                                            Stok: <span class="fw-bold">{{ $product->stok }}</span> |
                                            Minimal: <span class="fw-bold">{{ $product->stok_kritis }}</span>
                                        </small>
                                    </div>
                                    <span class="badge bg-danger rounded-pill px-3 py-2">{{ $product->stok }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('produk.index') }}" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-list me-1"></i>Lihat Semua
                            </a>
                        </div>
                    @else
                        <div class="empty-state text-center py-5">
                            <i class="fas fa-check-circle fa-3x mb-3 text-success opacity-50"></i>
                            <p class="mb-0 text-muted">Tidak ada produk dengan stok menipis.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
@endsection

<style>
    /* Semua style CSS dari dashboard asli ditempatkan di sini */
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

    .stats-sales {
        border-top-color: var(--color-success);
        color: var(--color-success);
    }

    .stats-products {
        border-top-color: var(--color-secondary);
        color: var(--color-secondary);
    }

    .stats-lowstock {
        border-top-color: var(--color-danger);
        color: var(--color-danger);
    }

    .stats-categories {
        border-top-color: var(--color-primary);
        color: var(--color-primary);
    }

    .stats-users {
        border-top-color: #6f42c1;
        color: #6f42c1;
    }

    .stats-revenue {
        border-top-color: var(--color-success);
        color: var(--color-success);
    }

    .stats-warning {
        border-top-color: #ffc107;
        color: #ffc107;
    }

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
        color: #6c757d;
    }

    .empty-state i {
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

    /* Perbaikan layout dan spacing */
    .card-body {
        padding: 1.5rem;
    }

    .list-group-item {
        padding: 1rem 0;
    }

    .activity-container {
        max-height: 300px;
        overflow-y: auto;
        padding-right: 10px;
    }

    .activity-container::-webkit-scrollbar {
        width: 6px;
    }

    .activity-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .activity-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }

    .text-dark {
        color: #343a40 !important;
    }

    .border-bottom {
        border-bottom: 1px solid #e9ecef !important;
    }

    .opacity-50 {
        opacity: 0.5;
    }

    .opacity-75 {
        opacity: 0.75;
    }
</style>
