@extends('layouts.app')

@section('title', 'Manajemen Produk')

@section('navbar')
    @include('layouts.partials.header')
    <nav class="navbar navbar-expand-lg fixed-top navbar-custom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard.staff') }}">
                <i class="fas fa-store me-2"></i>TOKO SAUDARA 2
            </a>

            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('dashboard.staff') }}" title="Dashboard Staff">
                    <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                </a>
                <a class="nav-link" href="{{ route('produk.index') }}" title="Kelola Produk">
                    <i class="fas fa-box me-1"></i>Produk
                </a>
                <a class="nav-link" href="{{ route('kategori.index') }}" title="Kelola Kategori">
                    <i class="fas fa-tags me-1"></i>Kategori
                </a>
                <a class="nav-link active" href="{{ route('member.index') }}" title="Kelola Member">
                    <i class="fas fa-users me-1"></i>Member
                </a>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" title="Menu Akun">
                        <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-edit me-2 text-theme-primary"></i>Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
@endsection
@section('content')
    <div class="content-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="text-theme-primary" style="font-size: 1.75rem;">
                <i class="fas fa-boxes me-2"></i> Manajemen Produk
            </h1>
            <a href="{{ route('produk.create') }}" class="btn btn-primary-custom btn-md">
                <i class="fas fa-plus me-2"></i>Tambah Produk
            </a>
        </div>
        <hr class="mt-0 mb-4">

        {{-- Search Form --}}
        <div class="card mb-4 bg-theme-light shadow-sm">
            <div class="card-body p-3">
                <form action="{{ route('produk.search') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-9">
                        <input type="text" name="keyword" class="form-control form-control-sm"
                               placeholder="Cari produk berdasarkan nama atau kategori..."
                               value="{{ request('keyword') }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary-custom w-100 btn-sm">
                            <i class="fas fa-search me-1"></i>Cari Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-3">
            @if($products->isEmpty())
                <div class="col-12 text-center py-5">
                    <i class="fas fa-box-open fa-4x text-secondary mb-3"></i>
                    <h4>Belum ada produk</h4>
                    <p class="text-muted">Mulai dengan menambahkan produk pertama Anda.</p>
                    <a href="{{ route('produk.create') }}" class="btn btn-primary-custom mt-2">
                        <i class="fas fa-plus me-2"></i>Tambah Produk Pertama
                    </a>
                </div>
            @else
                @foreach($products as $product)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        @php
                            $isLowStock = $product->stok <= $product->stok_kritis;
                        @endphp
                        <div class="card h-100 shadow-sm" style="border-top: 4px solid {{ $isLowStock ? 'var(--color-danger)' : 'var(--color-success)' }};">
                            @if($product->gambar_url)
                                <img src="{{ asset('storage/' . $product->gambar_url) }}"
                                     class="card-img-top"
                                     alt="{{ $product->nama_produk }}"
                                     style="height: 150px; object-fit: cover; border-radius: 12px 12px 0 0;">
                            @else
                                <div class="card-img-top bg-theme-light d-flex align-items-center justify-content-center"
                                     style="height: 150px; border-radius: 12px 12px 0 0;">
                                    <i class="fas fa-image fa-2x text-secondary"></i>
                                </div>
                            @endif
                            <div class="card-body p-3 d-flex flex-column">
                                <h6 class="card-title text-theme-primary fw-bold mb-1">
                                    {{ Str::limit($product->nama_produk, 30) }}
                                </h6>
                                <p class="card-text small mb-1">
                                    Kategori:
                                    <span class="badge bg-theme-accent text-dark">
                                        {{ $product->category->nama_kategori ?? '-' }}
                                    </span>
                                </p>
                                <p class="card-text mb-1 fw-bold" style="color: var(--color-danger);">
                                    Harga: Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                </p>
                                <span class="badge {{ $product->stok > 0 ? 'bg-success-custom' : 'bg-danger' }}">
                                    Stok: {{ $product->stok }}
                                </span>
                                @if($isLowStock)
                                    <span class="badge bg-warning text-dark mt-1">Stok Kritis!</span>
                                @endif

                                <div class="btn-group w-100 mt-3">
                                    <a href="{{ route('produk.edit', $product->id) }}"
                                       class="btn btn-primary-custom btn-sm flex-fill">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('produk.destroy', $product->id) }}" method="POST" class="d-inline flex-fill">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm w-100"
                                                onclick="return confirm('Hapus produk ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection

@push('styles')
<style>
    .btn-group {
        gap: 5px;
    }

    .btn-group .btn {
        flex: 1;
    }
</style>
@endpush
