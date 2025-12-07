@extends('layouts.admin-base')

@section('title', 'Edit Kategori')

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
                                <i class="fas fa-edit me-2"></i>Edit Kategori
                            </h2>
                            <p class="text-muted mb-0">Nama: <strong>{{ $kategori->nama_kategori }}</strong></p>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('kategori.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Edit Kategori -->
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control search-box @error('nama_kategori') is-invalid @enderror"
                                   id="nama_kategori" name="nama_kategori"
                                   value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                                   placeholder="Masukkan nama kategori" required>
                            <div class="form-text text-muted">Contoh: Makanan, Minuman, Snack, dll.</div>
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info mt-3">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-box me-2 text-primary"></i>
                                        <div>
                                            <strong>Jumlah Produk:</strong>
                                            <span class="badge badge-category rounded-pill ms-2">
                                                {{ $kategori->products->count() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Kategori
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

.badge-category {
    background-color: var(--color-accent) !important;
    color: #5E548E !important;
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
