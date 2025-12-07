@extends('layouts.admin-base')

@section('title', 'Verifikasi Pembayaran')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="section-title mb-0">
                                <i class="fas fa-money-check-alt me-2"></i>Verifikasi Pembayaran
                            </h2>
                            <p class="text-muted mb-0">Kelola dan verifikasi pembayaran pesanan customer</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Total: {{ $orders->total() }} pesanan
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Status -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Filter Status Pembayaran</h5>
                            <div class="btn-group" role="group">
                                <a href="{{ route('payment.verification.index', ['status' => 'menunggu_verifikasi']) }}"
                                   class="btn btn-{{ $status == 'menunggu_verifikasi' ? 'primary' : 'outline-primary' }}">
                                    <i class="fas fa-clock me-1"></i>Menunggu Verifikasi
                                    <span class="badge bg-danger ms-1">
                                        {{ \App\Models\Order::where('status_pembayaran', 'menunggu_verifikasi')->where('tipe_pesanan', 'website')->count() }}
                                    </span>
                                </a>
                                <a href="{{ route('payment.verification.index', ['status' => 'semua']) }}"
                                   class="btn btn-{{ $status == 'semua' ? 'primary' : 'outline-primary' }}">
                                    <i class="fas fa-list me-1"></i>Semua Status
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Pesanan -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if($orders->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No. Pesanan</th>
                                                <th>Customer</th>
                                                <th>Total</th>
                                                <th>Metode Bayar</th>
                                                <th>Status</th>
                                                <th>Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
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
                                                <td class="text-success fw-bold">
                                                    Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    @if($order->metode_pembayaran == 'transfer')
                                                        <span class="badge badge-transfer rounded-pill p-2">
                                                            <i class="fas fa-university me-1"></i>Transfer
                                                        </span>
                                                    @else
                                                        <span class="badge badge-cash rounded-pill p-2">
                                                            <i class="fas fa-money-bill-wave me-1"></i>{{ ucfirst($order->metode_pembayaran) }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($order->status_pembayaran == 'menunggu_verifikasi')
                                                        <span class="badge badge-waiting rounded-pill p-2">
                                                            <i class="fas fa-clock me-1"></i>Menunggu Verifikasi
                                                        </span>
                                                    @elseif($order->status_pembayaran == 'terverifikasi')
                                                        <span class="badge badge-verified rounded-pill p-2">
                                                            <i class="fas fa-check me-1"></i>Terverifikasi
                                                        </span>
                                                    @elseif($order->status_pembayaran == 'ditolak')
                                                        <span class="badge badge-rejected rounded-pill p-2">
                                                            <i class="fas fa-times me-1"></i>Ditolak
                                                        </span>
                                                    @else
                                                        <span class="badge badge-secondary rounded-pill p-2">{{ $order->status_pembayaran }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="date-info">
                                                        <div>{{ $order->created_at->format('d/m/Y') }}</div>
                                                        <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ route('payment.verification.show', $order->id) }}"
                                                           class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="Detail Verifikasi">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
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
                                        Menampilkan {{ $orders->firstItem() }} - {{ $orders->lastItem() }} dari {{ $orders->total() }} pesanan
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
                                                    <a class="page-link" href="{{ $orders->previousPageUrl() }}" rel="prev">Sebelumnya</a>
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
                                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                    </li>
                                                @endif
                                            @endforeach

                                            <!-- Next Page Link -->
                                            @if ($orders->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $orders->nextPageUrl() }}" rel="next">Selanjutnya</a>
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
                                    <i class="fas fa-check-circle fa-4x"></i>
                                    <h4>Tidak ada pesanan yang perlu diverifikasi</h4>
                                    <p class="text-muted">Semua pembayaran sudah terverifikasi.</p>
                                    <a href="{{ route('payment.verification.index', ['status' => 'semua']) }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-list me-2"></i>Lihat Semua Pesanan
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Variabel CSS konsisten dengan halaman user */
    :root {
        --color-primary: #5E548E;
        --color-secondary: #9F86C0;
        --color-accent: #E0B1CB;
        --color-danger: #E07A5F;
        --color-success: #70C1B3;
        --color-warning: #FFB347;
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

    .btn-outline-primary {
        border: 2px solid var(--color-primary);
        color: var(--color-primary);
        border-radius: var(--border-radius-sm);
        font-weight: 600;
        padding: 8px 16px;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background: var(--color-primary);
        color: white;
        transform: translateY(-2px);
    }

    .btn-group .btn {
        padding: 10px 20px;
    }

    .btn-sm {
        padding: 5px 10px;
        border-radius: 6px;
    }

    .section-title {
        color: var(--color-primary);
        font-weight: 700;
        margin-bottom: 0.5rem;
        border-left: 4px solid var(--color-accent);
        padding-left: 15px;
    }

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

    /* Badge Styles */
    .badge-transfer {
        background-color: var(--color-primary);
        color: white;
    }

    .badge-cash {
        background-color: var(--color-success);
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
    }

    .bg-danger {
        background-color: var(--color-danger) !important;
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
    .action-buttons .btn {
        margin: 2px;
        border-radius: 6px;
        transition: all 0.3s ease;
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
        color: var(--color-success);
    }

    .empty-state h4 {
        color: var(--color-primary);
        margin-bottom: 0.5rem;
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

    /* Text Colors */
    .text-muted {
        color: #6c757d !important;
    }

    .text-success {
        color: var(--color-success) !important;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .pagination-container {
            flex-direction: column;
            gap: 15px;
        }

        .btn-group {
            flex-wrap: wrap;
            gap: 5px;
        }

        .btn-group .btn {
            flex: 1;
            min-width: 150px;
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
    });
</script>
@endsection
