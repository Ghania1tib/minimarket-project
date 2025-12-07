@extends('layouts.admin-base')

@section('title', 'Edit Produk')

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
                                <i class="fas fa-edit me-2"></i>Edit Produk
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

    <!-- Form Edit Produk -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('produk.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_produk" class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control search-box @error('nama_produk') is-invalid @enderror"
                                           id="nama_produk" name="nama_produk"
                                           value="{{ old('nama_produk', $product->nama_produk) }}"
                                           placeholder="Masukkan nama produk" required>
                                    @error('nama_produk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Kategori</label>
                                    <select class="form-select search-box @error('category_id') is-invalid @enderror"
                                            id="category_id" name="category_id" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                                                {{ $category->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="barcode" class="form-label">Barcode</label>
                                    <input type="text" class="form-control search-box @error('barcode') is-invalid @enderror"
                                           id="barcode" name="barcode"
                                           value="{{ old('barcode', $product->barcode) }}"
                                           placeholder="Masukkan barcode (opsional)">
                                    <div class="form-text text-muted">Kosongkan untuk generate otomatis.</div>
                                    @error('barcode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gambar" class="form-label">Gambar Produk</label>
                                    <input type="file" class="form-control search-box @error('gambar') is-invalid @enderror"
                                           id="gambar" name="gambar" accept="image/*">
                                    <div class="form-text text-muted">Format: JPEG, PNG, JPG, GIF. Maksimal: 2MB</div>
                                    @if($product->gambar_url)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $product->gambar_url) }}"
                                                 alt="{{ $product->nama_produk }}"
                                                 class="img-thumbnail"
                                                 style="max-height: 100px;">
                                            <small class="text-muted d-block">Gambar saat ini</small>
                                        </div>
                                    @endif
                                    @error('gambar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control search-box @error('deskripsi') is-invalid @enderror"
                                      id="deskripsi" name="deskripsi" rows="3"
                                      placeholder="Masukkan deskripsi produk (opsional)">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="harga_beli" class="form-label">Harga Beli</label>
                                    <input type="number" class="form-control search-box @error('harga_beli') is-invalid @enderror"
                                           id="harga_beli" name="harga_beli"
                                           value="{{ old('harga_beli', $product->harga_beli) }}"
                                           min="0" step="100" required>
                                    @error('harga_beli')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="harga_jual" class="form-label">Harga Jual</label>
                                    <input type="number" class="form-control search-box @error('harga_jual') is-invalid @enderror"
                                           id="harga_jual" name="harga_jual"
                                           value="{{ old('harga_jual', $product->harga_jual) }}"
                                           min="0" step="100" required>
                                    @error('harga_jual')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="stok" class="form-label">Stok</label>
                                    <input type="number" class="form-control search-box @error('stok') is-invalid @enderror"
                                           id="stok" name="stok"
                                           value="{{ old('stok', $product->stok) }}"
                                           min="0" required>
                                    @error('stok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="stok_kritis" class="form-label">Stok Kritis</label>
                                    <input type="number" class="form-control search-box @error('stok_kritis') is-invalid @enderror"
                                           id="stok_kritis" name="stok_kritis"
                                           value="{{ old('stok_kritis', $product->stok_kritis) }}"
                                           min="0" required>
                                    @error('stok_kritis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mt-3">
                            <div class="row">
                                <div class="col-md-6 mb-2 mb-md-0">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-box me-2 text-primary"></i>
                                        <div>
                                            <strong>Stok Saat Ini:</strong>
                                            <span class="badge {{ $product->stok > 0 ? ($product->stok <= $product->stok_kritis ? 'bg-warning' : 'bg-success') : 'bg-danger' }} rounded-pill ms-2">
                                                {{ $product->stok }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-money-bill-wave me-2 text-success"></i>
                                        <div>
                                            <strong>Harga Jual:</strong>
                                            <span class="badge bg-success rounded-pill ms-2">
                                                {{ 'Rp ' . number_format($product->harga_jual, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('produk.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Produk
                            </button>
                        </div>
                    </form>
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

/* Button Styling */
.btn-primary, .btn-success, .btn-danger, .btn-warning, .btn-outline-primary, .btn-secondary {
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

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #545b62;
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

/* Form Styling */
.form-label {
    color: var(--color-primary);
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.search-box {
    border-radius: var(--border-radius-sm);
    border: 2px solid var(--color-accent);
    padding: 10px 15px;
    transition: all 0.3s ease;
}

.search-box:focus {
    border-color: var(--color-primary);
    box-shadow: 0 0 0 0.2rem rgba(224, 177, 203, 0.25);
}

.form-text {
    font-size: 0.85rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

.invalid-feedback {
    font-size: 0.85rem;
    color: var(--color-danger);
}

.form-select {
    border-radius: var(--border-radius-sm);
    border: 2px solid var(--color-accent);
    padding: 10px 15px;
    transition: all 0.3s ease;
}

.form-select:focus {
    border-color: var(--color-primary);
    box-shadow: 0 0 0 0.2rem rgba(224, 177, 203, 0.25);
}

/* Alert Styling */
.alert-info {
    background-color: rgba(91, 192, 222, 0.1);
    border-color: rgba(91, 192, 222, 0.2);
    color: #0c5460;
    border-radius: var(--border-radius-sm);
    border-left: 4px solid var(--color-info);
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

/* Image Thumbnail */
.img-thumbnail {
    border-radius: var(--border-radius-sm);
    border: 2px solid var(--color-accent);
    padding: 5px;
    background-color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 10px;
    }

    .d-flex.justify-content-between .btn {
        width: 100%;
    }

    .alert-info .row {
        flex-direction: column;
        gap: 10px;
    }
}
</style>
@endsection
