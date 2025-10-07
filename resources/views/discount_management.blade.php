<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Diskon - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ffdde1, #a1c4fd); /* Latar belakang tema */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            padding: 20px;
        }
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        .card-diskon {
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        /* Kolom Kiri: Formulir */
        .form-header {
            background-color: #004f7c;
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 15px;
        }
        .btn-create-diskon {
            background-color: #ff6347; /* Warna cerah untuk menonjolkan aksi */
            border-color: #ff6347;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-create-diskon:hover {
            background-color: #e55337;
            border-color: #e55337;
        }

        /* Kolom Kanan: Daftar */
        .diskon-status-active {
            border-left: 4px solid #28a745; /* Hijau aktif */
        }
        .diskon-status-soon {
            border-left: 4px solid #ffc107; /* Kuning mendatang */
        }
        .diskon-status-expired {
            border-left: 4px solid #dc3545; /* Merah kadaluwarsa */
        }
        .table thead th {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="main-container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-tags me-3" style="color: #ff6347;"></i> Manajemen Diskon & Promo</h1>
            <a href="{{ route('dashboard.staff') }}" class="btn btn-primary"><i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard</a>
        </div>

        <div class="row g-4">

            <div class="col-lg-5">
                <div class="card card-diskon shadow-lg">
                    <div class="form-header text-center">
                        <h5 class="mb-0"><i class="fas fa-magic me-2"></i> Buat Promo Baru</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="/diskon/store" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Promo</label>
                                <input type="text" class="form-control" placeholder="Contoh: Flash Sale Minyak Goreng">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Jenis Diskon</label>
                                <select class="form-select">
                                    <option>Diskon Persen (%)</option>
                                    <option>Diskon Nominal (Rp)</option>
                                    <option>Beli X Gratis Y</option>
                                </select>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Nilai Diskon</label>
                                    <input type="text" class="form-control" placeholder="Contoh: 15% atau 5000">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Target Produk</label>
                                    <select class="form-select">
                                        <option>Semua Produk</option>
                                        <option>Kategori Tertentu (Makanan)</option>
                                        <option>Produk Spesifik (Susu UHT)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tanggal Mulai</label>
                                    <input type="datetime-local" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tanggal Berakhir</label>
                                    <input type="datetime-local" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="flashSaleCheck">
                                <label class="form-check-label" for="flashSaleCheck">Aktifkan sebagai Flash Sale (Tampil di Beranda)</label>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-create-diskon btn-lg"><i class="fas fa-paper-plane me-2"></i> Simpan & Aktifkan Promo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card card-diskon shadow-lg">
                    <div class="card-header bg-light">
                        <h5 class="mb-0 text-primary">Status Promo Saat Ini</h5>
                    </div>
                    <div class="card-body p-3">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Promo</th>
                                    <th>Tipe</th>
                                    <th>Berlaku Hingga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="diskon-status-active">
                                    <td>Diskon Member Baru</td>
                                    <td>10%</td>
                                    <td>31 Des 2025</td>
                                    <td><span class="badge bg-success">AKTIF</span></td>
                                    <td><button class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></button></td>
                                </tr>
                                <tr class="diskon-status-soon">
                                    <td>Flash Sale Daging</td>
                                    <td>Rp 10.000</td>
                                    <td>Besok, 10:00 WIB</td>
                                    <td><span class="badge bg-warning text-dark">MENDATANG</span></td>
                                    <td><button class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></button></td>
                                </tr>
                                <tr class="diskon-status-expired">
                                    <td>Promo Natal</td>
                                    <td>20%</td>
                                    <td>25 Des 2024</td>
                                    <td><span class="badge bg-danger">EXPIRED</span></td>
                                    <td><button class="btn btn-sm btn-outline-secondary" disabled><i class="fas fa-history"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
