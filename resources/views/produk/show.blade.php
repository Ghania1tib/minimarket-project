@extends('layouts.app')

@section('title', 'Detail Produk - Minimarket')

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
            <h1 class="text-theme-primary">
                <i class="fas fa-eye me-2"></i>Detail Produk
            </h1>
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
        <hr class="mt-0 mb-4">

        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0"><i class="fas fa-eye me-2"></i>Detail Produk</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @if($product->gambar_url)
                            <img src="{{ asset('storage/' . $product->gambar_url) }}"
                                 class="img-fluid rounded"
                                 alt="{{ $product->nama_produk }}"
                                 style="max-height: 300px; object-fit: cover;">
                        @else
                            <div class="bg-theme-light d-flex align-items-center justify-content-center rounded"
                                 style="height: 300px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h3>{{ $product->nama_produk }}</h3>
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Kategori</th>
                                <td>{{ $product->category->nama_kategori ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Barcode</th>
                                <td>{{ $product->barcode ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Harga Beli</th>
                                <td class="text-danger">{{ 'Rp ' . number_format($product->harga_beli, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Harga Jual</th>
                                <td class="text-success">{{ 'Rp ' . number_format($product->harga_jual, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td>
                                    <span class="badge {{ $product->stok > 0 ? 'bg-success-custom' : 'bg-danger' }}">
                                        {{ $product->stok }}
                                    </span>
                                    @if($product->stok <= $product->stok_kritis)
                                        <span class="badge bg-warning text-dark">Stok Kritis!</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Stok Kritis</th>
                                <td>{{ $product->stok_kritis }}</td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $product->deskripsi ?? '-' }}</td>
                            </tr>
                        </table>

                        <div class="d-flex gap-2">
                            <a href="{{ route('produk.edit', $product->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <form action="{{ route('produk.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus produk ini?')">
                                    <i class="fas fa-trash me-2"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
