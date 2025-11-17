@extends('layouts.app')

@section('title', 'Tambah Member')

@section('navbar')
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
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-theme-accent">
                    <h4 class="mb-0 text-theme-primary"><i class="fas fa-user-plus me-2"></i>Tambah Member Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('member.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="kode_member" class="form-label">Kode Member</label>
                            <input type="text" class="form-control kode-member @error('kode_member') is-invalid @enderror"
                                   id="kode_member" name="kode_member"
                                   value="{{ old('kode_member', $kodeMember) }}"
                                   readonly required>
                            <div class="form-text text-muted">Kode member digenerate otomatis.</div>
                            @error('kode_member')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                   id="nama_lengkap" name="nama_lengkap"
                                   value="{{ old('nama_lengkap') }}"
                                   placeholder="Masukkan nama lengkap member" required>
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror"
                                   id="nomor_telepon" name="nomor_telepon"
                                   value="{{ old('nomor_telepon') }}"
                                   placeholder="Contoh: 081234567890" required>
                            @error('nomor_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_daftar" class="form-label">Tanggal Daftar</label>
                            <input type="date" class="form-control @error('tanggal_daftar') is-invalid @enderror"
                                   id="tanggal_daftar" name="tanggal_daftar"
                                   value="{{ old('tanggal_daftar', date('Y-m-d')) }}" required>
                            @error('tanggal_daftar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Member baru akan mendapatkan <strong>0 poin</strong> secara default.
                            Poin akan bertambah saat member melakukan transaksi.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('member.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="fas fa-save me-2"></i>Simpan Member
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
