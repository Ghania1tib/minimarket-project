@extends('layouts.app')

@section('title', 'Manajemen Member')

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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-theme-primary"><i class="fas fa-users me-2"></i>Manajemen Member</h1>
        <a href="{{ route('member.create') }}" class="btn btn-primary-custom">
            <i class="fas fa-plus me-2"></i>Tambah Member
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search Form -->
    <div class="card mb-4">
        <div class="card-header bg-theme-accent">
            <h5 class="mb-0 text-theme-primary"><i class="fas fa-search me-2"></i>Cari Member</h5>
        </div>
        <div class="card-body">
            <form action="#" method="GET" class="row g-3">
                <div class="col-md-8">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari member berdasarkan nama, kode, atau telepon..." value="{{ request('keyword') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        @foreach($members as $member)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-theme-accent">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 text-theme-primary">{{ $member->nama_lengkap }}</h6>
                            <span class="badge bg-success">
                                <i class="fas fa-star me-1"></i>{{ $member->poin_formatted }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted"><i class="fas fa-id-card me-2"></i>Kode:</small>
                            <p class="mb-1 fw-bold text-primary">{{ $member->kode_member }}</p>

                            <small class="text-muted"><i class="fas fa-phone me-2"></i>Telepon:</small>
                            <p class="mb-1">{{ $member->nomor_telepon }}</p>

                            <small class="text-muted"><i class="fas fa-calendar me-2"></i>Tanggal Daftar:</small>
                            <p class="mb-1">{{ $member->tanggal_daftar->format('d M Y') }}</p>

                            <small class="text-muted"><i class="fas fa-shopping-cart me-2"></i>Total Transaksi:</small>
                            <p class="mb-0">{{ $member->orders->count() }}</p>
                        </div>

                        <div class="btn-group w-100">
                            <a href="{{ route('member.show', $member->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('member.edit', $member->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('member.destroy', $member->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus member {{ $member->nama_lengkap }}?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($members->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-users fa-4x text-muted mb-3"></i>
            <h4 class="text-theme-primary">Belum ada member</h4>
            <p class="text-muted">Mulai dengan menambahkan member pertama Anda.</p>
            <a href="{{ route('member.create') }}" class="btn btn-primary-custom">
                <i class="fas fa-plus me-2"></i>Tambah Member Pertama
            </a>
        </div>
    @endif
</div>
@endsection
