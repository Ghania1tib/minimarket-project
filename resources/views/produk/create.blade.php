@extends('layouts.admin-base')

@section('title', 'Tambah Produk')

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
                                <i class="fas fa-plus me-2"></i>Tambah Produk Baru
                            </h2>
                            <p class="text-muted mb-0">Tambah data produk baru ke sistem</p>
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

    <!-- Form Tambah Produk -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_produk" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control search-box @error('nama_produk') is-invalid @enderror"
                                           id="nama_produk" name="nama_produk"
                                           value="{{ old('nama_produk') }}"
                                           placeholder="Masukkan nama produk" required>
                                    @error('nama_produk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select search-box @error('category_id') is-invalid @enderror"
                                            id="category_id" name="category_id" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                           value="{{ old('barcode') }}"
                                           placeholder="Masukkan barcode (opsional)">
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
                                      placeholder="Masukkan deskripsi produk (opsional)">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="harga_beli" class="form-label">Harga Beli <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control search-box @error('harga_beli') is-invalid @enderror"
                                           id="harga_beli" name="harga_beli"
                                           value="{{ old('harga_beli') }}" min="0" step="100" required>
                                    @error('harga_beli')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="harga_jual" class="form-label">Harga Jual <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control search-box @error('harga_jual') is-invalid @enderror"
                                           id="harga_jual" name="harga_jual"
                                           value="{{ old('harga_jual') }}" min="0" step="100" required>
                                    @error('harga_jual')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control search-box @error('stok') is-invalid @enderror"
                                           id="stok" name="stok"
                                           value="{{ old('stok', 0) }}" min="0" required>
                                    @error('stok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="stok_kritis" class="form-label">Stok Kritis <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control search-box @error('stok_kritis') is-invalid @enderror"
                                           id="stok_kritis" name="stok_kritis"
                                           value="{{ old('stok_kritis', 5) }}" min="0" required>
                                    @error('stok_kritis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mt-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle me-3 fs-5"></i>
                                <div>
                                    Pastikan harga jual lebih tinggi dari harga beli untuk mendapatkan keuntungan.
                                    Stok kritis akan memunculkan peringatan saat stok hampir habis.
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('produk.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Produk
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
.alert {
    border-radius: var(--border-radius-sm);
    border: none;
}

.alert-danger {
    background-color: rgba(224, 122, 95, 0.1);
    border-left: 4px solid var(--color-danger);
    color: #721c24;
}

.alert-success {
    background-color: rgba(112, 193, 179, 0.1);
    border-left: 4px solid var(--color-success);
    color: #0f5132;
}

.alert-info {
    background-color: rgba(91, 192, 222, 0.1);
    border-color: rgba(91, 192, 222, 0.2);
    color: #0c5460;
    border-radius: var(--border-radius-sm);
    border-left: 4px solid var(--color-info);
}

.alert-info i {
    color: var(--color-info);
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
}
</style>
@endsection
