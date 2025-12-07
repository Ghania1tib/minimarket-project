@extends('layouts.admin-base')

@section('title', 'Manajemen Pesanan')

@section('content')
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h2 class="section-title mb-0">
                                    <i class="fas fa-clipboard-list me-2"></i>Manajemen Pesanan
                                </h2>
                                <p class="text-muted mb-0">Kelola semua pesanan dari customer</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="text-muted">
                                    <i class="fas fa-shopping-cart me-1"></i>
                                    Total: <strong>{{ $totalOrders }}</strong> pesanan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

 <!-- Filter Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-filter me-2"></i>Filter Pesanan
                    </h5>

                    <!-- Reset Filter Button (ikon silang) -->
                    @if($status != 'all' || $tipe != 'all' || $search)
                        <a href="{{ route('payment.verification.orders.index') }}"
                           class="btn btn-outline-danger btn-sm"
                           data-bs-toggle="tooltip"
                           title="Reset Semua Filter">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>

                <form action="{{ route('payment.verification.orders.index') }}" method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Status Pesanan</label>
                            <select name="status" class="form-select search-box">
                                @foreach($statusOptions as $value => $label)
                                    <option value="{{ $value }}" {{ $status == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Tipe Pesanan</label>
                            <select name="tipe" class="form-select search-box">
                                @foreach($tipeOptions as $value => $label)
                                    <option value="{{ $value }}" {{ $tipe == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Pencarian</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-2 var(--color-accent)">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control search-box"
                                       placeholder="Cari no. pesanan, nama, telepon..." value="{{ $search }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-1"></i>Terapkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        <!-- Filter Summary -->
        @if ($status != 'all' || $tipe != 'all')
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-info d-flex align-items-center">
                        <i class="fas fa-info-circle me-3"></i>
                        <div>
                            Menampilkan <strong>{{ $totalOrders }}</strong> pesanan
                            @if ($status != 'all')
                                dengan status <strong>{{ $statusOptions[$status] }}</strong>
                            @endif
                            @if ($tipe != 'all')
                                @if ($status != 'all')
                                    dan
                                @else
                                    dengan
                                @endif tipe <strong>{{ $tipeOptions[$tipe] }}</strong>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Orders Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No. Pesanan</th>
                                            <th>Customer</th>
                                            <th>Tipe</th>
                                            <th>Total</th>
                                            <th>Status Pesanan</th>
                                            <th>Status Bayar</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="order-number-badge me-3">
                                                            <i class="fas fa-receipt"></i>
                                                        </div>
                                                        <div>
                                                            <strong>{{ $order->order_number }}</strong>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="customer-info">
                                                        <strong>{{ $order->nama_lengkap }}</strong>
                                                        <div class="text-muted small">{{ $order->no_telepon }}</div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($order->tipe_pesanan == 'website')
                                                        <span class="badge badge-online rounded-pill p-2">
                                                            <i class="fas fa-globe me-1"></i>Online
                                                        </span>
                                                    @else
                                                        <span class="badge badge-pos rounded-pill p-2">
                                                            <i class="fas fa-store me-1"></i>POS
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-success fw-bold">
                                                    Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    @php
                                                        $statusLabels = [
                                                            'pending' => ['class' => 'pending', 'label' => 'Pending'],
                                                            'menunggu_pembayaran' => [
                                                                'class' => 'waiting-payment',
                                                                'label' => 'Menunggu Pembayaran',
                                                            ],
                                                            'menunggu_verifikasi' => [
                                                                'class' => 'waiting-verification',
                                                                'label' => 'Menunggu Verifikasi',
                                                            ],
                                                            'diproses' => [
                                                                'class' => 'processing',
                                                                'label' => 'Diproses',
                                                            ],
                                                            'dikirim' => ['class' => 'shipping', 'label' => 'Dikirim'],
                                                            'selesai' => ['class' => 'completed', 'label' => 'Selesai'],
                                                            'dibatalkan' => [
                                                                'class' => 'cancelled',
                                                                'label' => 'Dibatalkan',
                                                            ],
                                                        ];
                                                        $statusInfo = $statusLabels[$order->status_pesanan] ?? [
                                                            'class' => 'secondary',
                                                            'label' => $order->status_pesanan,
                                                        ];
                                                    @endphp
                                                    <span class="badge badge-{{ $statusInfo['class'] }} rounded-pill p-2">
                                                        {{ $statusInfo['label'] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($order->status_pembayaran == 'menunggu_verifikasi')
                                                        <span class="badge rounded-pill p-2"
                                                            style="background-color: #FFB347; color: #000000;">
                                                            <i class="fas fa-clock me-1"></i>Menunggu Verifikasi
                                                        </span>
                                                    @elseif($order->status_pembayaran == 'terverifikasi')
                                                        <span class="badge rounded-pill p-2"
                                                            style="background-color: #70C1B3; color: #ffffff;">
                                                            <i class="fas fa-check me-1"></i>Terverifikasi
                                                        </span>
                                                    @elseif($order->status_pembayaran == 'ditolak')
                                                        <span class="badge rounded-pill p-2"
                                                            style="background-color: #E07A5F; color: #ffffff;">
                                                            <i class="fas fa-times me-1"></i>Ditolak
                                                        </span>
                                                    @else
                                                        <span class="badge rounded-pill p-2"
                                                            style="background-color: #6c757d; color: #ffffff;">
                                                            {{ $order->status_pembayaran }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="date-info">
                                                        <div>{{ $order->created_at->format('d/m/Y') }}</div>
                                                        <small
                                                            class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ route('payment.verification.orders.show', $order->id) }}"
                                                            class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
                                                            title="Detail Pesanan">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @if ($order->tipe_pesanan == 'website' && $order->status_pembayaran == 'menunggu_verifikasi')
                                                            <a href="{{ route('payment.verification.show', $order->id) }}"
                                                                class="btn btn-warning btn-sm" data-bs-toggle="tooltip"
                                                                title="Verifikasi Pembayaran">
                                                                <i class="fas fa-check-circle"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="pagination-container">
                                <div class="pagination-info">
                                    Menampilkan {{ $orders->firstItem() }} - {{ $orders->lastItem() }} dari
                                    {{ $orders->total() }} pesanan
                                </div>

                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <!-- Previous Page Link -->
                                        @if ($orders->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">Sebelumnya</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $orders->previousPageUrl() }}"
                                                    rel="prev">Sebelumnya</a>
                                            </li>
                                        @endif

                                        <!-- Pagination Elements -->
                                        @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                            @if ($page == $orders->currentPage())
                                                <li class="page-item active">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link"
                                                        href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endforeach

                                        <!-- Next Page Link -->
                                        @if ($orders->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $orders->nextPageUrl() }}"
                                                    rel="next">Selanjutnya</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">Selanjutnya</span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-clipboard-list fa-4x"></i>
                                <h4>Tidak ada pesanan ditemukan</h4>
                                <p class="text-muted">Coba ubah filter pencarian Anda.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Variabel CSS konsisten dengan halaman lainnya */
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
        }

        .card {
            border-radius: var(--border-radius-lg);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: none;
            background: var(--color-white);
        }

        .card-body {
            padding: 1.5rem;
        }

        .btn-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            border-radius: var(--border-radius-sm);
            padding: 8px 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(94, 84, 142, 0.3);
        }

        .btn-warning {
            background-color: var(--color-warning);
            border-color: var(--color-warning);
            color: white;
        }

        .btn-warning:hover {
            background-color: #FFA133;
            border-color: #FFA133;
        }

        .section-title {
            color: var(--color-primary);
            font-weight: 700;
            margin-bottom: 0.5rem;
            border-left: 4px solid var(--color-accent);
            padding-left: 15px;
        }

        .search-box {
            border-radius: var(--border-radius-sm);
            border: 2px solid var(--color-accent);
            padding: 8px 15px;
            transition: all 0.3s ease;
        }

        .search-box:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 0.2rem rgba(224, 177, 203, 0.25);
        }

        .input-group .search-box {
            border-left: none;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .input-group-text {
            background-color: transparent;
            border-right: none;
            border: 2px solid var(--color-accent);
            border-right: none;
            border-radius: var(--border-radius-sm) 0 0 var(--border-radius-sm);
        }

        /* Badge Styles */
        .badge-online {
            background-color: var(--color-info);
            color: white;
        }

        .badge-pos {
            background-color: var(--color-secondary);
            color: white;
        }

        .badge-pending {
            background-color: #6c757d;
            color: white;
        }

        .badge-waiting-payment {
            background-color: var(--color-warning);
            color: white;
        }

        .badge-waiting-verification {
            background-color: var(--color-info);
            color: white;
        }

        .badge-processing {
            background-color: var(--color-primary);
            color: white;
        }

        .badge-shipping {
            background-color: #5BC0DE;
            color: white;
        }

        .badge-completed {
            background-color: var(--color-success);
            color: white;
        }

        .badge-cancelled {
            background-color: var(--color-danger);
            color: white;
        }

        .badge-waiting {
            background-color: var(--color-warning);
            color: white;
        }

        .badge-verified {
            background-color: var(--color-success);
            color: white;
        }

        .badge-rejected {
            background-color: var(--color-danger);
            color: white;
        }

        .badge {
            font-weight: 500;
            letter-spacing: 0.3px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Table Styles */
        .table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 0;
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

        /* Customer Info */
        .customer-info {
            line-height: 1.3;
        }

        /* Order Number Badge */
        .order-number-badge {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-accent) 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        /* Date Info */
        .date-info {
            line-height: 1.3;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .action-buttons .btn {
            border-radius: 6px;
            transition: all 0.3s ease;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: var(--color-accent);
        }

        .empty-state h3 {
            color: var(--color-primary);
            margin-bottom: 0.5rem;
        }

        /* Alert Styles */
        .alert-info {
            background-color: rgba(91, 192, 222, 0.1);
            border-color: rgba(91, 192, 222, 0.2);
            color: #0c5460;
            border-radius: var(--border-radius-sm);
        }

        .alert-info i {
            color: var(--color-info);
        }

        /* Pagination Styles */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .pagination-info {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .pagination {
            margin: 0;
        }

        .page-link {
            color: var(--color-primary);
            border: 1px solid var(--color-accent);
            padding: 8px 16px;
            margin: 0 2px;
            border-radius: var(--border-radius-sm);
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background-color: var(--color-primary);
            color: white;
            border-color: var(--color-primary);
        }

        .page-item.active .page-link {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            border-color: #dee2e6;
        }

        /* Card Title */
        .card-title {
            color: var(--color-primary);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        /* Form Styles */
        .form-label {
            color: var(--color-primary);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-select {
            border-radius: var(--border-radius-sm);
            border: 2px solid var(--color-accent);
            padding: 8px 15px;
            transition: all 0.3s ease;
        }

        .form-select:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 0.2rem rgba(224, 177, 203, 0.25);
        }
        /* Style untuk reset filter button */
.btn-outline-danger {
    border: 2px solid #E07A5F;
    color: #E07A5F;
    border-radius: var(--border-radius-sm);
    transition: all 0.3s ease;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
}

.btn-outline-danger:hover {
    background-color: #E07A5F;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 3px 10px rgba(224, 122, 95, 0.2);
}

/* Header filter section */
.card-title {
    display: flex;
    align-items: center;
}

/* Responsive adjustment */
@media (max-width: 768px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 10px;
    }

    .btn-outline-danger {
        align-self: flex-end;
        margin-top: -40px;
    }
}

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .pagination-container {
                flex-direction: column;
                gap: 15px;
            }

            .row.g-3 {
                margin-bottom: -0.75rem;
            }

            .row.g-3>div {
                margin-bottom: 0.75rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-buttons .btn {
                width: 100%;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Auto-submit filters on change (optional)
            document.querySelectorAll('.form-select').forEach(select => {
                select.addEventListener('change', function() {
                    // Optionally auto-submit when filters change
                    // this.form.submit();
                });
            });
        });
    </script>
@endsection
