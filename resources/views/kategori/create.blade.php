<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori - Minimarket</title>
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
        .preview-image {
            max-width: 200px;
            max-height: 200px;
            object-fit: cover;
            border-radius: 10px;
            display: none;
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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-plus me-2"></i>Tambah Kategori Baru</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('kategori.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="nama_kategori" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror"
                                       id="nama_kategori" name="nama_kategori"
                                       value="{{ old('nama_kategori') }}"
                                       placeholder="Masukkan nama kategori" required>
                                @error('nama_kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="icon_url" class="form-label">Icon Kategori</label>
                                <input type="file" class="form-control @error('icon_url') is-invalid @enderror"
                                       id="icon_url" name="icon_url"
                                       accept="image/*" onchange="previewImage(this)">
                                <div class="form-text">
                                    Format: JPEG, PNG, JPG, GIF, SVG. Maksimal 2MB.
                                </div>
                                @error('icon_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <!-- Image Preview -->
                                <div class="mt-3 text-center">
                                    <img id="imagePreview" class="preview-image" src="#" alt="Preview">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Kategori
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
