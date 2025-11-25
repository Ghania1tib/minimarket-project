@extends('layouts.app')

@section('title', 'Manajemen Produk')

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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-theme-primary" style="font-size: 1.75rem;">
                <i class="fas fa-boxes me-2"></i> Manajemen Produk
            </h1>
            <a href="{{ route('produk.create') }}" class="btn btn-primary-custom btn-md">
                <i class="fas fa-plus me-2"></i>Tambah Produk
            </a>
        </div>

        {{-- Filter Kategori --}}
        <div class="card mb-3 bg-theme-light shadow-sm">
            <div class="card-body py-2">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <span class="me-3 text-muted small"><i class="fas fa-filter me-1"></i>Filter by:</span>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('produk.index') }}"
                                   class="btn {{ !request('kategori') ? 'btn-primary-custom' : 'btn-outline-secondary' }}">
                                    Semua Kategori
                                </a>
                                @foreach($categories as $category)
                                    <a href="{{ route('produk.index', ['kategori' => $category->id]) }}"
                                       class="btn {{ request('kategori') == $category->id ? 'btn-primary-custom' : 'btn-outline-secondary' }}">
                                        {{ $category->nama_kategori }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <span class="text-muted small">
                            <i class="fas fa-cube me-1"></i>Total: {{ $products->total() }} produk
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pencarian --}}
        <div class="card mb-4 bg-theme-light shadow-sm">
            <div class="card-body p-3">
                <form action="{{ route('produk.search') }}" method="GET" class="row g-2 align-items-center">
                    @if(request('kategori'))
                        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                    @endif
                    <div class="col-md-10">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="keyword" class="form-control border-start-0"
                                   placeholder="Cari produk berdasarkan nama, barcode, atau kategori..."
                                   value="{{ request('keyword') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary-custom w-100 btn-sm">
                            <i class="fas fa-search me-1"></i>Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Info Filter Aktif --}}
        @if(request('kategori') && request('kategori') != '')
            @php
                $kategoriAktif = $categories->where('id', request('kategori'))->first();
            @endphp
            <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-filter me-2"></i>
                        Menampilkan produk dengan kategori: <strong>{{ $kategoriAktif->nama_kategori ?? 'Tidak Diketahui' }}</strong>
                        @if(request('keyword'))
                            dan pencarian: "<strong>{{ request('keyword') }}</strong>"
                        @endif
                    </div>
                    <a href="{{ route('produk.index') }}" class="btn-close"></a>
                </div>
            </div>
        @endif

        @if(request('keyword') && !request('kategori'))
            <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-search me-2"></i>
                        Menampilkan hasil pencarian: "<strong>{{ request('keyword') }}</strong>"
                    </div>
                    <a href="{{ route('produk.index') }}" class="btn-close"></a>
                </div>
            </div>
        @endif

        {{-- Daftar Produk --}}
        <div class="row g-3">
            @if($products->isEmpty())
                <div class="col-12 text-center py-5">
                    <i class="fas fa-box-open fa-4x text-secondary mb-3"></i>
                    <h4 class="text-theme-primary">Belum ada produk</h4>
                    <p class="text-muted">Mulai dengan menambahkan produk pertama Anda.</p>
                    <a href="{{ route('produk.create') }}" class="btn btn-primary-custom mt-2">
                        <i class="fas fa-plus me-2"></i>Tambah Produk Pertama
                    </a>
                </div>
            @else
                @foreach($products as $product)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        @php
                            $isLowStock = $product->stok <= $product->stok_kritis;
                            $stockClass = $product->stok > 0 ? ($isLowStock ? 'bg-warning' : 'bg-success-custom') : 'bg-danger';
                        @endphp
                        <div class="card h-100 shadow-sm product-card">
                            <div class="card-img-container position-relative">
                                @if($product->gambar_url)
                                    <img src="{{ $product->full_gambar_url }}"
                                         class="card-img-top"
                                         alt="{{ $product->nama_produk }}"
                                         style="height: 160px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-theme-light d-flex align-items-center justify-content-center"
                                         style="height: 160px;">
                                        <i class="fas fa-image fa-2x text-secondary"></i>
                                    </div>
                                @endif
                                <span class="position-absolute top-0 end-0 m-2 badge {{ $stockClass }}">
                                    {{ $product->stok }} stok
                                </span>
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title text-theme-primary fw-bold mb-2 line-clamp-2">
                                    {{ $product->nama_produk }}
                                </h6>

                                <div class="mb-2">
                                    <span class="badge bg-theme-accent text-dark">
                                        {{ $product->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <div class="text-success fw-bold fs-6">
                                        Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                    </div>
                                    <div class="text-muted small">
                                        Beli: Rp {{ number_format($product->harga_beli, 0, ',', '.') }}
                                    </div>
                                </div>

                                <div class="mt-auto">
                                    <div class="btn-group w-100" role="group">
                                        <a href="{{ route('produk.edit', $product->id) }}"
                                           class="btn btn-outline-primary btn-sm"
                                           title="Edit Produk">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('produk.show', $product->id) }}"
                                           class="btn btn-outline-info btn-sm"
                                           title="Detail Produk">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('produk.destroy', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Hapus produk {{ $product->nama_produk }}?')"
                                                    title="Hapus Produk">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4 p-3 bg-theme-light rounded">
                <div class="text-muted small">
                    Menampilkan <strong>{{ $products->firstItem() }} - {{ $products->lastItem() }}</strong>
                    dari <strong>{{ $products->total() }}</strong> produk
                </div>
                <div class="d-flex justify-content-center">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Previous Page Link --}}
                            @if($products->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->previousPageUrl() }}{{ request('kategori') ? '&kategori=' . request('kategori') : '' }}{{ request('keyword') ? '&keyword=' . request('keyword') : '' }}" rel="prev">Previous</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                @if($page == $products->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}{{ request('kategori') ? '&kategori=' . request('kategori') : '' }}{{ request('keyword') ? '&keyword=' . request('keyword') : '' }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if($products->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->nextPageUrl() }}{{ request('kategori') ? '&kategori=' . request('kategori') : '' }}{{ request('keyword') ? '&keyword=' . request('keyword') : '' }}" rel="next">Next</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">Next</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
                <div class="text-muted small">
                    Halaman <strong>{{ $products->currentPage() }}</strong>
                    dari <strong>{{ $products->lastPage() }}</strong>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')
<style>
    .product-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        border: 1px solid #e9ecef;
    }

    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    }

    .card-img-container {
        overflow: hidden;
    }

    .card-img-top {
        transition: transform 0.3s ease;
    }

    .product-card:hover .card-img-top {
        transform: scale(1.05);
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .btn-group .btn {
        border-radius: 0.375rem;
        margin: 0 1px;
    }

    .pagination .page-link {
        color: var(--color-primary);
        border: 1px solid #dee2e6;
        padding: 0.375rem 0.75rem;
    }

    .pagination .page-item.active .page-link {
        background-color: var(--color-primary);
        border-color: var(--color-primary);
        color: white;
    }

    .pagination .page-link:hover {
        background-color: var(--theme-light);
        border-color: #dee2e6;
    }

    .bg-success-custom {
        background-color: var(--color-success) !important;
        color: white;
    }
</style>
@endpush
