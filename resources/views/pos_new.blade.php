<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS - Transaksi Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* -------------------------------------- */
        /* Gaya Tema Dasar (Sesuai Tema Aplikasi) */
        /* -------------------------------------- */
        body {
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            margin: 0;
            min-height: 100vh;
        }
        .pos-container {
            max-width: 1300px;
            margin: 20px auto;
            padding: 10px;
        }

        /* -------------------------------------- */
        /* Header POS */
        /* -------------------------------------- */
        .pos-header {
            background-color: #004f7c;
            color: white;
            padding: 15px 25px;
            border-radius: 8px 8px 0 0;
            margin-bottom: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .btn-kembali {
            background-color: #ffb6c1;
            color: #004f7c;
            font-weight: bold;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-kembali:hover {
            background-color: #ff91a4;
            color: #003366;
        }

        /* -------------------------------------- */
        /* Kolom Kanan: Total dan Aksi Cepat */
        /* -------------------------------------- */
        .action-button-group .btn {
            /* Styling untuk tombol Tambah Member/Diskon */
            background-color: white; /* Putih bersih */
            color: #004f7c;
            border: 1px solid #dee2e6;
            font-weight: 500;
            margin-bottom: 10px; /* Jarak antar tombol */
            border-radius: 8px;
            padding: 12px;
            text-align: left;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05); /* Bayangan sangat tipis */
            transition: background-color 0.2s, border-color 0.2s;
        }
        .action-button-group .btn:hover {
            background-color: #f0f0f0;
            border-color: #ffb6c1; /* Border pink saat hover */
            color: #003366;
        }

        .total-box {
            background-color: #003366;
            color: white;
            padding: 25px 20px;
            border-radius: 8px;
            text-align: right;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .total-box h1 {
            font-size: 3.2rem;
            font-weight: 900;
            margin: 0;
        }
        /* Styling untuk teks kecil di total box */
        .total-box small {
            font-size: 0.9rem;
            opacity: 0.8;
            letter-spacing: 1px;
            display: block;
        }

        /* -------------------------------------- */
        /* Pembayaran dan Finalisasi */
        /* -------------------------------------- */
        .payment-card {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }
        .btn-finish {
            background-color: #28a745;
            border-color: #28a745;
            font-size: 1.2rem;
            font-weight: bold;
            padding: 10px 0;
        }
        .btn-finish:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        /* Input Field Rapi */
        .form-control-lg {
            padding: 0.75rem 1rem;
            font-size: 1.25rem;
        }
    </style>
</head>
<body>
    <div class="pos-container">

        <div class="pos-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-barcode me-3"></i> POINT OF SALE (POS)</h4>
            <a href="{{ route('dashboard.staff') }}" class="btn btn-sm btn-kembali shadow-sm"><i class="fas fa-arrow-left me-2"></i> Kembali</a>
        </div>

        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card card-list shadow-lg">
                    <div class="card-header bg-white p-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control form-control-lg" placeholder="Scan Barcode atau Cari Produk..." autofocus>
                            <button class="btn btn-add"><i class="fas fa-plus"></i> Tambah</button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-list">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Nama Produk</th>
                                        <th class="text-end">Harga</th>
                                        <th style="width: 100px;">Qty</th>
                                        <th class="text-end">Subtotal</th>
                                        <th style="width: 80px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Minyak Goreng Sania 2L</td>
                                        <td class="text-end">Rp 32.000</td>
                                        <td><input type="number" value="1" min="1" class="form-control form-control-sm text-center"></td>
                                        <td class="text-end fw-bold">Rp 32.000</td>
                                        <td><button class="btn btn-sm btn-delete"><i class="fas fa-trash"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">

                <div class="d-grid action-button-group mb-3">

                    <a href="{{ route('member.management') }}" class="btn shadow-sm d-block">
                        <i class="fas fa-user-plus me-2"></i> Tambah Member
                    </a>

                    <a href="{{ route('diskon.management') }}" class="btn shadow-sm d-block">
                        <i class="fas fa-tags me-2"></i> Tambah Diskon
                    </a>
                </div>

                <div class="total-box">
                    <small>TOTAL BELANJA</small>
                    <h1>Rp 157.000</h1>
                </div>

                <div class="card payment-card shadow-sm">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Pembayaran</label>
                        <select class="form-select">
                            <option>Tunai</option>
                            <option>QRIS/E-Wallet</option>
                            <option>Debit/Kredit</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Nominal Bayar</label>
                        <input type="number" class="form-control form-control-lg" placeholder="Rp ...">
                    </div>
                    <button class="btn btn-finish d-block w-100"><i class="fas fa-check-circle me-2"></i> SELESAI TRANSAKSI</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
