<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kas Harian - Toko Saudara 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Variabel CSS konsisten dengan tema sebelumnya */
        :root {
            --color-primary: #5E548E;
            --color-secondary: #9F86C0;
            --color-accent: #E0B1CB;
            --color-danger: #E07A5F;
            --color-success: #70C1B3;
            --color-warning: #FFB347;
            --color-info: #5BC0DE;
            --color-light: #F0E6EF;
            --color-white: #ffffff;
            --gradient-bg: linear-gradient(135deg, #F0E6EF 0%, #D891EF 100%);
            --font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            --border-radius-lg: 15px;
            --border-radius-sm: 8px;
        }

        body {
            background: var(--gradient-bg);
            font-family: var(--font-family);
            min-height: 100vh;
            padding: 20px;
        }


        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .content-wrapper {
            flex: 1;
            margin-left: 280px;
            padding: 20px;
            transition: margin-left 0.3s ease;
            background: var(--gradient-bg);
            min-height: 100vh;
        }

        /* Card Styling Konsisten */
        .card {
            border-radius: var(--border-radius-lg);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: none;
            background: var(--color-white);
            margin-bottom: 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Section Title */
        .section-title {
            color: var(--color-primary);
            font-weight: 700;
            margin-bottom: 0.5rem;
            border-left: 4px solid var(--color-accent);
            padding-left: 15px;
        }

        /* Header Laporan */
        .report-header {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            color: white;
            padding: 25px;
            border-radius: var(--border-radius-lg);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
        }

        /* Button Styling */
        .btn-primary, .btn-success, .btn-danger, .btn-warning, .btn-outline-primary {
            border-radius: var(--border-radius-sm);
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }

        .btn-primary:hover {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(94, 84, 142, 0.3);
        }

        .btn-success {
            background-color: var(--color-success);
            border-color: var(--color-success);
        }

        .btn-success:hover {
            background-color: #5CAE95;
            border-color: #5CAE95;
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            border: 2px solid var(--color-primary);
            color: var(--color-primary);
        }

        .btn-outline-primary:hover {
            background: var(--color-primary);
            color: white;
            transform: translateY(-2px);
        }

        /* Form Styling */
        .form-control {
            border-radius: var(--border-radius-sm);
            border: 2px solid var(--color-accent);
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 0.2rem rgba(224, 177, 203, 0.25);
        }

        /* Alert Styling */
        .alert {
            border-radius: var(--border-radius-sm);
            border: none;
        }

        .alert-info {
            background-color: rgba(91, 192, 222, 0.1);
            border-left: 4px solid var(--color-info);
            color: #0c5460;
        }

        .alert-success {
            background-color: rgba(112, 193, 179, 0.1);
            border-left: 4px solid var(--color-success);
            color: #0f5132;
        }

        .alert-danger {
            background-color: rgba(224, 122, 95, 0.1);
            border-left: 4px solid var(--color-danger);
            color: #721c24;
        }

        .alert-warning {
            background-color: rgba(255, 179, 71, 0.1);
            border-left: 4px solid var(--color-warning);
            color: #856404;
        }

        /* Badge Styling */
        .badge {
            font-weight: 500;
            letter-spacing: 0.3px;
            padding: 6px 12px !important;
            font-size: 0.85rem !important;
            border-radius: 50px !important;
        }

        /* Table Styling */
        .table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .table thead th {
            background-color: var(--color-primary);
            color: white;
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(224, 177, 203, 0.1);
            transform: translateX(5px);
        }

        .table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            border-color: #e9ecef;
        }

        /* Stat Card */
        .stat-card {
            background: white;
            border-radius: var(--border-radius-lg);
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: none;
            transition: all 0.3s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        /* Payment Method Icon */
        .payment-method-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.2rem;
        }

        .tunai-bg {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .debit-bg {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }

        .qris-bg {
            background: linear-gradient(135deg, #17a2b8, #138496);
        }

        /* Summary Item */
        .summary-item {
            padding: 15px;
            border-bottom: 1px dashed #e9ecef;
            transition: background-color 0.3s ease;
        }

        .summary-item:hover {
            background-color: rgba(240, 230, 239, 0.3);
        }

        /* Shift Status */
        .shift-active {
            border-left: 5px solid var(--color-success);
        }

        .shift-inactive {
            border-left: 5px solid var(--color-danger);
        }

        /* Chart Container */
        .chart-container {
            background: white;
            border-radius: var(--border-radius-lg);
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.9rem;
            }

            .report-header {
                padding: 20px;
            }

            .report-header h1 {
                font-size: 1.5rem;
            }
        }

        @media print {
            .btn-group,
            .no-print {
                display: none !important;
            }

            .card {
                box-shadow: none !important;
                border: 1px solid #dee2e6 !important;
            }
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <!-- Sidebar Admin -->
        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'owner')
            @include('layouts.sidebar-admin')
        @elseif(Auth::user()->role === 'kasir' || Auth::user()->role === 'staff')
            @include('layouts.sidebar-kasir')
        @endif
        <!-- Header Laporan -->
        <div class="content-wrapper">
        <div class="report-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2"><i class="fas fa-file-invoice-dollar me-3"></i>Laporan Penjualan</h1>
                    <p class="mb-0 opacity-75 fs-5">Toko Saudara 2 - Sistem Manajemen Kasir Terintegrasi</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="badge bg-white text-primary fs-5 p-3">
                        <i class="fas fa-calendar me-2"></i>
                        {{ \Carbon\Carbon::parse($tanggal ?? now())->translatedFormat('l, d F Y') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tanggal -->
        <div class="card">
            <div class="card-body">
                <h3 class="section-title mb-4">
                    <i class="fas fa-filter me-2"></i>Filter Laporan
                </h3>

                <form method="GET" action="{{ route('cashier.report') }}" class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Pilih Tanggal Laporan</label>
                        <input type="date" class="form-control" name="tanggal"
                            value="{{ $tanggal ?? now()->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary mt-4">
                            <i class="fas fa-filter me-2"></i> Filter Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <!-- Kolom Kiri - Ringkasan Penjualan & Grafik -->
            <div class="col-lg-8">
                <!-- Ringkasan Penjualan -->
                <div class="card">
                    <div class="card-body">
                        <h3 class="section-title mb-4">
                            <i class="fas fa-chart-line me-2"></i>Ringkasan Penjualan Harian
                        </h3>

                        <!-- Total Penjualan -->
                        <div class="summary-item bg-light rounded mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="mb-1 text-primary">TOTAL PENJUALAN KOTOR</h4>
                                    <p class="mb-0 text-muted">Sebelum diskon dan pajak</p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <h2 class="fw-bold mb-0 text-success">
                                        Rp {{ number_format($salesData['total_penjualan_kotor'] ?? 0, 0, ',', '.') }}
                                    </h2>
                                </div>
                            </div>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="summary-item d-flex align-items-center">
                            <div class="payment-method-icon tunai-bg text-white">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fw-bold mb-1">Tunai (CASH)</h5>
                                <p class="mb-0 text-muted">Pembayaran secara tunai</p>
                            </div>
                            <div class="text-end">
                                <h4 class="fw-bold text-success mb-0">
                                    Rp {{ number_format($salesData['tunai'] ?? 0, 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>

                        <div class="summary-item d-flex align-items-center">
                            <div class="payment-method-icon debit-bg text-white">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fw-bold mb-1">Debit/Kredit</h5>
                                <p class="mb-0 text-muted">Kartu debit & kredit</p>
                            </div>
                            <div class="text-end">
                                <h4 class="fw-bold text-primary mb-0">
                                    Rp {{ number_format($salesData['debit_kredit'] ?? 0, 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>

                        <div class="summary-item d-flex align-items-center">
                            <div class="payment-method-icon qris-bg text-white">
                                <i class="fas fa-qrcode"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fw-bold mb-1">QRIS/E-Wallet</h5>
                                <p class="mb-0 text-muted">QRIS & dompet digital</p>
                            </div>
                            <div class="text-end">
                                <h4 class="fw-bold text-info mb-0">
                                    Rp {{ number_format($salesData['qris_ewallet'] ?? 0, 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>

                        <!-- Summary Footer -->
                        <div class="summary-item bg-light rounded mt-3">
                            <div class="row text-center">
                                <div class="col-md-4 border-end">
                                    <h5 class="text-muted mb-2">Total Transaksi</h5>
                                    <h3 class="fw-bold text-primary">{{ $salesData['total_transaksi'] ?? 0 }}</h3>
                                </div>
                                <div class="col-md-4 border-end">
                                    <h5 class="text-muted mb-2">Total Diskon</h5>
                                    <h3 class="fw-bold text-warning">
                                        Rp {{ number_format($salesData['total_diskon'] ?? 0, 0, ',', '.') }}
                                    </h3>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="text-muted mb-2">Pendapatan Bersih</h5>
                                    <h3 class="fw-bold text-success">
                                        Rp {{ number_format($salesData['total_bayar_bersih'] ?? 0, 0, ',', '.') }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grafik Mingguan -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h3 class="section-title mb-4">
                            <i class="fas fa-chart-bar me-2"></i>Grafik Penjualan 7 Hari Terakhir
                        </h3>
                        <div class="chart-container">
                            <canvas id="weeklySalesChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan - Shift Management & Statistik -->
            <div class="col-lg-4">
                <!-- Shift Management -->
                <div class="card {{ $activeShift ?? false ? 'shift-active' : 'shift-inactive' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="section-title mb-0">
                                <i class="fas fa-{{ $activeShift ?? false ? 'play-circle' : 'stop-circle' }} me-2"></i>
                                {{ $activeShift ?? false ? 'SHIFT AKTIF' : 'TIDAK ADA SHIFT AKTIF' }}
                            </h3>
                            <span class="badge {{ $activeShift ?? false ? 'bg-success' : 'bg-danger' }} fs-6">
                                {{ $activeShift ?? false ? 'AKTIF' : 'NONAKTIF' }}
                            </span>
                        </div>

                        @if ($activeShift ?? false)
                            <!-- Informasi Shift Aktif -->
                            <div class="alert alert-info mb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Shift Aktif</strong>
                                    </div>
                                    <span class="badge bg-success">Berjalan</span>
                                </div>
                                <p class="mb-0 mt-2">
                                    <small>
                                        <i class="fas fa-user me-1"></i>
                                        Kasir: <strong>{{ $activeShift->nama_kasir }}</strong> |
                                        <i class="fas fa-clock me-1"></i>
                                        Dimulai: {{ $activeShift->waktu_mulai->format('H:i') }} |
                                        Durasi: {{ $activeShift->waktu_mulai->diffForHumans(now(), true) }}
                                    </small>
                                </p>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-money-bill-wave me-2 text-success"></i>Modal Awal Kas
                                </label>
                                <input type="text" class="form-control text-end bg-light"
                                    value="Rp {{ number_format($activeShift->modal_awal, 0, ',', '.') }}"
                                    readonly>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-success">
                                    <i class="fas fa-cash-register me-2"></i>Total Penerimaan Tunai (Sistem)
                                </label>
                                <input type="text" class="form-control text-end text-success bg-light"
                                    value="Rp {{ number_format($salesData['tunai'] ?? 0, 0, ',', '.') }}"
                                    readonly>
                            </div>

                            <hr>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-danger">
                                    <i class="fas fa-calculator me-2"></i>UANG FISIK DI LACI
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control text-end"
                                    placeholder="Masukkan jumlah uang fisik" id="kasFisikInput"
                                    min="0" step="1000">
                                <div class="form-text text-danger">Wajib diisi dengan hasil hitung fisik uang di laci kasir</div>
                            </div>

                            @php
                                $totalKasHarusAda = $activeShift->modal_awal + ($salesData['tunai'] ?? 0);
                            @endphp

                            <div class="alert alert-warning text-center fw-bold" id="selisihOutput">
                                <i class="fas fa-calculator me-2"></i>
                                TOTAL UANG KAS YANG HARUS ADA: Rp
                                {{ number_format($totalKasHarusAda, 0, ',', '.') }}
                            </div>

                            <!-- Catatan Tambahan -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-sticky-note me-2"></i>Catatan Shift
                                </label>
                                <textarea class="form-control" id="catatanShift"
                                    placeholder="Opsional: catatan khusus untuk shift ini..." rows="3"></textarea>
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-success btn-lg" id="btnTutupShift">
                                    <i class="fas fa-lock me-2"></i> KONFIRMASI & TUTUP SHIFT
                                </button>
                            </div>
                        @else
                            <!-- Tidak Ada Shift Aktif -->
                            <div class="text-center py-4">
                                <i class="fas fa-stop-circle fa-4x text-danger mb-3"></i>
                                <h3 class="text-danger mb-3">Tidak Ada Shift Aktif</h3>
                                <p class="text-muted mb-4">Mulai shift terlebih dahulu untuk melakukan transaksi dan mencatat laporan kas</p>

                                <div class="mt-4">
                                    <!-- Input Nama Kasir -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-user me-2"></i>Nama Kasir
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control text-center"
                                               id="namaKasirInput"
                                               placeholder="Masukkan nama kasir"
                                               autocomplete="off"
                                               style="font-weight: bold;">
                                        <div class="text-muted mt-2">
                                            <small>
                                                <i class="fas fa-info-circle me-1"></i>
                                                Masukkan nama kasir yang bertugas
                                            </small>
                                        </div>
                                    </div>

                                    <label class="form-label fw-bold">
                                        <i class="fas fa-coins me-2"></i>Modal Awal Kas
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                           class="form-control text-center"
                                           id="modalAwalInput"
                                           placeholder="100000"
                                           inputmode="numeric"
                                           autocomplete="off"
                                           style="font-weight: bold; letter-spacing: 1px;">

                                    <div class="text-muted mt-2">
                                        <small>
                                            <i class="fas fa-info-circle me-1"></i>
                                            Ketik angka saja (contoh: <strong>100000</strong> untuk Rp 100.000)
                                        </small>
                                    </div>

                                    <!-- Status akan muncul di sini -->
                                    <div id="inputStatus" class="alert d-none mt-3"></div>

                                    <button class="btn btn-success btn-lg w-100 mt-3 py-3"
                                            id="btnMulaiShift">
                                        <i class="fas fa-play me-2"></i> MULAI SHIFT BARU
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Statistik Cepat -->
                <div class="row mt-4">
                    <div class="col-12 mb-3">
                        <div class="stat-card">
                            <div class="text-primary mb-3">
                                <i class="fas fa-shopping-cart fa-3x"></i>
                            </div>
                            <h5 class="text-muted mb-2">TRANSAKSI HARI INI</h5>
                            <h2 class="text-primary mb-0 fw-bold">{{ $salesData['total_transaksi'] ?? 0 }}</h2>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="stat-card">
                            <div class="text-success mb-3">
                                <i class="fas fa-money-bill-wave fa-3x"></i>
                            </div>
                            <h5 class="text-muted mb-2">RATA-RATA TRANSAKSI</h5>
                            <h3 class="text-success mb-0 fw-bold">
                                @php
                                    $rata_rata =
                                        ($salesData['total_transaksi'] ?? 0) > 0
                                            ? ($salesData['total_bayar_bersih'] ?? 0) /
                                                ($salesData['total_transaksi'] ?? 1)
                                            : 0;
                                @endphp
                                Rp {{ number_format($rata_rata, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Riwayat Shift -->
        <div class="card mt-4">
            <div class="card-body">
                <h3 class="section-title mb-4">
                    <i class="fas fa-history me-2"></i>Riwayat Shift Terakhir
                </h3>

                @if(isset($shiftHistory) && $shiftHistory->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kasir</th>
                                    <th>Waktu Mulai</th>
                                    <th>Waktu Selesai</th>
                                    <th>Modal Awal</th>
                                    <th>Total Tunai</th>
                                    <th>Total Debit</th>
                                    <th>Total QRIS</th>
                                    <th>Uang Fisik</th>
                                    <th>Selisih</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shiftHistory as $shift)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <strong class="text-primary">{{ $shift->nama_kasir }}</strong>
                                        </td>
                                        <td>{{ $shift->waktu_mulai->format('d/m/Y H:i') }}</td>
                                        <td>{{ $shift->waktu_selesai ? $shift->waktu_selesai->format('d/m/Y H:i') : '-' }}</td>
                                        <td class="text-primary fw-semibold">
                                            Rp {{ number_format($shift->modal_awal, 0, ',', '.') }}
                                        </td>
                                        <td class="text-success fw-semibold">
                                            Rp {{ number_format($shift->total_tunai_sistem, 0, ',', '.') }}
                                        </td>
                                        <td class="text-info fw-semibold">
                                            Rp {{ number_format($shift->total_debit_sistem, 0, ',', '.') }}
                                        </td>
                                        <td class="text-warning fw-semibold">
                                            Rp {{ number_format($shift->total_qris_sistem, 0, ',', '.') }}
                                        </td>
                                        <td class="fw-semibold">
                                            Rp {{ number_format($shift->uang_fisik_di_kasir, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <span class="badge {{ $shift->selisih == 0 ? 'bg-success' : 'bg-danger' }}">
                                                Rp {{ number_format($shift->selisih, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($shift->selisih == 0)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i>Cocok
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>Selisih
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 text-muted">
                        Total: {{ $shiftHistory->count() }} shift
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-history fa-4x text-muted mb-3"></i>
                        <h4>Belum Ada Riwayat Shift</h4>
                        <p class="text-muted">Mulai shift pertama Anda untuk melihat riwayat di sini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Grafik Penjualan Mingguan
            const weeklyCtx = document.getElementById('weeklySalesChart').getContext('2d');
            const weeklyChart = new Chart(weeklyCtx, {
                type: 'bar',
                data: {
                    labels: @json($weeklySales['labels']),
                    datasets: [{
                        label: 'Penjualan (Rp)',
                        data: @json($weeklySales['sales']),
                        backgroundColor: 'rgba(94, 84, 142, 0.8)',
                        borderColor: 'rgba(94, 84, 142, 1)',
                        borderWidth: 2,
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Penjualan: Rp ' + context.raw.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

            @if ($activeShift ?? false)
                // ========== LOGIKA UNTUK SHIFT AKTIF ==========
                const modalAwal = {{ $activeShift->modal_awal }};
                const penerimaanTunaiSistem = {{ $salesData['tunai'] ?? 0 }};
                const targetKas = modalAwal + penerimaanTunaiSistem;

                const kasFisikInput = document.getElementById('kasFisikInput');
                const selisihOutput = document.getElementById('selisihOutput');
                const btnTutupShift = document.getElementById('btnTutupShift');
                const catatanShift = document.getElementById('catatanShift');

                // Hitung selisih real-time
                kasFisikInput.addEventListener('input', function() {
                    const kasFisik = parseFloat(this.value) || 0;
                    const selisih = kasFisik - targetKas;

                    let alertClass = 'alert-warning';
                    let message = `SELISIH: Rp ${selisih.toLocaleString('id-ID')}`;
                    let icon = 'fas fa-calculator';

                    if (selisih === 0) {
                        alertClass = 'alert-success';
                        message = `<i class="fas fa-check-circle me-1"></i> KAS COCOK (Rp 0)`;
                        icon = 'fas fa-check-circle';
                        btnTutupShift.disabled = false;
                    } else if (selisih > 0) {
                        alertClass = 'alert-danger';
                        message =
                            `<i class="fas fa-plus me-1"></i> KELEBIHAN KAS: Rp ${selisih.toLocaleString('id-ID')}`;
                        icon = 'fas fa-plus';
                        btnTutupShift.disabled = false;
                    } else {
                        alertClass = 'alert-danger';
                        message =
                            `<i class="fas fa-minus me-1"></i> KEKURANGAN KAS: Rp ${Math.abs(selisih).toLocaleString('id-ID')}`;
                        icon = 'fas fa-minus';
                        btnTutupShift.disabled = false;
                    }

                    selisihOutput.className = `alert ${alertClass} text-center fw-bold`;
                    selisihOutput.innerHTML = `<i class="${icon} me-2"></i>${message}`;
                });

                // Tutup Shift
                btnTutupShift.addEventListener('click', function() {
                    const uangFisik = parseFloat(kasFisikInput.value) || 0;
                    const catatan = catatanShift.value;

                    if (!uangFisik) {
                        alert('Masukkan jumlah uang fisik terlebih dahulu!');
                        kasFisikInput.focus();
                        return;
                    }

                    if (!confirm(
                            'Apakah Anda yakin ingin menutup shift? Tindakan ini tidak dapat dibatalkan.'
                        )) {
                        return;
                    }

                    btnTutupShift.disabled = true;
                    btnTutupShift.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';

                    // Simulasi API call - ganti dengan endpoint yang sesuai
                    fetch('{{ route('cashier.close-shift') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                uang_fisik_di_kasir: uangFisik,
                                catatan: catatan
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Shift berhasil ditutup!\nTotal Penjualan: Rp ' + data.data
                                    .total_penjualan.toLocaleString('id-ID'));
                                window.location.reload();
                            } else {
                                alert('Gagal menutup shift: ' + data.message);
                                btnTutupShift.disabled = false;
                                btnTutupShift.innerHTML =
                                    '<i class="fas fa-lock me-2"></i> KONFIRMASI & TUTUP SHIFT';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat menutup shift');
                            btnTutupShift.disabled = false;
                            btnTutupShift.innerHTML =
                                '<i class="fas fa-lock me-2"></i> KONFIRMASI & TUTUP SHIFT';
                        });
                });
            @else
                // ========== LOGIKA UNTUK MULAI SHIFT BARU ==========
                const btnMulaiShift = document.getElementById('btnMulaiShift');
                const modalAwalInput = document.getElementById('modalAwalInput');
                const namaKasirInput = document.getElementById('namaKasirInput');
                const inputStatus = document.getElementById('inputStatus');

                // Fungsi untuk membersihkan input dan mendapatkan nilai numerik
                function getNumericValue(value) {
                    if (!value) return 0;
                    // Hapus semua karakter non-digit
                    const clean = value.toString().replace(/[^\d]/g, '');
                    return parseInt(clean) || 0;
                }

                // Fungsi untuk update status input
                function updateInputStatus(message, type) {
                    inputStatus.textContent = message;
                    inputStatus.className = `alert alert-${type}`;
                    inputStatus.classList.remove('d-none');
                }

                // Validasi input real-time
                function validateInputs() {
                    const numericValue = getNumericValue(modalAwalInput.value);
                    const namaKasir = namaKasirInput.value.trim();

                    if (!namaKasir) {
                        updateInputStatus('❌ Masukkan nama kasir terlebih dahulu', 'danger');
                        btnMulaiShift.disabled = true;
                        return false;
                    }

                    if (numericValue === 0) {
                        updateInputStatus('❌ Masukkan modal awal kas', 'danger');
                        btnMulaiShift.disabled = true;
                        return false;
                    } else if (numericValue < 10000) {
                        updateInputStatus(`❌ Minimal Rp 10.000 (input: Rp ${numericValue.toLocaleString('id-ID')})`, 'danger');
                        btnMulaiShift.disabled = true;
                        return false;
                    } else {
                        updateInputStatus(`✅ Data valid: ${namaKasir} - Modal Rp ${numericValue.toLocaleString('id-ID')}`, 'success');
                        btnMulaiShift.disabled = false;
                        return true;
                    }
                }

                // Validasi input real-time
                modalAwalInput.addEventListener('input', validateInputs);
                namaKasirInput.addEventListener('input', validateInputs);

                // Handle tombol mulai shift
                btnMulaiShift.addEventListener('click', function() {
                    const numericValue = getNumericValue(modalAwalInput.value);
                    const namaKasir = namaKasirInput.value.trim();

                    console.log('Starting shift with modal:', numericValue, 'and cashier:', namaKasir);

                    // Validasi final
                    if (!namaKasir) {
                        alert('Nama kasir harus diisi');
                        namaKasirInput.focus();
                        return;
                    }

                    if (numericValue < 10000) {
                        alert('Modal awal minimal Rp 10.000');
                        modalAwalInput.focus();
                        return;
                    }

                    if (!confirm(
                            `Konfirmasi mulai shift:\nKasir: ${namaKasir}\nModal Awal: Rp ${numericValue.toLocaleString('id-ID')}`
                        )) {
                        return;
                    }

                    // UI feedback
                    const originalText = btnMulaiShift.innerHTML;
                    btnMulaiShift.disabled = true;
                    btnMulaiShift.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memulai...';

                    // API call dengan data nama kasir
                    fetch('{{ route('cashier.start-shift') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                modal_awal: numericValue,
                                nama_kasir: namaKasir
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network error: ' + response.status);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Server response:', data);

                            if (data.success) {
                                alert('🎉 ' + data.message);
                                window.location.reload();
                            } else {
                                throw new Error(data.message || 'Unknown server error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('❌ Gagal memulai shift:\n' + error.message);

                            // Reset UI
                            btnMulaiShift.disabled = false;
                            btnMulaiShift.innerHTML = originalText;
                        });
                });

                // Auto focus ke input nama kasir
                setTimeout(() => {
                    if (namaKasirInput) {
                        namaKasirInput.focus();
                    }
                }, 1000);
            @endif
        });
    </script>
</body>
</html>
