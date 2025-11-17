@extends('layouts.pelanggan')

@section('title', 'Profil Saya')

@section('content')
<div class="card p-0">
    <div class="card-header bg-theme-accent">
        <h5 class="card-title mb-0 text-theme-primary fw-bold">
            <i class="fas fa-user-edit me-2"></i>Update Profil
        </h5>
    </div>
    <div class="card-body p-4">

        <form action="{{ route('pelanggan.profil.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-theme-primary small">Nama Lengkap</label>
                        <input type="text" class="form-control form-control-sm @error('nama_lengkap') is-invalid @enderror"
                               name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap ?? $user->name) }}"
                               placeholder="Masukkan nama lengkap" required>
                        @error('nama_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-theme-primary small">Email</label>
                        <input type="email" class="form-control form-control-sm" value="{{ $user->email }}" readonly>
                        <small class="text-muted small">Email tidak dapat diubah</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-theme-primary small">Nomor Telepon</label>
                        <input type="text" class="form-control form-control-sm @error('no_telepon') is-invalid @enderror"
                               name="no_telepon" value="{{ old('no_telepon', $user->no_telepon ?? $user->phone) }}"
                               placeholder="Contoh: 081234567890" required>
                        @error('no_telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-theme-primary small">Alamat</label>
                        <textarea class="form-control form-control-sm @error('alamat') is-invalid @enderror"
                                  name="alamat" rows="3" placeholder="Masukkan alamat lengkap" required>{{ old('alamat', $user->alamat ?? $user->address) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary-custom btn-md">
                    <i class="fas fa-save me-2"></i>Update Profil
                </button>
                <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-outline-secondary btn-md">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </form>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card bg-theme-light border-theme-primary shadow-sm">
                    <div class="card-body p-3">
                        <h6 class="card-title fw-bold text-theme-primary small mb-2">
                            <i class="fas fa-info-circle me-2"></i>Informasi Akun
                        </h6>
                        <div class="row small">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Tanggal Bergabung:</strong> {{ $user->created_at->format('d F Y') }}</p>
                                <p class="mb-1"><strong>Total Pesanan:</strong> {{ $totalOrders ?? 0 }} pesanan</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Status Akun:</strong>
                                    <span class="badge bg-success-custom">Aktif</span>
                                </p>
                                <p class="mb-0"><strong>Role:</strong>
                                    <span class="badge bg-primary-custom">Pelanggan</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
