@extends('layouts.admin-base')

@section('title', 'Detail Verifikasi Pembayaran')

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
                                <i class="fas fa-money-check-alt me-2"></i>Detail Verifikasi Pembayaran
                            </h2>
                            <p class="text-muted mb-0">No. Pesanan: <strong>{{ $order->order_number }}</strong></p>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('payment.verification.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Kolom Kiri - Informasi Pesanan -->
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
                                <h6 class="info-title">Detail Pesanan</h6>
                                <div class="info-item">
                                    <span class="info-label">Tanggal</span>
                                    <span class="info-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
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
                                    <span class="info-label">Status</span>
                                    <span class="info-value">
                                        @if($order->status_pembayaran == 'menunggu_verifikasi')
                                            <span class="badge badge-waiting rounded-pill">
                                                <i class="fas fa-clock me-1"></i>Menunggu Verifikasi
                                            </span>
                                        @elseif($order->status_pembayaran == 'terverifikasi')
                                            <span class="badge badge-verified rounded-pill">
                                                <i class="fas fa-check me-1"></i>Terverifikasi
                                            </span>
                                        @else
                                            <span class="badge badge-rejected rounded-pill">
                                                <i class="fas fa-times me-1"></i>Ditolak
                                            </span>
                                        @endif
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Pengiriman</span>
                                    <span class="info-value">{{ ucfirst($order->metode_pengiriman) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Pesanan -->
            <div class="card">
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
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan - Bukti & Aksi -->
        <div class="col-lg-4">
            <!-- Bukti Pembayaran -->
            @if($order->bukti_pembayaran)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-image me-2"></i>Bukti Pembayaran
                    </h5>

                    <div class="text-center">
                        <div class="payment-proof-container mb-3">
                            <img src="{{ asset('storage/' . $order->bukti_pembayaran) }}"
                                 alt="Bukti Pembayaran"
                                 class="img-fluid rounded payment-proof-image">
                        </div>
                        <a href="{{ asset('storage/' . $order->bukti_pembayaran) }}"
                           target="_blank"
                           class="btn btn-outline-primary w-100">
                            <i class="fas fa-expand me-2"></i>Lihat Full Size
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Ringkasan Pembayaran -->
            <div class="card mb-4">
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

            <!-- Aksi Verifikasi atau Status -->
            @if($order->status_pembayaran == 'menunggu_verifikasi')
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-check-circle me-2"></i>Verifikasi Pembayaran
                    </h5>

                    <form action="{{ route('payment.verification.verify', $order->id) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan (Opsional)</label>
                            <textarea name="catatan" id="catatan" rows="3"
                                      class="form-control search-box"
                                      placeholder="Tambahkan catatan verifikasi..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-check me-2"></i>Verifikasi Pembayaran
                        </button>
                    </form>

                    <form action="{{ route('payment.verification.reject', $order->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="alasan_penolakan" class="form-label">Alasan Penolakan</label>
                            <textarea name="alasan_penolakan" id="alasan_penolakan" rows="3"
                                      class="form-control search-box"
                                      placeholder="Berikan alasan penolakan..."
                                      required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger w-100"
                                onclick="return confirm('Yakin ingin menolak pembayaran ini?')">
                            <i class="fas fa-times me-2"></i>Tolak Pembayaran
                        </button>
                    </form>
                </div>
            </div>
            @else
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        @if($order->status_pembayaran == 'terverifikasi')
                            <i class="fas fa-check-circle me-2 text-success"></i>Status Verifikasi
                        @else
                            <i class="fas fa-times-circle me-2 text-danger"></i>Status Verifikasi
                        @endif
                    </h5>

                    @if($order->status_pembayaran == 'terverifikasi')
                        <div class="text-center">
                            <div class="status-icon success mb-3">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h5 class="text-success">Pembayaran Terverifikasi</h5>
                            <p class="text-muted">Pesanan sedang diproses</p>
                        </div>
                    @else
                        <div class="text-center">
                            <div class="status-icon danger mb-3">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <h5 class="text-danger">Pembayaran Ditolak</h5>
                            @if($order->catatan_verifikasi)
                                <div class="alert alert-danger mt-3" role="alert">
                                    <strong>Alasan:</strong> {{ $order->catatan_verifikasi }}
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            @endif
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
.btn-primary, .btn-success, .btn-danger, .btn-warning, .btn-outline-primary {
    border-radius: var(--border-radius-sm);
    padding: 8px 20px;
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
    background-color: #5AA897;
    border-color: #5AA897;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(112, 193, 179, 0.3);
}

.btn-danger {
    background-color: var(--color-danger);
    border-color: var(--color-danger);
}

.btn-danger:hover {
    background-color: #D7694E;
    border-color: #D7694E;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(224, 122, 95, 0.3);
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

.badge-payment {
    background-color: var(--color-accent) !important;
    color: #000 !important;
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

/* Bukti Pembayaran */
.payment-proof-container {
    border-radius: var(--border-radius-sm);
    overflow: hidden;
    border: 2px solid var(--color-accent);
    background: #f8f9fa;
    padding: 10px;
}

.payment-proof-image {
    max-height: 250px;
    width: auto;
    display: block;
    margin: 0 auto;
}

/* Status Icon */
.status-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    font-size: 2.5rem;
}

.status-icon.success {
    background-color: rgba(112, 193, 179, 0.2);
    color: var(--color-success);
}

.status-icon.danger {
    background-color: rgba(224, 122, 95, 0.2);
    color: var(--color-danger);
}

/* Alert Styling */
.alert-danger {
    background-color: rgba(224, 122, 95, 0.1);
    border-color: rgba(224, 122, 95, 0.2);
    color: #721c24;
    border-radius: var(--border-radius-sm);
    text-align: left;
}

/* Responsive */
@media (max-width: 768px) {
    .btn-outline-primary {
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

    .payment-proof-image {
        max-height: 200px;
    }
}
</style>
@endsection
