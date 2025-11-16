<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - Minimarket</title>
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
        .product-image {
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0"><i class="fas fa-eye me-2"></i>Detail Produk</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                @if($product->gambar_url)
                                    <img src="{{ asset('storage/' . $product->gambar_url) }}" class="img-fluid product-image" alt="{{ $product->nama_produk }}">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 200px;">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <h3>{{ $product->nama_produk }}</h3>
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Kategori</th>
                                        <td>{{ $product->category->nama_kategori ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Barcode</th>
                                        <td>{{ $product->barcode ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Harga Beli</th>
                                        <td class="text-danger">{{ 'Rp ' . number_format($product->harga_beli, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Harga Jual</th>
                                        <td class="text-success">{{ 'Rp ' . number_format($product->harga_jual, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Stok</th>
                                        <td>
                                            <span class="badge {{ $product->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $product->stok }}
                                            </span>
                                            @if($product->is_stok_kritis)
                                                <span class="badge bg-warning text-dark">Stok Kritis!</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Stok Kritis</th>
                                        <td>{{ $product->stok_kritis }}</td>
                                    </tr>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <td>{{ $product->deskripsi ?? '-' }}</td>
                                    </tr>
                                </table>

                                <div class="d-flex gap-2">
                                    <a href="{{ route('produk.edit', $product->id) }}" class="btn btn-warning">
                                        <i class="fas fa-edit me-2"></i>Edit
                                    </a>
                                    <form action="{{ route('produk.destroy', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus produk ini?')">
                                            <i class="fas fa-trash me-2"></i>Hapus
                                        </button>
                                    </form>
                                    <a href="{{ route('produk.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
