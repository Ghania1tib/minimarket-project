<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Minimarket</title>
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
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Produk</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('produk.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_produk" class="form-label">Nama Produk</label>
                                        <input type="text" class="form-control @error('nama_produk') is-invalid @enderror"
                                               id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" required>
                                        @error('nama_produk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Kategori</label>
                                        <select class="form-select @error('category_id') is-invalid @enderror"
                                                id="category_id" name="category_id" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                                                    {{ $category->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="barcode" class="form-label">Barcode</label>
                                        <input type="text" class="form-control @error('barcode') is-invalid @enderror"
                                               id="barcode" name="barcode" value="{{ old('barcode', $product->barcode) }}">
                                        @error('barcode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gambar" class="form-label">Gambar Produk</label>
                                        <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                               id="gambar" name="gambar" accept="image/*">
                                        @if($product->gambar_url)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $product->gambar_url) }}" alt="{{ $product->nama_produk }}" class="img-thumbnail" style="max-height: 100px;">
                                                <small class="text-muted d-block">Gambar saat ini</small>
                                            </div>
                                        @endif
                                        @error('gambar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                          id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="harga_beli" class="form-label">Harga Beli</label>
                                        <input type="number" class="form-control @error('harga_beli') is-invalid @enderror"
                                               id="harga_beli" name="harga_beli" value="{{ old('harga_beli', $product->harga_beli) }}" min="0" step="100" required>
                                        @error('harga_beli')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="harga_jual" class="form-label">Harga Jual</label>
                                        <input type="number" class="form-control @error('harga_jual') is-invalid @enderror"
                                               id="harga_jual" name="harga_jual" value="{{ old('harga_jual', $product->harga_jual) }}" min="0" step="100" required>
                                        @error('harga_jual')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="stok" class="form-label">Stok</label>
                                        <input type="number" class="form-control @error('stok') is-invalid @enderror"
                                               id="stok" name="stok" value="{{ old('stok', $product->stok) }}" min="0" required>
                                        @error('stok')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="stok_kritis" class="form-label">Stok Kritis</label>
                                        <input type="number" class="form-control @error('stok_kritis') is-invalid @enderror"
                                               id="stok_kritis" name="stok_kritis" value="{{ old('stok_kritis', $product->stok_kritis) }}" min="0" required>
                                        @error('stok_kritis')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('produk.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Produk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
