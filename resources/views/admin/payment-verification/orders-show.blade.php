@extends('layouts.admin-base')

@section('title', 'Detail Pesanan - ' . $order->order_number)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="section-title mb-0">
                                <i class="fas fa-clipboard-list me-2"></i>Detail Pesanan
                            </h2>
                            <p class="text-muted mb-0">No. Pesanan: <strong>{{ $order->order_number }}</strong></p>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="action-buttons">
                                <a href="{{ route('payment.verification.orders.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                @if($order->tipe_pesanan == 'website' && $order->status_pembayaran == 'menunggu_verifikasi')
                                    <a href="{{ route('payment.verification.show', $order->id) }}" class="btn btn-warning">
                                        <i class="fas fa-check-circle me-2"></i>Verifikasi
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Kolom Kiri - Informasi Utama -->
        <div class="col-lg-8">
            <!-- Informasi Pesanan -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-info-circle me-2"></i>Informasi Pesanan
                    </h5>

                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <div class="info-section">
                                <h6 class="info-title">Informasi Customer</h6>
                                <div class="info-item">
                                    <span class="info-label">No. Pesanan</span>
                                    <span class="info-value">{{ $order->order_number }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Customer</span>
                                    <span class="info-value">{{ $order->nama_lengkap }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Telepon</span>
                                    <span class="info-value">{{ $order->no_telepon }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Alamat</span>
                                    <span class="info-value">{{ $order->alamat }}, {{ $order->kota }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <div class="info-section">
                                <h6 class="info-title">Status & Pembayaran</h6>
                                <div class="info-item">
                                    <span class="info-label">Tanggal</span>
                                    <span class="info-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Tipe Pesanan</span>
                                    <span class="info-value">
                                        @if($order->tipe_pesanan == 'website')
                                            <span class="badge badge-online rounded-pill">
                                                <i class="fas fa-globe me-1"></i>Online
                                            </span>
                                        @else
                                            <span class="badge badge-pos rounded-pill">
                                                <i class="fas fa-store me-1"></i>POS
                                            </span>
                                        @endif
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Metode Bayar</span>
                                    <span class="info-value">
                                        <span class="badge badge-payment rounded-pill">
                                            {{ strtoupper($order->metode_pembayaran) }}
                                        </span>
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Status Pesanan</span>
                                    <span class="info-value">
                                        @php
                                            $statusLabels = [
                                                'pending' => ['class' => 'pending', 'label' => 'Pending'],
                                                'menunggu_pembayaran' => ['class' => 'waiting-payment', 'label' => 'Menunggu Pembayaran'],
                                                'menunggu_verifikasi' => ['class' => 'waiting-verification', 'label' => 'Menunggu Verifikasi'],
                                                'diproses' => ['class' => 'processing', 'label' => 'Diproses'],
                                                'dikirim' => ['class' => 'shipping', 'label' => 'Dikirim'],
                                                'selesai' => ['class' => 'completed', 'label' => 'Selesai'],
                                                'dibatalkan' => ['class' => 'cancelled', 'label' => 'Dibatalkan']
                                            ];
                                            $statusInfo = $statusLabels[$order->status_pesanan] ?? ['class' => 'secondary', 'label' => $order->status_pesanan];
                                        @endphp
                                        <span class="badge badge-{{ $statusInfo['class'] }} rounded-pill">
                                            {{ $statusInfo['label'] }}
                                        </span>
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Status Pembayaran</span>
                                    <span class="info-value">
                                        @if($order->status_pembayaran == 'menunggu_verifikasi')
                                            <span class="badge badge-waiting rounded-pill">
                                                <i class="fas fa-clock me-1"></i>Menunggu Verifikasi
                                            </span>
                                        @elseif($order->status_pembayaran == 'terverifikasi')
                                            <span class="badge badge-verified rounded-pill">
                                                <i class="fas fa-check me-1"></i>Terverifikasi
                                            </span>
                                        @elseif($order->status_pembayaran == 'ditolak')
                                            <span class="badge badge-rejected rounded-pill">
                                                <i class="fas fa-times me-1"></i>Ditolak
                                            </span>
                                        @else
                                            <span class="badge badge-secondary rounded-pill">
                                                {{ $order->status_pembayaran }}
                                            </span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Pesanan -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-shopping-cart me-2"></i>Items Pesanan
                    </h5>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->product->nama_produk }}</td>
                                    <td class="text-center">Rp {{ number_format($item->harga_saat_beli, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">Rp {{ number_format($item->harga_saat_beli * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-total">
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                    <td class="text-end"><strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Ongkos Kirim:</strong></td>
                                    <td class="text-end"><strong>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr class="total-row">
                                    <td colspan="3" class="text-end"><strong>Total Bayar:</strong></td>
                                    <td class="text-end"><strong class="text-success">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Update Status Pesanan -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-sync-alt me-2"></i>Update Status Pesanan
                    </h5>

                    <form action="{{ route('payment.verification.orders.update-status', $order->id) }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status_pesanan" class="form-label">Status Pesanan</label>
                                    <select name="status_pesanan" id="status_pesanan" class="form-select search-box" required>
                                        <option value="pending" {{ $order->status_pesanan == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="menunggu_pembayaran" {{ $order->status_pesanan == 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                        <option value="menunggu_verifikasi" {{ $order->status_pesanan == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                        <option value="diproses" {{ $order->status_pesanan == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="dikirim" {{ $order->status_pesanan == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                        <option value="selesai" {{ $order->status_pesanan == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="dibatalkan" {{ $order->status_pesanan == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="catatan_status" class="form-label">Catatan Status</label>
                                    <textarea name="catatan_status" id="catatan_status" rows="3" class="form-control search-box" placeholder="Tambahkan catatan...">{{ $order->catatan }}</textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan - Sidebar -->
        <div class="col-lg-4">
            <!-- Timeline Status -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-history me-2"></i>Timeline Status
                    </h5>

                    <div class="timeline">
                        @foreach($statusHistory as $history)
                        <div class="timeline-item {{ $history['active'] ? 'active' : '' }}">
                            <div class="timeline-marker">
                                <i class="{{ $history['icon'] }}"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">{{ $history['status'] }}</h6>
                                <small class="text-muted">{{ $history['tanggal']->format('d/m/Y H:i') }}</small>
                                @if(!empty($history['catatan']))
                                    <p class="mb-0 small">{{ $history['catatan'] }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Informasi Pengiriman (hanya untuk online) -->
            @if($order->tipe_pesanan == 'website')
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-truck me-2"></i>Informasi Pengiriman
                    </h5>

                    <form action="{{ route('payment.verification.orders.update-shipping', $order->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="metode_pengiriman" class="form-label">Metode Pengiriman</label>
                            <select name="metode_pengiriman" id="metode_pengiriman" class="form-select search-box" required>
                                <option value="reguler" {{ $order->metode_pengiriman == 'reguler' ? 'selected' : '' }}>Reguler</option>
                                <option value="express" {{ $order->metode_pengiriman == 'express' ? 'selected' : '' }}>Express</option>
                                <option value="ambil_ditempat" {{ $order->metode_pengiriman == 'ambil_ditempat' ? 'selected' : '' }}>Ambil di Tempat</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="catatan_pengiriman" class="form-label">Catatan Pengiriman</label>
                            <textarea name="catatan_pengiriman" id="catatan_pengiriman" rows="3" class="form-control search-box" placeholder="Tambahkan catatan pengiriman...">{{ $order->catatan }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-truck me-2"></i>Update Pengiriman
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <!-- Ringkasan Pembayaran -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-receipt me-2"></i>Ringkasan Pembayaran
                    </h5>

                    <div class="summary-list">
                        <div class="summary-item">
                            <span class="summary-label">Subtotal</span>
                            <span class="summary-value">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Diskon</span>
                            <span class="summary-value">- Rp {{ number_format($order->total_diskon, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Ongkos Kirim</span>
                            <span class="summary-value">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-item total">
                            <span class="summary-label">Total Bayar</span>
                            <span class="summary-value total-amount">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Variabel CSS konsisten */
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
    --border-radius-lg: 15px;
    --border-radius-sm: 8px;
}

body {
    background: linear-gradient(135deg, #F0E6EF 0%, #D891EF 100%);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    min-height: 100vh;
}

/* Card Styling */
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

/* Card Title */
.card-title {
    color: var(--color-primary);
    font-weight: 600;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
}

/* Button Styling */
.btn-primary {
    background-color: var(--color-primary);
    border-color: var(--color-primary);
    border-radius: var(--border-radius-sm);
    padding: 8px 20px;
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
    color: #000;
    font-weight: 600;
}

.btn-warning:hover {
    background-color: #FFA133;
    border-color: #FFA133;
    color: #000;
}

.btn-outline-primary {
    border: 2px solid var(--color-primary);
    color: var(--color-primary);
    border-radius: var(--border-radius-sm);
    padding: 8px 20px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: var(--color-primary);
    color: white;
    transform: translateY(-2px);
}

.action-buttons {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

/* Badge Styling */
.badge {
    font-weight: 500;
    letter-spacing: 0.3px;
    padding: 6px 12px !important;
    font-size: 0.85rem !important;
}

.rounded-pill {
    border-radius: 50px !important;
}

.badge-online {
    background-color: var(--color-info) !important;
    color: white !important;
}

.badge-pos {
    background-color: var(--color-secondary) !important;
    color: white !important;
}

.badge-payment {
    background-color: var(--color-accent) !important;
    color: #000 !important;
}

.badge-pending {
    background-color: #6c757d !important;
    color: white !important;
}

.badge-waiting-payment {
    background-color: var(--color-warning) !important;
    color: #000 !important;
}

.badge-waiting-verification {
    background-color: var(--color-info) !important;
    color: white !important;
}

.badge-processing {
    background-color: var(--color-primary) !important;
    color: white !important;
}

.badge-shipping {
    background-color: #5BC0DE !important;
    color: white !important;
}

.badge-completed {
    background-color: var(--color-success) !important;
    color: white !important;
}

.badge-cancelled {
    background-color: var(--color-danger) !important;
    color: white !important;
}

.badge-waiting {
    background-color: var(--color-warning) !important;
    color: #000 !important;
}

.badge-verified {
    background-color: var(--color-success) !important;
    color: white !important;
}

.badge-rejected {
    background-color: var(--color-danger) !important;
    color: white !important;
}

.badge-secondary {
    background-color: #6c757d !important;
    color: white !important;
}

/* Info Section Styling */
.info-section {
    background: #f8f9fa;
    border-radius: var(--border-radius-sm);
    padding: 1.25rem;
    margin-bottom: 1rem;
}

.info-title {
    color: var(--color-primary);
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--color-accent);
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    color: #6c757d;
    font-weight: 500;
    font-size: 0.9rem;
}

.info-value {
    color: var(--color-primary);
    font-weight: 600;
    text-align: right;
    max-width: 60%;
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
    padding: 12px 15px;
    font-weight: 600;
}

.table tbody td {
    padding: 12px 15px;
    vertical-align: middle;
    border-color: #e9ecef;
}

.table tbody tr {
    transition: all 0.3s ease;
}

.table tbody tr:hover {
    background-color: rgba(224, 177, 203, 0.1);
}

.table-total tr {
    background-color: #f8f9fa;
}

.table-total td {
    padding: 10px 15px;
    font-weight: 600;
}

.total-row td {
    background-color: rgba(112, 193, 179, 0.1);
    border-top: 2px solid var(--color-success);
}

/* Form Styling */
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

.form-label {
    color: var(--color-primary);
    font-weight: 500;
    margin-bottom: 0.5rem;
}

/* Timeline Styling */
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline:before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--color-accent);
}

.timeline-item {
    position: relative;
    margin-bottom: 1.5rem;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: var(--color-accent);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    z-index: 1;
}

.timeline-item.active .timeline-marker {
    background: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(94, 84, 142, 0.2);
}

.timeline-content {
    background: #f8f9fa;
    border-radius: var(--border-radius-sm);
    padding: 1rem;
    border-left: 3px solid var(--color-accent);
}

.timeline-item.active .timeline-content {
    background: rgba(94, 84, 142, 0.05);
    border-left-color: var(--color-primary);
}

.timeline-content h6 {
    color: var(--color-primary);
    font-weight: 600;
    margin-bottom: 0.25rem;
}

/* Summary Styling */
.summary-list {
    background: #f8f9fa;
    border-radius: var(--border-radius-sm);
    padding: 1rem;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.summary-item:last-child {
    border-bottom: none;
}

.summary-label {
    color: #6c757d;
    font-weight: 500;
}

.summary-value {
    color: var(--color-primary);
    font-weight: 600;
}

.summary-item.total {
    background: rgba(112, 193, 179, 0.1);
    margin: 10px -1rem -1rem;
    padding: 15px 1rem;
    border-radius: 0 0 var(--border-radius-sm) var(--border-radius-sm);
}

.summary-item.total .summary-label {
    color: var(--color-primary);
    font-size: 1.1rem;
}

.summary-item.total .summary-value {
    color: var(--color-success);
    font-size: 1.2rem;
    font-weight: 700;
}

/* Responsive */
@media (max-width: 768px) {
    .action-buttons {
        flex-direction: column;
        width: 100%;
    }

    .action-buttons .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }

    .info-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .info-value {
        text-align: left;
        max-width: 100%;
        margin-top: 5px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips jika ada
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endsection
