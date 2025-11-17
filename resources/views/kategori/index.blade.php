@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('navbar')
    @include('layouts.partials.header')
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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="text-theme-primary" style="font-size: 1.75rem;"><i class="fas fa-tags me-2"></i> Manajemen Kategori</h1>
            <a href="{{ route('kategori.create') }}" class="btn btn-primary-custom btn-md">
                <i class="fas fa-plus me-2"></i>Tambah Kategori
            </a>
        </div>
        <hr class="mt-0 mb-4">

        <div class="row g-3">
            @if(isset($kategories) && $kategories->isEmpty())
                <div class="col-12 text-center py-5">
                    <i class="fas fa-tags fa-4x text-secondary mb-3"></i>
                    <h4>Belum ada kategori</h4>
                    <p class="text-muted">Mulai dengan menambahkan kategori pertama Anda.</p>
                    <a href="{{ route('kategori.create') }}" class="btn btn-primary-custom mt-2">
                        <i class="fas fa-plus me-2"></i>Tambah Kategori Pertama
                    </a>
                </div>
            @else
                @foreach($kategories as $kategori)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card h-100 p-3 text-center bg-theme-light shadow-sm" style="border-top: 4px solid var(--color-accent);">
                            <div class="card-body p-3">
                                <div class="mb-3">
                                    {{-- Icon/Image Display --}}
                                    @if ($kategori->icon_url && filter_var($kategori->icon_url, FILTER_VALIDATE_URL))
                                        <img src="{{ $kategori->icon_url }}" alt="{{ $kategori->nama_kategori }}" class="rounded-3" style="width: 50px; height: 50px; object-fit: contain; border: 1px solid var(--color-primary);">
                                    @elseif(isset($kategori->icon_url))
                                        <img src="{{ asset('storage/' . $kategori->icon_url) }}" alt="{{ $kategori->nama_kategori }}" class="rounded-3" style="width: 50px; height: 50px; object-fit: contain; border: 1px solid var(--color-primary);">
                                    @else
                                        <i class="fas fa-layer-group fa-2x text-theme-primary"></i>
                                    @endif
                                </div>
                                <h6 class="card-title text-theme-primary fw-bold">{{ $kategori->nama_kategori }}</h6>
                                <p class="card-text text-muted small">
                                    {{ $kategori->products_count ?? 0 }} produk
                                </p>

                                <div class="btn-group w-100 mt-3">
                                    <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-primary-custom btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Hapus kategori {{ $kategori->nama_kategori }}?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
