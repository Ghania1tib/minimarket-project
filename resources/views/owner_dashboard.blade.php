@extends('layouts.app')

@section('title', 'Dashboard Admin/Owner')

@section('navbar')
    {{-- Navbar Khusus Admin/Owner menggunakan CSS dari app.blade.php --}}
    <nav class="navbar navbar-expand-lg fixed-top navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('owner.dashboard') }}">
                <i class="fas fa-chart-line me-2"></i>Dashboard **ADMIN/OWNER**
            </a>
            <div class="navbar-nav ms-auto d-flex align-items-center">
                <span class="nav-link text-theme-primary me-3 d-none d-md-block small">
                    Halo, <strong>{{ Auth::user()->nama_lengkap }} ({{ Auth::user()->role }})</strong>
                </span>
                <a class="btn btn-outline-dark btn-sm me-2" style="border-color: var(--color-primary); color: var(--color-primary);" href="{{ route('home') }}">
                    <i class="fas fa-home"></i> Landing Page
                </a>
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

        <h1 class="mb-3 text-theme-primary"><i class="fas fa-tachometer-alt me-2"></i> Dashboard Admin/Owner</h1>
        <hr class="mb-4">

        <h3 class="mb-3 text-theme-primary fw-bold" style="font-size: 1.4rem;"><i class="fas fa-database me-2"></i> Manajemen Data Master</h3>
        <div class="row g-3">
            @php
                $masterDataLinks = [
                    ['route' => 'produk.index', 'icon' => 'fas fa-boxes', 'title' => 'Produk (CRUD)', 'color' => 'var(--color-primary)'],
                    ['route' => 'kategori.index', 'icon' => 'fas fa-tags', 'title' => 'Kategori (CRUD)', 'color' => 'var(--color-secondary)'],
                    ['route' => 'user.index', 'icon' => 'fas fa-users-cog', 'title' => 'Akun Pengguna (CRUD)', 'color' => 'var(--color-success)'],
                    ['route' => 'promo.index', 'icon' => 'fas fa-percent', 'title' => 'Promo (CRUD)', 'color' => 'var(--color-danger)'],
                ];
            @endphp

            @foreach ($masterDataLinks as $link)
            <div class="col-xl-3 col-md-6">
                <a href="{{ route($link['route']) }}" class="text-decoration-none">
                    <div class="card text-center p-3 h-100 bg-theme-light" style="border-top: 4px solid {{ $link['color'] }};">
                        <i class="{{ $link['icon'] }} fa-2x mb-2" style="color: {{ $link['color'] }};"></i>
                        <h5 class="card-title text-dark fw-bold" style="font-size: 1.1rem;">{{ $link['title'] }}</h5>
                        <p class="small text-muted mb-0">Kelola data toko</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <h3 class="mt-4 mb-3 text-secondary text-theme-primary fw-bold" style="font-size: 1.4rem;"><i class="fas fa-chart-pie me-2"></i> Laporan & Analisis</h3>
        <div class="row g-3">
            <div class="col-xl-3 col-md-6">
                <a href="#" class="text-decoration-none">
                    <div class="card text-center p-3 h-100 bg-theme-light" style="border-top: 4px solid var(--color-danger);">
                        <i class="fas fa-file-invoice-dollar fa-2x mb-2" style="color: var(--color-danger);"></i>
                        <h5 class="card-title text-dark fw-bold" style="font-size: 1.1rem;">Laporan Penjualan (R)</h5>
                        <p class="small text-muted mb-0">Total pendapatan & transaksi</p>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-md-6">
                 <a href="#" class="text-decoration-none">
                    <div class="card text-center p-3 h-100 bg-theme-light" style="border-top: 4px solid var(--color-secondary);">
                        <i class="fas fa-history fa-2x mb-2" style="color: var(--color-secondary);"></i>
                        <h5 class="card-title text-dark fw-bold" style="font-size: 1.1rem;">Riwayat Stok (R)</h5>
                        <p class="small text-muted mb-0">Lacak perubahan stok</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
