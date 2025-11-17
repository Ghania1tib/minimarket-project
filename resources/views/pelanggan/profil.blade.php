@extends('layouts.pelanggan')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>Profil Saya
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('pelanggan.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                           name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap ?? $user->name) }}"
                                           placeholder="Masukkan nama lengkap" required>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                                    <small class="text-muted">Email tidak dapat diubah</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nomor Telepon</label>
                                    <input type="text" class="form-control @error('no_telepon') is-invalid @enderror"
                                           name="no_telepon" value="{{ old('no_telepon', $user->no_telepon ?? $user->phone) }}"
                                           placeholder="Contoh: 081234567890" required>
                                    @error('no_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Alamat</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror"
                                              name="alamat" rows="4" placeholder="Masukkan alamat lengkap" required>{{ old('alamat', $user->alamat ?? $user->address) }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Profil
                            </button>
                            <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                            </a>
                        </div>
                    </form>

                    <!-- Informasi Akun -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold text-primary">
                                        <i class="fas fa-info-circle me-2"></i>Informasi Akun
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Tanggal Bergabung:</strong> {{ $user->created_at->format('d F Y') }}</p>
                                            <p class="mb-2"><strong>Total Pesanan:</strong> {{ $totalOrders }} pesanan</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Status Akun:</strong>
                                                <span class="badge bg-success">Aktif</span>
                                            </p>
                                            <p class="mb-0"><strong>Role:</strong>
                                                <span class="badge bg-primary">Pelanggan</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
