<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kategori - Minimarket</title>
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
        .category-icon {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }
        .btn-group .btn {
            margin: 0 2px;
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
                <a class="nav-link" href="{{ route('produk.index') }}">Produk</a>
                <a class="nav-link active" href="{{ route('kategori.index') }}">Kategori</a>
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
            <h1><i class="fas fa-tags me-2"></i> Manajemen Kategori</h1>
            <a href="{{ route('kategori.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Kategori
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            @foreach($kategories as $kategori)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            @if($kategori->icon_url)
                                <img src="{{ asset('storage/' . $kategori->icon_url) }}"
                                     class="category-icon mb-3"
                                     alt="{{ $kategori->nama_kategori }}">
                            @else
                                <div class="category-icon bg-light d-flex align-items-center justify-content-center mx-auto mb-3">
                                    <i class="fas fa-tag fa-2x text-muted"></i>
                                </div>
                            @endif

                            <h5 class="card-title">{{ $kategori->nama_kategori }}</h5>
                            <p class="card-text text-muted">
                                <small>{{ $kategori->products_count }} produk</small>
                            </p>

                            <div class="btn-group w-100">
                                <a href="{{ route('kategori.show', $kategori->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus kategori {{ $kategori->nama_kategori }}?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($kategories->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-tags fa-4x text-muted mb-3"></i>
                <h4>Belum ada kategori</h4>
                <p class="text-muted">Mulai dengan menambahkan kategori pertama Anda.</p>
                <a href="{{ route('kategori.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Kategori Pertama
                </a>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
