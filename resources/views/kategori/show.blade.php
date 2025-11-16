<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ffdde1, #a1c4fd);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .category-icon {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
        }
        .product-card {
            border-left: 4px solid #004f7c;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #004f7c;">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard.staff') }}">
                <i class="fas fa-cash-register"></i> Kasir Minimarket
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        @if($kategori->icon_url)
                            <img src="{{ asset('storage/' . $kategori->icon_url) }}"
                                 class="category-icon mb-3"
                                 alt="{{ $kategori->nama_kategori }}">
                        @else
                            <div class="category-icon bg-light d-flex align-items-center justify-content-center mx-auto mb-3">
                                <i class="fas fa-tag fa-3x text-muted"></i>
                            </div>
                        @endif

                        <h3>{{ $kategori->nama_kategori }}</h3>
                        <p class="text-muted">
                            {{ $kategori->products_count }} produk
                        </p>

                        <div class="d-grid gap-2">
                            <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit Kategori
                            </a>
                            <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100"
                                        onclick="return confirm('Hapus kategori {{ $kategori->nama_kategori }}?')">
                                    <i class="fas fa-trash me-2"></i>Hapus Kategori
                                </button>
                            </form>
                            <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-boxes me-2"></i>Produk dalam Kategori Ini</h5>
                    </div>
                    <div class="card-body">
                        @if($kategori->products->count() > 0)
                            <div class="row">
                                @foreach($kategori->products as $product)
                                    <div class="col-md-6 mb-3">
                                        <div class="card product-card h-100">
                                            <div class="card-body">
                                                <div class="d-flex align-items-start">
                                                    @if($product->gambar_url)
                                                        <img src="{{ asset('storage/' . $product->gambar_url) }}"
                                                             class="rounded me-3"
                                                             alt="{{ $product->nama_produk }}"
                                                             style="width: 60px; height: 60px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center me-3"
                                                             style="width: 60px; height: 60px;">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="card-title mb-1">{{ $product->nama_produk }}</h6>
                                                        <p class="card-text mb-1 text-success">
                                                            {{ 'Rp ' . number_format($product->harga_jual, 0, ',', '.') }}
                                                        </p>
                                                        <span class="badge {{ $product->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                                                            Stok: {{ $product->stok }}
                                                        </span>
                                                        @if($product->stok <= $product->stok_kritis)
                                                            <span class="badge bg-warning text-dark">Stok Kritis</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <h5>Belum ada produk dalam kategori ini</h5>
                                <p class="text-muted">Tambahkan produk baru dan pilih kategori ini.</p>
                                <a href="{{ route('produk.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Tambah Produk
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
