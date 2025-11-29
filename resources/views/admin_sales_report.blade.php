<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Toko Saudara 2</title>
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
            --color-white: #ffffff;
            --gradient-bg: linear-gradient(135deg, #F0E6EF 0%, #D891EF 100%);
        }

        body {
            background: var(--gradient-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .admin-report-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 20px;
        }

        .report-header {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
        }

        .card-custom {
            background: white;
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .card-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: none;
            transition: all 0.3s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .filter-section {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .btn-admin {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            border: none;
            padding: 10px 25px;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(94, 84, 142, 0.3);
            color: white;
        }

        .table-custom {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .table-custom thead th {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            color: white;
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .payment-method-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .badge-tunai { background: linear-gradient(135deg, #28a745, #20c997); color: white; }
        .badge-debit { background: linear-gradient(135deg, #007bff, #0056b3); color: white; }
        .badge-qris { background: linear-gradient(135deg, #17a2b8, #138496); color: white; }

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

        @media (max-width: 768px) {
            .content-wrapper {
                margin-left: 0;
                padding: 15px;
            }

            .summary-grid {
                grid-template-columns: 1fr;
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

        <div class="content-wrapper">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%); border-radius: 10px; margin-bottom: 20px;">
                <div class="container-fluid">
                    <a class="navbar-brand fw-bold" href="#">
                        <i class="fas fa-chart-bar me-2"></i>TOKO SAUDARA 2 - Laporan Penjualan Admin
                    </a>
                    <div class="navbar-nav ms-auto">
                        <span class="navbar-text">
                            <i class="fas fa-user me-1"></i>{{ Auth::user()->name }} (Admin)
                        </span>
                    </div>
                </div>
            </nav>

            <!-- Content -->
            <div class="admin-report-container">
                <!-- Header -->
                <div class="report-header">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="mb-2"><i class="fas fa-chart-line me-3"></i>LAPORAN PENJUALAN</h1>
                            <p class="mb-0 opacity-75 fs-5">Dashboard Analisis Penjualan Menyeluruh</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="btn-group">
                                <a href="{{ route('admin.dashboard') ?: route('dashboard.staff') }}" class="btn btn-light btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i> Dashboard
                                </a>
                                <button class="btn btn-outline-light btn-lg" onclick="window.print()">
                                    <i class="fas fa-print me-2"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="filter-section">
                    <form method="GET" action="{{ route('cashier.report') }}" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="start_date"
                                   value="{{ $startDate }}" max="{{ now()->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Tanggal Akhir</label>
                            <input type="date" class="form-control" name="end_date"
                                   value="{{ $endDate }}" max="{{ now()->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Kasir</label>
                            <select class="form-select" name="cashier_id">
                                <option value="">Semua Kasir</option>
                                @foreach($cashiers as $cashier)
                                    <option value="{{ $cashier->id }}" {{ $cashierId == $cashier->id ? 'selected' : '' }}>
                                        {{ $cashier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-admin w-100">
                                <i class="fas fa-filter me-2"></i> Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Summary Cards -->
                <div class="summary-grid">
                    <div class="stat-card">
                        <div class="text-primary mb-3">
                            <i class="fas fa-money-bill-wave fa-3x"></i>
                        </div>
                        <h5 class="text-muted mb-2">TOTAL PENJUALAN</h5>
                        <h2 class="text-primary mb-0 fw-bold">
                            Rp {{ number_format($summaryData->total_penjualan_bersih ?? 0, 0, ',', '.') }}
                        </h2>
                        <small class="text-muted">Penjualan bersih setelah diskon</small>
                    </div>

                    <div class="stat-card">
                        <div class="text-success mb-3">
                            <i class="fas fa-shopping-cart fa-3x"></i>
                        </div>
                        <h5 class="text-muted mb-2">TOTAL TRANSAKSI</h5>
                        <h2 class="text-success mb-0 fw-bold">{{ $summaryData->total_transaksi ?? 0 }}</h2>
                        <small class="text-muted">Jumlah transaksi berhasil</small>
                    </div>

                    <div class="stat-card">
                        <div class="text-info mb-3">
                            <i class="fas fa-chart-bar fa-3x"></i>
                        </div>
                        <h5 class="text-muted mb-2">PENJUALAN KOTOR</h5>
                        <h2 class="text-info mb-0 fw-bold">
                            Rp {{ number_format($summaryData->total_penjualan_kotor ?? 0, 0, ',', '.') }}
                        </h2>
                        <small class="text-muted">Sebelum diskon</small>
                    </div>

                    <div class="stat-card">
                        <div class="text-warning mb-3">
                            <i class="fas fa-tag fa-3x"></i>
                        </div>
                        <h5 class="text-muted mb-2">TOTAL DISKON</h5>
                        <h2 class="text-warning mb-0 fw-bold">
                            Rp {{ number_format($summaryData->total_diskon ?? 0, 0, ',', '.') }}
                        </h2>
                        <small class="text-muted">Diskon yang diberikan</small>
                    </div>

                    <div class="stat-card">
                        <div class="text-secondary mb-3">
                            <i class="fas fa-calculator fa-3x"></i>
                        </div>
                        <h5 class="text-muted mb-2">RATA-RATA TRANSAKSI</h5>
                        <h2 class="text-secondary mb-0 fw-bold">
                            Rp {{ number_format($summaryData->rata_rata_transaksi ?? 0, 0, ',', '.') }}
                        </h2>
                        <small class="text-muted">Nilai rata-rata per transaksi</small>
                    </div>
                </div>

                <div class="row">
                    <!-- Grafik Penjualan -->
                    <div class="col-lg-8">
                        <div class="chart-container">
                            <h4 class="mb-4 text-primary">
                                <i class="fas fa-chart-line me-2"></i>Trend Penjualan Harian
                            </h4>
                            <canvas id="salesChart" height="300"></canvas>
                        </div>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="col-lg-4">
                        <div class="chart-container">
                            <h4 class="mb-4 text-primary">
                                <i class="fas fa-credit-card me-2"></i>Metode Pembayaran
                            </h4>
                            <canvas id="paymentChart" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Shift -->
                <div class="card-custom mt-4">
                    <div class="card-body">
                        <h4 class="mb-4 text-primary">
                            <i class="fas fa-history me-2"></i>Riwayat Shift Terakhir
                        </h4>
                        <div class="table-responsive">
                            <table class="table table-hover table-custom">
                                <thead>
                                    <tr>
                                        <th>Kasir</th>
                                        <th>Waktu</th>
                                        <th>Modal Awal</th>
                                        <th>Penjualan Tunai</th>
                                        <th>Uang Fisik</th>
                                        <th>Selisih</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($allShiftHistory as $shift)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-user me-2 text-muted"></i>
                                                    {{ $shift->nama_kasir }}
                                                </div>
                                            </td>
                                            <td>{{ $shift->waktu_selesai->format('d/m/Y H:i') }}</td>
                                            <td>Rp {{ number_format($shift->modal_awal, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($shift->total_tunai_sistem, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($shift->uang_fisik_di_kasir, 0, ',', '.') }}</td>
                                            <td class="{{ $shift->selisih == 0 ? 'text-success' : 'text-danger' }} fw-bold">
                                                Rp {{ number_format($shift->selisih, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                <span class="badge {{ $shift->selisih == 0 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $shift->selisih == 0 ? 'COCOK' : 'SELISIH' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">
                                                <i class="fas fa-inbox fa-2x mb-3"></i>
                                                <h5>Belum ada riwayat shift</h5>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Grafik Penjualan
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: @json($dailySalesData['labels']),
                    datasets: [
                        {
                            label: 'Penjualan (Rp)',
                            data: @json($dailySalesData['sales']),
                            borderColor: '#5E548E',
                            backgroundColor: 'rgba(94, 84, 142, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Jumlah Transaksi',
                            data: @json($dailySalesData['transactions']),
                            borderColor: '#70C1B3',
                            backgroundColor: 'rgba(112, 193, 179, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false
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

            // Grafik Metode Pembayaran
            const paymentCtx = document.getElementById('paymentChart').getContext('2d');
            const paymentData = @json($paymentMethodData);

            const paymentLabels = paymentData.map(item => {
                const methods = {
                    'tunai': 'Tunai',
                    'debit_kredit': 'Debit/Kredit',
                    'qris_ewallet': 'QRIS/E-Wallet'
                };
                return methods[item.metode_pembayaran] || item.metode_pembayaran;
            });

            const paymentTotals = paymentData.map(item => item.total);
            const paymentColors = ['#28a745', '#007bff', '#17a2b8'];

            const paymentChart = new Chart(paymentCtx, {
                type: 'doughnut',
                data: {
                    labels: paymentLabels,
                    datasets: [{
                        data: paymentTotals,
                        backgroundColor: paymentColors,
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: Rp ${value.toLocaleString('id-ID')} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
