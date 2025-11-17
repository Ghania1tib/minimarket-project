@extends('layouts.app')

@section('title', 'Detail Member')

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
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-theme-accent">
                    <h4 class="mb-0 text-theme-primary"><i class="fas fa-user me-2"></i>Detail Member</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Kode Member</th>
                            <td class="text-primary fw-bold">{{ $member->kode_member }}</td>
                        </tr>
                        <tr>
                            <th>Nama Lengkap</th>
                            <td>{{ $member->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <th>Nomor Telepon</th>
                            <td>{{ $member->nomor_telepon }}</td>
                        </tr>
                        <tr>
                            <th>Poin</th>
                            <td>
                                <span class="badge bg-success">
                                    <i class="fas fa-star me-1"></i>{{ $member->poin_formatted }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Daftar</th>
                            <td>{{ $member->tanggal_daftar->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Total Transaksi</th>
                            <td>
                                <span class="badge bg-primary">{{ $member->orders->count() }}</span>
                            </td>
                        </tr>
                    </table>

                    <div class="d-grid gap-2">
                        <a href="{{ route('member.edit', $member->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Member
                        </a>
                        <form action="{{ route('member.destroy', $member->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100"
                                    onclick="return confirm('Hapus member {{ $member->nama_lengkap }}?')">
                                <i class="fas fa-trash me-2"></i>Hapus Member
                            </button>
                        </form>
                        <a href="{{ route('member.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik Member</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h3 class="text-primary">{{ $member->poin }}</h3>
                                    <small class="text-muted">Total Poin</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h3 class="text-success">{{ $member->orders->count() }}</h3>
                                    <small class="text-muted">Total Transaksi</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6 class="text-theme-primary"><i class="fas fa-history me-2"></i>Riwayat Poin</h6>
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <small>Poin Awal</small>
                                    <small>{{ $member->tanggal_daftar->format('d M Y') }}</small>
                                </div>
                                <p class="mb-1">0 poin</p>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <small>Poin Saat Ini</small>
                                    <small>Hari ini</small>
                                </div>
                                <p class="mb-1 text-success">{{ $member->poin }} poin</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
