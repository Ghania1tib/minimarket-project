<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ffdde1, #a1c4fd);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background-color: #004f7c;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            margin-bottom: 20px;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .product-image {
            height: 200px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }
        .low-stock {
            border-left: 4px solid #dc3545;
        }
        .adequate-stock {
            border-left: 4px solid #28a745;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard.staff') }}">
                <i class="fas fa-cash-register"></i> Kasir Minimarket
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('dashboard.staff') }}">Dashboard</a>
                <a class="nav-link active" href="{{ route('produk.index') }}">Produk</a>
                <a class="nav-link" href="{{ route('kategori.index') }}">Kategori</a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-boxes me-2"></i> Manajemen Produk</h1>
            <a href="{{ route('produk.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Produk
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Search Form -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('produk.search') }}" method="GET" class="row g-3">
                    <div class="col-md-8">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari produk..." value="{{ request('keyword') }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4">
                    <div class="card {{ $product->is_stok_kritis ? 'low-stock' : 'adequate-stock' }}">
                        @if($product->gambar_url)
                            <img src="{{ asset('storage/' . $product->gambar_url) }}" class="card-img-top product-image" alt="{{ $product->nama_produk }}">
                        @else
                            <div class="card-img-top product-image bg-light d-flex align-items-center justify-content-center">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->nama_produk }}</h5>
                            <p class="card-text">
                                <small class="text-muted">Kategori: {{ $product->category->nama_kategori ?? '-' }}</small><br>
                                <strong>Harga: {{ $product->harga_jual_formatted }}</strong><br>
                                <span class="badge {{ $product->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                                    Stok: {{ $product->stok }}
                                </span>
                                @if($product->is_stok_kritis)
                                    <span class="badge bg-warning text-dark">Stok Kritis!</span>
                                @endif
                            </p>
                            <div class="btn-group w-100">
                                <a href="{{ route('produk.show', $product->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('produk.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('produk.destroy', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($products->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                <h4>Belum ada produk</h4>
                <p class="text-muted">Mulai dengan menambahkan produk pertama Anda.</p>
                <a href="{{ route('produk.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Produk Pertama
                </a>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
