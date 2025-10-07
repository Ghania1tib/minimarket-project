<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Stok - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ffdde1, #a1c4fd);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .check-card {
            max-width: 800px;
            margin: 50px auto;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        .result-box {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            border-left: 5px solid #004f7c;
        }
    </style>
</head>
<body>
    <div class="card check-card">
        <div class="card-header bg-primary text-white text-center p-3" style="background-color: #004f7c !important; border-radius: 15px 15px 0 0;">
            <h4 class="mb-0"><i class="fas fa-cubes me-2"></i> CEK HARGA & STOK PRODUK</h4>
        </div>
        <div class="card-body p-4">
            <div class="input-group mb-4">
                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                <input type="text" class="form-control form-control-lg" placeholder="Masukkan Barcode / Nama Produk..." autofocus>
                <button class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
            </div>

            <div class="result-box mt-4">
                <h5 class="text-success"><i class="fas fa-check-circle me-2"></i> Produk Ditemukan!</h5>
                <hr>
                <div class="row">
                    <div class="col-md-8">
                        <h6>Nama: Susu UHT Full Cream 1L</h6>
                        <p class="mb-1">Barcode: 899xxxxxxx</p>
                        <p class="mb-1">Kategori: Minuman</p>
                        <h4 class="text-danger mt-2">Harga Jual: Rp 17.500</h4>
                    </div>
                    <div class="col-md-4 text-center">
                        <h1 class="text-primary mt-2">124</h1>
                        <p class="mb-0 text-muted">Stok Tersedia (Unit)</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{ route('dashboard.staff') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
