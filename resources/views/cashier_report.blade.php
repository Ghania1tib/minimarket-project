<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kas Harian - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ffdde1, #a1c4fd);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }
        .report-container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .report-header {
            background-color: #004f7c;
            color: white;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }
        .summary-box {
            background-color: #f8f9fa;
            border-radius: 10px;
            border: 1px solid #dee2e6;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        .summary-item {
            padding: 15px;
            border-bottom: 1px dashed #ced4da;
        }
        .summary-item:last-child {
            border-bottom: none;
        }
        .kas-fisik-card {
            border-left: 5px solid #28a745;
        }
        .btn-finish-report {
            background-color: #ff6347; /* Warna cerah dari tema */
            border-color: #ff6347;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="report-container">

        <div class="report-header d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="fas fa-file-invoice-dollar me-2"></i> LAPORAN KAS HARIAN (CLOSING SHIFT)</h4>
            <a href="{{ route('dashboard.staff') }}" class="btn btn-sm btn-light"><i class="fas fa-arrow-left me-2"></i> Dashboard</a>
        </div>

        <div class="row g-4">

            <div class="col-lg-6">
                <div class="card shadow-sm summary-box h-100">
                    <div class="card-header bg-light fw-bold text-center">
                        RINGKASAN PENJUALAN SHIFT
                    </div>
                    <div class="card-body p-0">

                        <div class="summary-item bg-light">
                            <h5 class="mb-0 text-primary">TOTAL PENJUALAN KOTOR</h5>
                            <h2 class="fw-bolder mb-0">Rp 1.550.000</h2>
                        </div>

                        <div class="summary-item">
                            <p class="fw-bold mb-1"><i class="fas fa-money-bill-wave me-2 text-success"></i> Tunai (CASH)</p>
                            <p class="float-end">Rp 800.000</p>
                        </div>
                        <div class="summary-item">
                            <p class="fw-bold mb-1"><i class="fas fa-credit-card me-2 text-primary"></i> Debit/Kredit</p>
                            <p class="float-end">Rp 500.000</p>
                        </div>
                        <div class="summary-item">
                            <p class="fw-bold mb-1"><i class="fas fa-qrcode me-2 text-info"></i> QRIS/E-Wallet</p>
                            <p class="float-end">Rp 250.000</p>
                        </div>

                    </div>
                    <div class="card-footer bg-white text-end fw-bold text-primary">
                        Total Transaksi: 45
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm kas-fisik-card h-100">
                    <div class="card-header bg-success text-white fw-bold text-center">
                        INPUT KAS FISIK & TUTUP SHIFT
                    </div>
                    <div class="card-body p-4">

                        <div class="mb-4">
                            <label class="form-label fw-bold">Modal Awal Kas (Petty Cash)</label>
                            <input type="text" class="form-control form-control-lg text-end" value="Rp 500.000" readonly>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-success">Total Penerimaan Tunai (Sistem)</label>
                            <input type="text" class="form-control form-control-lg text-end text-success" value="Rp 800.000" readonly>
                        </div>

                        <hr>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-danger">UANG FISIK DI LACI (Wajib Hitung)</label>
                            <input type="number" class="form-control form-control-lg text-end" placeholder="Masukkan Jumlah Uang Fisik" id="kasFisikInput">
                        </div>

                        <div class="alert alert-warning text-center fw-bold mt-4" id="selisihOutput">
                            TOTAL UANG KAS YANG HARUS ADA: Rp 1.300.000
                        </div>

                        <div class="d-grid mt-4">
                            <button class="btn btn-finish-report btn-lg"><i class="fas fa-lock me-2"></i> KONFIRMASI & TUTUP SHIFT</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Logika Sederhana untuk Menghitung Selisih (Optional)
        document.addEventListener('DOMContentLoaded', function() {
            const modalAwal = 500000;
            const penerimaanTunaiSistem = 800000;
            const targetKas = modalAwal + penerimaanTunaiSistem;

            const kasFisikInput = document.getElementById('kasFisikInput');
            const selisihOutput = document.getElementById('selisihOutput');

            // Tampilkan Target Awal
            selisihOutput.innerHTML = `TOTAL UANG KAS YANG HARUS ADA: Rp ${targetKas.toLocaleString('id-ID')}`;

            kasFisikInput.addEventListener('input', function() {
                const kasFisik = parseFloat(this.value) || 0;
                const selisih = kasFisik - targetKas;

                let alertClass = 'alert-warning';
                let message = `SELISIH: Rp ${selisih.toLocaleString('id-ID')}`;

                if (selisih === 0) {
                    alertClass = 'alert-success';
                    message = `<i class="fas fa-check-circle me-1"></i> KAS COCOK (Rp 0)`;
                } else if (selisih > 0) {
                    alertClass = 'alert-danger';
                    message = `<i class="fas fa-plus me-1"></i> KELEBIHAN KAS: Rp ${selisih.toLocaleString('id-ID')}`;
                } else {
                    alertClass = 'alert-danger';
                    message = `<i class="fas fa-minus me-1"></i> KEKURANGAN KAS: Rp ${Math.abs(selisih).toLocaleString('id-ID')}`;
                }

                selisihOutput.className = `alert ${alertClass} text-center fw-bold mt-4`;
                selisihOutput.innerHTML = message;
            });
        });
    </script>
</body>
</html>
