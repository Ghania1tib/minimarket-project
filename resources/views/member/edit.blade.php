@extends('layouts.admin-base')

@section('title', 'Edit Member')

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
                                <i class="fas fa-edit me-2"></i>Edit Member
                            </h2>
                            <p class="text-muted mb-0">Kode: <strong>{{ $member->kode_member }}</strong></p>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('member.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Edit Member -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('member.update', $member->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kode_member" class="form-label">Kode Member</label>
                                    <input type="text" class="form-control search-box @error('kode_member') is-invalid @enderror"
                                           id="kode_member" name="kode_member"
                                           value="{{ old('kode_member', $member->kode_member) }}"
                                           required>
                                    @error('kode_member')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_daftar" class="form-label">Tanggal Daftar</label>
                                    <input type="date" class="form-control search-box @error('tanggal_daftar') is-invalid @enderror"
                                           id="tanggal_daftar" name="tanggal_daftar"
                                           value="{{ old('tanggal_daftar', $member->tanggal_daftar->format('Y-m-d')) }}" required>
                                    @error('tanggal_daftar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control search-box @error('nama_lengkap') is-invalid @enderror"
                                           id="nama_lengkap" name="nama_lengkap"
                                           value="{{ old('nama_lengkap', $member->nama_lengkap) }}"
                                           placeholder="Masukkan nama lengkap member" required>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control search-box @error('nomor_telepon') is-invalid @enderror"
                                           id="nomor_telepon" name="nomor_telepon"
                                           value="{{ old('nomor_telepon', $member->nomor_telepon) }}"
                                           placeholder="Contoh: 081234567890" required>
                                    @error('nomor_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mt-3">
                            <div class="row">
                                <div class="col-md-6 mb-2 mb-md-0">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-star me-2 text-success"></i>
                                        <div>
                                            <strong>Poin Saat Ini:</strong>
                                            <span class="badge badge-poin rounded-pill ms-2">
                                                {{ $member->poin_formatted }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-shopping-cart me-2 text-info"></i>
                                        <div>
                                            <strong>Total Transaksi:</strong>
                                            <span class="badge badge-transaction rounded-pill ms-2">
                                                {{ $member->orders->count() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('member.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Member
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

.badge-poin {
    background-color: var(--color-success) !important;
    color: white !important;
}

.badge-transaction {
    background-color: var(--color-info) !important;
    color: white !important;
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
