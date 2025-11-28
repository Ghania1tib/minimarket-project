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
        :root {
            --color-primary: #5E548E;
            --color-secondary: #9F86C0;
            --color-accent: #E0B1CB;
            --color-danger: #E07A5F;
            --color-success: #70C1B3;
            --color-light: #F0E6EF;
            --color-warning: #FFA500;
        }

        body {
            background: linear-gradient(135deg, #F0E6EF 0%, #D891EF 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            min-height: 100vh;
        }

        .report-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .report-header {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            margin-bottom: 25px;
        }

        .card-custom {
            background: white;
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .card-header-custom {
            background: linear-gradient(135deg, var(--color-light) 0%, var(--color-accent) 100%);
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
            border-bottom: 3px solid var(--color-primary);
        }

        .summary-item {
            padding: 20px;
            border-bottom: 1px dashed #e9ecef;
            transition: background-color 0.3s ease;
        }

        .summary-item:hover {
            background-color: rgba(240, 230, 239, 0.3);
        }

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

        .tunai-bg { background: linear-gradient(135deg, #28a745, #20c997); }
        .debit-bg { background: linear-gradient(135deg, #007bff, #0056b3); }
        .qris-bg { background: linear-gradient(135deg, #17a2b8, #138496); }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(94, 84, 142, 0.3);
        }

        .btn-success-custom {
            background: linear-gradient(135deg, var(--color-success) 0%, #5CB85C 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-success-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(92, 184, 92, 0.3);
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            border: none;
            transition: all 0.3s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            height: 100%;
        }

        .history-item {
            border-left: 4px solid var(--color-primary);
            padding: 15px;
            margin-bottom: 12px;
            background: white;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        }

        .history-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .shift-active {
            border-left: 5px solid var(--color-success);
        }

        .shift-inactive {
            border-left: 5px solid var(--color-danger);
        }

        .form-control-custom {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control-custom:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 0.2rem rgba(94, 84, 142, 0.25);
        }

        .alert-custom {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
        }

        .input-status {
            border-radius: 8px;
            padding: 10px;
            margin-top: 10px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="report-container">
        <!-- Header -->
        <div class="report-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2"><i class="fas fa-file-invoice-dollar me-3"></i>LAPORAN KAS HARIAN</h1>
                    <p class="mb-0 opacity-75 fs-5">Toko Saudara 2 - Sistem Manajemen Kasir Terintegrasi</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="btn-group">
                        <a href="{{ route('dashboard.staff') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-arrow-left me-2"></i> Dashboard
                        </a>
                        <button class="btn btn-outline-light btn-lg" onclick="window.print()">
                            <i class="fas fa-print me-2"></i> Print
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tanggal -->
        <div class="card card-custom">
            <div class="card-header card-header-custom">
                <h4 class="mb-0 text-primary"><i class="fas fa-filter me-2"></i>Filter Laporan</h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('cashier.report') }}" class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <label class="form-label fw-bold fs-5">Pilih Tanggal Laporan</label>
                        <input type="date" class="form-control form-control-custom" name="tanggal"
                               value="{{ $tanggal }}" max="{{ now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary-custom mt-4">
                            <i class="fas fa-filter me-2"></i> Filter
                        </button>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="mt-3">
                            <span class="badge bg-primary fs-6 p-3">
                                <i class="fas fa-calendar me-2"></i>
                                {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <!-- Kolom Kiri - Ringkasan Penjualan & Grafik -->
            <div class="col-lg-8">
                <!-- Ringkasan Penjualan -->
                <div class="card card-custom">
                    <div class="card-header card-header-custom">
                        <h4 class="mb-0 text-primary">
                            <i class="fas fa-chart-line me-2"></i> Ringkasan Penjualan Harian
                        </h4>
                    </div>
                    <div class="card-body p-0">
                        <!-- Total Penjualan -->
                        <div class="summary-item bg-light">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h3 class="mb-1 text-primary">TOTAL PENJUALAN KOTOR</h3>
                                    <p class="mb-0 text-muted">Sebelum diskon dan pajak</p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <h1 class="fw-bold mb-0 text-success">
                                        Rp {{ number_format($salesData['total_penjualan_kotor'], 0, ',', '.') }}
                                    </h1>
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
                                <h3 class="fw-bold text-success mb-0">
                                    Rp {{ number_format($salesData['tunai'], 0, ',', '.') }}
                                </h3>
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
                                <h3 class="fw-bold text-primary mb-0">
                                    Rp {{ number_format($salesData['debit_kredit'], 0, ',', '.') }}
                                </h3>
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
                                <h3 class="fw-bold text-info mb-0">
                                    Rp {{ number_format($salesData['qris_ewallet'], 0, ',', '.') }}
                                </h3>
                            </div>
                        </div>

                        <!-- Summary Footer -->
                        <div class="summary-item bg-light">
                            <div class="row text-center">
                                <div class="col-md-4 border-end">
                                    <h5 class="text-muted mb-1">Total Transaksi</h5>
                                    <h2 class="fw-bold text-primary">{{ $salesData['total_transaksi'] }}</h2>
                                </div>
                                <div class="col-md-4 border-end">
                                    <h5 class="text-muted mb-1">Total Diskon</h5>
                                    <h2 class="fw-bold text-warning">Rp {{ number_format($salesData['total_diskon'], 0, ',', '.') }}</h2>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="text-muted mb-1">Pendapatan Bersih</h5>
                                    <h2 class="fw-bold text-success">Rp {{ number_format($salesData['total_bayar_bersih'], 0, ',', '.') }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grafik Penjualan -->
                <div class="card card-custom">
                    <div class="card-header card-header-custom">
                        <h4 class="mb-0 text-primary">
                            <i class="fas fa-chart-bar me-2"></i> Trend Penjualan 7 Hari Terakhir
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart" height="120"></canvas>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan - Shift Management & Statistik -->
            <div class="col-lg-4">
                <!-- Shift Management -->
                <div class="card card-custom {{ $activeShift ? 'shift-active' : 'shift-inactive' }}">
                    <div class="card-header {{ $activeShift ? 'bg-success' : 'bg-danger' }} text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-{{ $activeShift ? 'play-circle' : 'stop-circle' }} me-2"></i>
                            {{ $activeShift ? 'SHIFT AKTIF' : 'TIDAK ADA SHIFT AKTIF' }}
                        </h4>
                    </div>
                    <div class="card-body">
                        @if($activeShift)
                            <!-- Informasi Shift Aktif -->
                            <div class="alert alert-info alert-custom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Shift Aktif</strong>
                                    </div>
                                    <span class="badge bg-success fs-6">Berjalan</span>
                                </div>
                                <p class="mb-0 mt-2">
                                    <small>
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
                                <input type="text" class="form-control form-control-custom text-end bg-light"
                                       value="Rp {{ number_format($activeShift->modal_awal, 0, ',', '.') }}" readonly>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-success">
                                    <i class="fas fa-cash-register me-2"></i>Total Penerimaan Tunai (Sistem)
                                </label>
                                <input type="text" class="form-control form-control-custom text-end text-success bg-light"
                                       value="Rp {{ number_format($salesData['tunai'], 0, ',', '.') }}" readonly>
                            </div>

                            <hr>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-danger">
                                    <i class="fas fa-calculator me-2"></i>UANG FISIK DI LACI
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control form-control-custom text-end"
                                       placeholder="Masukkan jumlah uang fisik"
                                       id="kasFisikInput" min="0" step="1000">
                                <div class="form-text text-danger">Wajib diisi dengan hasil hitung fisik uang di laci kasir</div>
                            </div>

                            @php
                                $totalKasHarusAda = $activeShift->modal_awal + $salesData['tunai'];
                            @endphp

                            <div class="alert alert-warning alert-custom text-center fw-bold" id="selisihOutput">
                                <i class="fas fa-calculator me-2"></i>
                                TOTAL UANG KAS YANG HARUS ADA: Rp {{ number_format($totalKasHarusAda, 0, ',', '.') }}
                            </div>

                            <!-- Catatan Tambahan -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-sticky-note me-2"></i>Catatan Shift
                                </label>
                                <textarea class="form-control form-control-custom" id="catatanShift"
                                          placeholder="Opsional: catatan khusus untuk shift ini..."
                                          rows="3"></textarea>
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-success-custom btn-lg" id="btnTutupShift">
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
                                    <label class="form-label fw-bold fs-5">
                                        <i class="fas fa-coins me-2"></i>Modal Awal Kas
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                           class="form-control form-control-custom text-center fs-4"
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
                                    <div id="inputStatus" class="input-status d-none"></div>

                                    <button class="btn btn-success-custom btn-lg w-100 mt-3 py-3 fs-5"
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
                            <h1 class="text-primary mb-0 fw-bold">{{ $salesData['total_transaksi'] }}</h1>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="stat-card">
                            <div class="text-success mb-3">
                                <i class="fas fa-money-bill-wave fa-3x"></i>
                            </div>
                            <h5 class="text-muted mb-2">RATA-RATA TRANSAKSI</h5>
                            <h2 class="text-success mb-0 fw-bold">
                                @php
                                    $rata_rata = $salesData['total_transaksi'] > 0 ? $salesData['total_bayar_bersih'] / $salesData['total_transaksi'] : 0;
                                @endphp
                                Rp {{ number_format($rata_rata, 0, ',', '.') }}
                            </h2>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Shift -->
                <div class="card card-custom mt-4">
                    <div class="card-header card-header-custom">
                        <h4 class="mb-0 text-primary">
                            <i class="fas fa-history me-2"></i> Riwayat Shift Terakhir
                        </h4>
                    </div>
                    <div class="card-body">
                        @forelse($shiftHistory as $shift)
                            <div class="history-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="fw-bold mb-1 text-primary">
                                            {{ $shift->waktu_selesai->format('d/m H:i') }}
                                        </h6>
                                        <p class="mb-1 text-muted small">
                                            Penjualan: Rp {{ number_format($shift->total_tunai_sistem + $shift->total_debit_sistem + $shift->total_qris_sistem, 0, ',', '.') }}
                                        </p>
                                        <p class="mb-0 text-muted small">
                                            Modal: Rp {{ number_format($shift->modal_awal, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge {{ $shift->selisih == 0 ? 'bg-success' : 'bg-danger' }} fs-6">
                                            {{ $shift->selisih == 0 ? 'COCOK' : 'SELISIH' }}
                                        </span>
                                        <div class="mt-1">
                                            <small class="{{ $shift->selisih == 0 ? 'text-success' : 'text-danger' }} fw-bold">
                                                Rp {{ number_format($shift->selisih, 0, ',', '.') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <h5>Belum ada riwayat shift</h5>
                                <p class="mb-0">Mulai shift pertama Anda untuk melihat riwayat di sini</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi Chart
            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($weeklySales['labels']),
                    datasets: [{
                        label: 'Penjualan (Rp)',
                        data: @json($weeklySales['sales']),
                        borderColor: '#5E548E',
                        backgroundColor: 'rgba(94, 84, 142, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#5E548E',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    if (value >= 1000000) {
                                        return 'Rp ' + (value / 1000000).toFixed(1) + 'Jt';
                                    }
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.1)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            @if($activeShift)
            // ========== LOGIKA UNTUK SHIFT AKTIF ==========
            const modalAwal = {{ $activeShift->modal_awal }};
            const penerimaanTunaiSistem = {{ $salesData['tunai'] }};
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
                    message = `<i class="fas fa-plus me-1"></i> KELEBIHAN KAS: Rp ${selisih.toLocaleString('id-ID')}`;
                    icon = 'fas fa-plus';
                    btnTutupShift.disabled = false;
                } else {
                    alertClass = 'alert-danger';
                    message = `<i class="fas fa-minus me-1"></i> KEKURANGAN KAS: Rp ${Math.abs(selisih).toLocaleString('id-ID')}`;
                    icon = 'fas fa-minus';
                    btnTutupShift.disabled = false;
                }

                selisihOutput.className = `alert ${alertClass} alert-custom text-center fw-bold`;
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

                if (!confirm('Apakah Anda yakin ingin menutup shift? Tindakan ini tidak dapat dibatalkan.')) {
                    return;
                }

                btnTutupShift.disabled = true;
                btnTutupShift.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';

                fetch('{{ route("cashier.close-shift") }}', {
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
                        alert('Shift berhasil ditutup!\nTotal Penjualan: Rp ' + data.data.total_penjualan.toLocaleString('id-ID'));
                        window.location.reload();
                    } else {
                        alert('Gagal menutup shift: ' + data.message);
                        btnTutupShift.disabled = false;
                        btnTutupShift.innerHTML = '<i class="fas fa-lock me-2"></i> KONFIRMASI & TUTUP SHIFT';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menutup shift');
                    btnTutupShift.disabled = false;
                    btnTutupShift.innerHTML = '<i class="fas fa-lock me-2"></i> KONFIRMASI & TUTUP SHIFT';
                });
            });
            @else
            // ========== LOGIKA UNTUK MULAI SHIFT BARU ==========
            const btnMulaiShift = document.getElementById('btnMulaiShift');
            const modalAwalInput = document.getElementById('modalAwalInput');
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
                inputStatus.className = `input-status bg-${type} text-${type === 'warning' ? 'dark' : 'white'}`;
                inputStatus.classList.remove('d-none');
            }

            // Validasi input real-time
            modalAwalInput.addEventListener('input', function() {
                const numericValue = getNumericValue(this.value);

                if (numericValue === 0) {
                    updateInputStatus('❌ Masukkan modal awal kas', 'danger');
                    btnMulaiShift.disabled = true;
                } else if (numericValue < 10000) {
                    updateInputStatus(`❌ Minimal Rp 10.000 (input: Rp ${numericValue.toLocaleString('id-ID')})`, 'danger');
                    btnMulaiShift.disabled = true;
                } else {
                    updateInputStatus(`✅ Modal valid: Rp ${numericValue.toLocaleString('id-ID')}`, 'success');
                    btnMulaiShift.disabled = false;
                }
            });

            // Handle tombol mulai shift
            btnMulaiShift.addEventListener('click', function() {
                const numericValue = getNumericValue(modalAwalInput.value);

                console.log('Starting shift with modal:', numericValue);

                // Validasi final
                if (numericValue < 10000) {
                    alert('Modal awal minimal Rp 10.000');
                    modalAwalInput.focus();
                    return;
                }

                if (!confirm(`Konfirmasi mulai shift dengan modal awal:\nRp ${numericValue.toLocaleString('id-ID')}`)) {
                    return;
                }

                // UI feedback
                const originalText = btnMulaiShift.innerHTML;
                btnMulaiShift.disabled = true;
                btnMulaiShift.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memulai...';

                // Kirim request
                fetch('{{ route("cashier.start-shift") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        modal_awal: numericValue
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

            // Auto focus ke input modal
            setTimeout(() => {
                if (modalAwalInput) {
                    modalAwalInput.focus();
                }
            }, 1000);
            @endif
        });
    </script>
</body>
</html>
