@extends('layouts.pelanggan')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="section-title mb-1">
                                <i class="fas fa-shopping-cart me-2"></i>Detail Pesanan
                            </h2>
                            <p class="text-muted mb-0">No. Pesanan: <strong class="text-primary">{{ $order->order_number ?? '#' . $order->id }}</strong></p>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('pelanggan.pesanan') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Konten Utama -->
        <div class="col-lg-8">
            <!-- Status dan Informasi -->
            <div class="card mb-4">
                <div class="card-body py-3">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-info-circle me-2"></i>Informasi Pesanan
                    </h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-section">
                                <h6 class="info-title">Status Pesanan</h6>
                                <div class="info-item">
                                    <span class="info-label">Status</span>
                                    <span class="info-value">
                                        <span class="badge status-{{ $order->status_pesanan }} rounded-pill px-3">
                                            {{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}
                                        </span>
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Status Pembayaran</span>
                                    <span class="info-value">
                                        @php
                                            $paymentStatusClass = [
                                                'lunas' => 'badge-success',
                                                'menunggu_pembayaran' => 'badge-warning',
                                                'menunggu_verifikasi' => 'badge-info',
                                                'ditolak' => 'badge-danger',
                                            ][$order->status_pembayaran] ?? 'badge-secondary';
                                        @endphp
                                        <span class="badge {{ $paymentStatusClass }} rounded-pill px-3">
                                            {{ ucfirst(str_replace('_', ' ', $order->status_pembayaran)) }}
                                        </span>
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Tanggal Pesanan</span>
                                    <span class="info-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-section">
                                <h6 class="info-title">Informasi Pengiriman</h6>
                                <div class="info-item">
                                    <span class="info-label">Metode</span>
                                    <span class="info-value">{{ ucfirst($order->metode_pengiriman) }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Penerima</span>
                                    <span class="info-value">{{ $order->nama_lengkap }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Telepon</span>
                                    <span class="info-value">{{ $order->no_telepon }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline Status -->
            <div class="card mb-4">
                <div class="card-body py-3">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-history me-2"></i>Status Pengiriman
                    </h5>

                    <div class="timeline">
                        @foreach($timeline as $item)
                        <div class="timeline-item {{ $item['active'] ? 'active' : '' }}">
                            <div class="timeline-marker">
                                <i class="{{ $item['icon'] }}"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">{{ $item['status'] }}</h6>
                                <p class="mb-1 text-muted small">{{ $item['description'] }}</p>
                           </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Produk Dipesan -->
            <div class="card mb-4">
                <div class="card-body p-0">
                    <div class="p-3 border-bottom bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-box me-2"></i>Produk Dipesan
                        </h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="50" class="ps-3"></th>
                                    <th>Produk</th>
                                    <th class="text-center" width="80">Qty</th>
                                    <th class="text-end" width="100">Harga</th>
                                    <th class="text-end pe-3" width="120">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $subtotalProduk = 0;
                                @endphp
                                @foreach($order->items as $item)
                                @php
                                    $subtotalItem = $item->harga_saat_beli * $item->quantity;
                                    $subtotalProduk += $subtotalItem;
                                @endphp
                                <tr>
                                    <td class="ps-3">
                                        @if($item->product->gambar_url)
                                            <img src="{{ asset('storage/' . $item->product->gambar_url) }}"
                                                 class="rounded" width="40" height="40" style="object-fit: cover;"
                                                 onerror="this.src='data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'40\' height=\'40\' viewBox=\'0 0 40 40\'%3E%3Crect width=\'40\' height=\'40\' fill=\'%23f8f9fa\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'Arial, sans-serif\' font-size=\'7\' fill=\'%236c757d\'%3E{{ urlencode($item->product->nama_produk) }}%3C/text%3E%3C/svg%3E'">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-image text-muted fa-xs"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <p class="mb-0 fw-semibold">{{ $item->product->nama_produk }}</p>
                                        <small class="text-muted">SKU: {{ $item->product->sku ?? '-' }}</small>
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">Rp {{ number_format($item->harga_saat_beli, 0, ',', '.') }}</td>
                                    <td class="text-end pe-3 fw-bold">Rp {{ number_format($subtotalItem, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Alamat Pengiriman -->
            <div class="card">
                <div class="card-body py-3">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-map-marker-alt me-2"></i>Alamat Pengiriman
                    </h5>

                    <div class="info-section">
                        <div class="info-item">
                            <span class="info-label">Alamat</span>
                            <span class="info-value">{{ $order->alamat }}, {{ $order->kota }}</span>
                        </div>
                        @if($order->catatan)
                        <div class="info-item">
                            <span class="info-label">Catatan</span>
                            <span class="info-value text-muted">{{ $order->catatan }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Ringkasan Pembayaran -->
            <div class="card mb-4">
                <div class="card-body py-3">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-receipt me-2"></i>Ringkasan Pembayaran
                    </h5>

                    <div class="info-section">
                        <div class="info-item">
                            <span class="info-label">Subtotal Produk</span>
                            <span class="info-value">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Biaya Pengiriman</span>
                            <span class="info-value">{{ $order->shipping_cost == 0 ? 'Gratis' : 'Rp ' . number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        @if($order->total_diskon > 0)
                        <div class="info-item">
                            <span class="info-label">Diskon</span>
                            <span class="info-value text-success">- Rp {{ number_format($order->total_diskon, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="info-item border-top pt-3">
                            <span class="info-label fw-bold fs-5">Total Bayar</span>
                            <span class="info-value fw-bold fs-5 text-primary">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mt-3">
                        <span class="text-muted small d-block">Metode Pembayaran</span>
                        <span class="fw-semibold text-capitalize">
                            @if($order->metode_pembayaran == 'tunai')
                                <i class="fas fa-money-bill-wave me-1"></i>Tunai (COD)
                            @elseif($order->metode_pembayaran == 'transfer')
                                <i class="fas fa-university me-1"></i>Transfer Bank
                            @else
                                <i class="fas fa-qrcode me-1"></i>QRIS
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Informasi Pembayaran -->
            @if(in_array($order->status_pembayaran, ['menunggu_pembayaran', 'menunggu_verifikasi']))
            <div class="card mb-4">
                <div class="card-body py-3">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-credit-card me-2"></i>Informasi Pembayaran
                    </h5>

                    @if($order->metode_pembayaran == 'transfer')
                        <!-- Transfer Bank -->
                        <div class="info-section mb-3">
                            <h6 class="info-title mb-2">Transfer Bank</h6>
                            <div class="text-center p-2 border rounded bg-light">
                                <p class="mb-1 fw-bold">BANK BCA</p>
                                <h6 class="text-primary fw-bold mb-1">8880 0888 0291 {{ $order->id }}</h6>
                                <p class="mb-1 small">a.n. TOKO SAUDARA</p>
                                <p class="mb-0 fw-bold">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</p>
                            </div>
                        </div>

                    @elseif($order->metode_pembayaran == 'qris')
                        <!-- QRIS -->
                        <div class="info-section mb-3">
                            <h6 class="info-title mb-2">QRIS Payment</h6>
                            <div class="text-center p-2 border rounded bg-light">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode('TOKOSAUDARA-ORDER-' . $order->order_number . '-AMOUNT-' . $order->total_bayar) }}"
                                     alt="QR Code" class="img-fluid border rounded mb-2">
                                <p class="mb-0 fw-bold">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</p>
                            </div>
                        </div>

                    @elseif($order->metode_pembayaran == 'tunai')
                        <!-- COD -->
                        <div class="info-section mb-3">
                            <h6 class="info-title mb-2">Cash on Delivery</h6>
                            <div class="text-center p-2 border rounded bg-light">
                                <p class="mb-1 text-success">Bayar ketika barang sampai</p>
                                <h6 class="text-primary fw-bold">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</h6>
                            </div>
                        </div>
                    @endif

                    <!-- Form Upload Bukti -->
                    @if(in_array($order->metode_pembayaran, ['transfer', 'qris']) && $order->status_pembayaran == 'menunggu_pembayaran')
                    <div class="info-section">
                        <h6 class="info-title mb-2">Upload Bukti Pembayaran</h6>
                        <form action="{{ route('pelanggan.pesanan.upload-bukti', $order->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            @if($order->metode_pembayaran == 'transfer')
                            <div class="mb-2">
                                <input type="text" name="nomor_rekening" class="form-control form-control-sm"
                                       placeholder="No. Rekening Pengirim" required>
                            </div>
                            <div class="mb-2">
                                <select name="nama_bank" class="form-control form-control-sm" required>
                                    <option value="">Pilih Bank</option>
                                    <option value="BCA">BCA</option>
                                    <option value="Mandiri">Mandiri</option>
                                    <option value="BRI">BRI</option>
                                    <option value="BNI">BNI</option>
                                    <option value="Bank Riau">Bank Riau</option>
                                </select>
                            </div>
                            @endif

                            <div class="mb-2">
                                <input type="file" name="bukti_pembayaran" class="form-control form-control-sm"
                                       accept="image/*,.pdf" required>
                                <small class="text-muted d-block mt-1">Format: JPG, PNG, PDF (Maks. 2MB)</small>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-upload me-1"></i> Upload Bukti
                            </button>
                        </form>
                    </div>
                    @endif

                    @if($order->status_pembayaran == 'menunggu_verifikasi')
                    <div class="alert alert-info mt-3 p-2">
                        <i class="fas fa-info-circle me-1"></i>
                        <strong>Bukti pembayaran telah diupload!</strong> Menunggu verifikasi dari admin.
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Aksi -->
            <div class="card mb-4">
                    <div class="card-body py-3 d-flex flex-column gap-2">
                        @if($order->status_pesanan == 'menunggu_pembayaran' && $order->metode_pembayaran == 'tunai')
                            <form action="{{ route('pelanggan.pesanan.bayar', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm w-100"
                                        onclick="return confirm('Konfirmasi pembayaran tunai?')">
                                    <i class="fas fa-credit-card me-1"></i>Konfirmasi Pembayaran
                                </button>
                            </form>
                        @endif

                        @if($order->status_pesanan == 'menunggu_pembayaran' && !in_array($order->metode_pembayaran, ['transfer', 'qris']))
                            <form action="{{ route('pelanggan.pesanan.batalkan', $order->id) }}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-danger btn-sm w-100"
                                        onclick="return confirm('Yakin ingin membatalkan pesanan?')">
                                    <i class="fas fa-times me-1"></i>Batalkan Pesanan
                                </button>
                            </form>
                        @endif
                        </div>
            </div>

            <!-- Bantuan -->
            <div class="card">
                <div class="card-body py-3">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-headset me-2"></i>Butuh Bantuan?
                    </h5>

                    <div class="info-section">
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-phone text-primary me-2"></i>Telepon
                            </span>
                            <span class="info-value">0812-3456-7890</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-clock text-primary me-2"></i>Jam Operasional
                            </span>
                            <span class="info-value">08:00 - 22:00 WIB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Variabel CSS konsisten dengan halaman member */
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
    font-size: 1.5rem;
}

/* Card Title */
.card-title {
    color: var(--color-primary);
    font-weight: 600;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    font-size: 1.1rem;
}

/* Button Styling */
.btn-primary, .btn-success, .btn-danger, .btn-warning, .btn-outline-primary {
    border-radius: var(--border-radius-sm);
    padding: 8px 16px;
    font-weight: 600;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.btn-sm {
    padding: 5px 10px;
    font-size: 0.8rem;
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

.btn-warning {
    background-color: var(--color-warning);
    border-color: var(--color-warning);
    color: #000;
}

.btn-warning:hover {
    background-color: #FFA133;
    border-color: #FFA133;
    transform: translateY(-2px);
}

.btn-danger {
    background-color: var(--color-danger);
    border-color: var(--color-danger);
}

.btn-danger:hover {
    background-color: #D7694E;
    border-color: #D7694E;
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

.badge-success {
    background-color: var(--color-success) !important;
    color: white !important;
}

.badge-warning {
    background-color: var(--color-warning) !important;
    color: #000 !important;
}

.badge-info {
    background-color: var(--color-info) !important;
    color: white !important;
}

.badge-danger {
    background-color: var(--color-danger) !important;
    color: white !important;
}

.status-selesai {
    background-color: var(--color-success) !important;
    color: white !important;
}

.status-dikirim {
    background-color: var(--color-info) !important;
    color: white !important;
}

.status-diproses {
    background-color: var(--color-warning) !important;
    color: #000 !important;
}

.status-dibatalkan {
    background-color: var(--color-danger) !important;
    color: white !important;
}

.status-menunggu_pembayaran {
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
    font-size: 0.95rem;
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
    font-size: 0.9rem;
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
    background: var(--color-success);
    box-shadow: 0 0 0 3px rgba(112, 193, 179, 0.2);
}

.timeline-content {
    background: #f8f9fa;
    border-radius: var(--border-radius-sm);
    padding: 1rem;
    border-left: 3px solid var(--color-accent);
}

.timeline-item.active .timeline-content {
    background: rgba(112, 193, 179, 0.05);
    border-left-color: var(--color-success);
}

.timeline-content h6 {
    color: var(--color-primary);
    font-weight: 600;
    margin-bottom: 0.25rem;
    font-size: 0.95rem;
}

/* Table Styling */
.table {
    margin-bottom: 0;
    font-size: 0.9rem;
}

.table thead th {
    border-bottom: 2px solid var(--color-accent);
    color: var(--color-primary);
    font-weight: 600;
    background-color: var(--color-light);
    padding: 0.75rem;
}

.table tbody td {
    padding: 0.75rem;
    vertical-align: middle;
}

.table tbody tr:hover {
    background-color: rgba(94, 84, 142, 0.05);
}

/* Alert Styling */
.alert {
    border-radius: var(--border-radius-sm);
    border: none;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    font-size: 0.9rem;
}

/* Form Styling */
.form-control, .form-select {
    border-radius: var(--border-radius-sm);
    border: 1px solid #dee2e6;
    font-size: 0.875rem;
}

.form-control-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.8rem;
}

/* Grid Gap */
.d-grid.gap-2 {
    gap: 10px !important;
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

    .table-responsive {
        font-size: 0.8rem;
    }

    .section-title {
        font-size: 1.25rem;
    }

    .card-title {
        font-size: 1rem;
    }
}
</style>
@endsection
