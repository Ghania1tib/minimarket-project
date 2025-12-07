@extends('layouts.admin-base')

@section('title', 'Detail Produk')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="section-title mb-0">
                                <i class="fas fa-box me-2"></i>Detail Produk
                            </h2>
                            <p class="text-muted mb-0">Nama: <strong>{{ $product->nama_produk }}</strong></p>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('produk.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Informasi Produk -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-info-circle me-2"></i>Informasi Produk
                    </h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-section">
                                <h6 class="info-title">Data Produk</h6>
                                <div class="info-item">
                                    <span class="info-label">Nama Produk</span>
                                    <span class="info-value text-primary fw-bold">{{ $product->nama_produk }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Kategori</span>
                                    <span class="info-value">
                                        <span class="badge badge-category rounded-pill">
                                            {{ $product->kategori->nama_kategori ?? '-'}}
                                        </span>
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Barcode</span>
                                    <span class="info-value">{{ $product->barcode ?? '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Deskripsi</span>
                                    <span class="info-value">{{ $product->deskripsi ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-section">
                                <h6 class="info-title">Harga dan Stok</h6>
                                <div class="info-item">
                                    <span class="info-label">Harga Beli</span>
                                    <span class="info-value text-danger fw-bold">
                                        {{ 'Rp ' . number_format($product->harga_beli, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Harga Jual</span>
                                    <span class="info-value text-success fw-bold">
                                        {{ 'Rp ' . number_format($product->harga_jual, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Stok</span>
                                    <span class="info-value">
                                        <span class="badge {{ $product->stok > 0 ? ($product->stok <= $product->stok_kritis ? 'bg-warning' : 'bg-success') : 'bg-danger' }} rounded-pill">
                                            {{ $product->stok }}
                                            @if($product->stok <= $product->stok_kritis && $product->stok > 0)
                                                <i class="fas fa-exclamation-triangle ms-1"></i>
                                            @endif
                                        </span>
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Stok Kritis</span>
                                    <span class="info-value">{{ $product->stok_kritis }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aksi -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-cogs me-2"></i>Aksi
                    </h5>

                    <div class="d-grid gap-2">
                        <a href="{{ route('produk.edit', $product->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Produk
                        </a>
                        <form action="{{ route('produk.destroy', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100"
                                    onclick="return confirm('Hapus produk {{ $product->nama_produk }}?')">
                                <i class="fas fa-trash me-2"></i>Hapus Produk
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Gambar Produk -->
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-image me-2"></i>Gambar Produk
                    </h5>

                    @if($product->gambar_url)
                        <img src="{{ asset('storage/' . $product->gambar_url) }}"
                             class="img-fluid rounded mb-3"
                             alt="{{ $product->nama_produk }}"
                             style="max-height: 250px; object-fit: contain;">
                    @else
                        <div class="bg-theme-light d-flex align-items-center justify-content-center rounded mb-3"
                             style="height: 250px;">
                            <i class="fas fa-image fa-4x text-muted"></i>
                        </div>
                        <p class="text-muted">Tidak ada gambar</p>
                    @endif
                </div>
            </div>

            <!-- Statistik Ringkas -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-chart-bar me-2"></i>Statistik Produk
                    </h5>

                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="stat-card bg-light p-3 rounded">
                                <div class="stat-icon text-primary mb-2">
                                    <i class="fas fa-money-bill-wave fa-2x"></i>
                                </div>
                                <h6 class="text-primary">Harga Jual</h6>
                                <div class="text-success fw-bold">
                                    {{ 'Rp ' . number_format($product->harga_jual, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="stat-card bg-light p-3 rounded">
                                <div class="stat-icon text-danger mb-2">
                                    <i class="fas fa-money-bill fa-2x"></i>
                                </div>
                                <h6 class="text-danger">Harga Beli</h6>
                                <div class="text-danger fw-bold">
                                    {{ 'Rp ' . number_format($product->harga_beli, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="stat-card bg-light p-3 rounded">
                                <div class="stat-icon {{ $product->stok > 0 ? ($product->stok <= $product->stok_kritis ? 'text-warning' : 'text-success') : 'text-danger' }} mb-2">
                                    <i class="fas fa-boxes fa-2x"></i>
                                </div>
                                <h6>Stok Tersedia</h6>
                                <div class="fw-bold">
                                    {{ $product->stok }} unit
                                    @if($product->stok <= $product->stok_kritis && $product->stok > 0)
                                        <span class="badge bg-warning text-dark ms-1">Kritis</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Variabel CSS konsisten */
:root {
    --color-primary: #5E548E;
    --color-secondary: #9F86C0;
    --color-accent: #E0B1CB;
    --color-danger: #E07A5F;
    --color-success: #70C1B3;
    --color-warning: #FFB347;
    --color-info: #5BC0DE;
    --color-light: #F0E6EF;
    --color-white: #ffffff;
    --border-radius-lg: 15px;
    --border-radius-sm: 8px;
}

body {
    background: linear-gradient(135deg, #F0E6EF 0%, #D891EF 100%);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    min-height: 100vh;
}

/* Card Styling */
.card {
    border-radius: var(--border-radius-lg);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    border: none;
    background: var(--color-white);
    margin-bottom: 1.5rem;
}

.card-body {
    padding: 1.5rem;
}

/* Section Title */
.section-title {
    color: var(--color-primary);
    font-weight: 700;
    margin-bottom: 0.5rem;
    border-left: 4px solid var(--color-accent);
    padding-left: 15px;
}

/* Card Title */
.card-title {
    color: var(--color-primary);
    font-weight: 600;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
}

/* Button Styling */
.btn-primary, .btn-success, .btn-danger, .btn-warning, .btn-outline-primary {
    border-radius: var(--border-radius-sm);
    padding: 10px 20px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: var(--color-primary);
    border-color: var(--color-primary);
}

.btn-primary:hover {
    background-color: var(--color-secondary);
    border-color: var(--color-secondary);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(94, 84, 142, 0.3);
}

.btn-warning {
    background-color: var(--color-warning);
    border-color: var(--color-warning);
    color: #000;
}

.btn-warning:hover {
    background-color: #FFA133;
    border-color: #FFA133;
    transform: translateY(-2px);
}

.btn-danger {
    background-color: var(--color-danger);
    border-color: var(--color-danger);
}

.btn-danger:hover {
    background-color: #D7694E;
    border-color: #D7694E;
    transform: translateY(-2px);
}

.btn-outline-primary {
    border: 2px solid var(--color-primary);
    color: var(--color-primary);
}

.btn-outline-primary:hover {
    background: var(--color-primary);
    color: white;
    transform: translateY(-2px);
}

/* Badge Styling */
.badge {
    font-weight: 500;
    letter-spacing: 0.3px;
    padding: 6px 12px !important;
    font-size: 0.85rem !important;
}

.rounded-pill {
    border-radius: 50px !important;
}

.badge-category {
    background-color: var(--color-accent) !important;
    color: #5E548E !important;
}

/* Info Section Styling */
.info-section {
    background: #f8f9fa;
    border-radius: var(--border-radius-sm);
    padding: 1.25rem;
    margin-bottom: 1rem;
}

.info-title {
    color: var(--color-primary);
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--color-accent);
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    color: #6c757d;
    font-weight: 500;
    font-size: 0.9rem;
}

.info-value {
    color: var(--color-primary);
    font-weight: 600;
    text-align: right;
    max-width: 60%;
}

/* Stat Card */
.stat-card {
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.stat-icon {
    transition: all 0.3s ease;
}

/* Grid Gap */
.d-grid.gap-2 {
    gap: 10px !important;
}

/* Responsive */
@media (max-width: 768px) {
    .btn-outline-primary {
        width: 100%;
        margin-bottom: 0.5rem;
    }

    .info-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .info-value {
        text-align: left;
        max-width: 100%;
        margin-top: 5px;
    }

    .stat-card {
        margin-bottom: 1rem;
    }
}
</style>
@endsection
