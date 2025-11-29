@extends('layouts.pelanggan')

@section('title', 'Detail Pesanan - ' . ($order->order_number ?? '#' . $order->id))

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header Pesanan -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="mb-1">Detail Pesanan</h4>
                            <p class="text-muted mb-0">{{ $order->created_at->format('d F Y - H:i') }}</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <span class="badge bg-{{ $order->status_pesanan == 'selesai' ? 'success' : ($order->status_pesanan == 'dibatalkan' ? 'danger' : ($order->status_pesanan == 'dikirim' ? 'info' : ($order->status_pesanan == 'diproses' ? 'primary' : 'warning'))) }} fs-6">
                                {{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}
                            </span>
                            <h5 class="mt-2 text-primary">{{ $order->order_number ?? '#' . $order->id }}</h5>
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
                <!-- Informasi Utama -->
                <div class="col-lg-8">
                    <!-- Status Pengiriman -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-shipping-fast me-2"></i> Status Pengiriman</h5>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                @foreach($timeline as $item)
                                <div class="timeline-item {{ $item['active'] ? 'active' : '' }}">
                                    <div class="timeline-icon">
                                        <i class="{{ $item['icon'] }}"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">{{ $item['status'] }}</h6>
                                        <p class="mb-1 text-muted small">{{ $item['description'] }}</p>
                                        <small class="text-muted">{{ $item['tanggal']->format('d M Y H:i') }}</small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                   <!-- Informasi Pembayaran -->
@if(in_array($order->status_pembayaran, ['menunggu_pembayaran', 'menunggu_verifikasi']))
<div class="card mb-4">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i> Informasi Pembayaran</h5>
    </div>
    <div class="card-body">
        @if($order->metode_pembayaran == 'transfer')
            <!-- Transfer Bank -->
            <div class="text-center p-4 border rounded-3 bg-light mb-4">
                <i class="fas fa-university fa-3x text-primary mb-3"></i>
                <h4 class="text-primary mb-3">Transfer Bank</h4>

                <div class="bank-info mb-4">
                    <h5 class="mb-2">Rekening Tujuan:</h5>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <h6 class="fw-bold mb-1">BANK BCA</h6>
                                    <h4 class="text-success fw-bold mb-1">8880 0888 0291 {{ $order->id }}</h4>
                                    <p class="mb-1">a.n. TOKO SAUDARA</p>
                                    <p class="mb-0 fw-bold">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="instructions">
                    <h6 class="fw-bold">Cara Pembayaran:</h6>
                    <ol class="text-start">
                        <li>Transfer tepat sejumlah <strong>Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</strong></li>
                        <li>Ke rekening BCA di atas</li>
                        <li>Upload bukti transfer di form bawah</li>
                        <li>Tunggu verifikasi dari admin (1x24 jam)</li>
                    </ol>
                </div>
            </div>

        @elseif($order->metode_pembayaran == 'qris')
            <!-- QRIS -->
            <div class="text-center p-4 border rounded-3 bg-light mb-4">
                <i class="fas fa-qrcode fa-3x text-success mb-3"></i>
                <h4 class="text-success mb-3">QRIS Payment</h4>

                <div class="qris-code mb-4">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode('TOKOSAUDARA-ORDER-' . $order->order_number . '-AMOUNT-' . $order->total_bayar) }}"
                         alt="QR Code" class="img-fluid border rounded" style="max-width: 200px;">
                </div>

                <div class="amount-info mb-3">
                    <h5 class="text-success">Total Pembayaran:</h5>
                    <h3 class="fw-bold text-primary">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</h3>
                </div>

                <div class="instructions">
                    <h6 class="fw-bold">Cara Pembayaran:</h6>
                    <ol class="text-start">
                        <li>Buka aplikasi e-wallet atau mobile banking Anda</li>
                        <li>Pilih menu "Scan QRIS" atau "Bayar dengan QR"</li>
                        <li>Scan QR code di atas</li>
                        <li>Pastikan jumlah: <strong>Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</strong></li>
                        <li>Upload bukti pembayaran di form bawah</li>
                    </ol>
                </div>
            </div>

        @elseif($order->metode_pembayaran == 'tunai')
            <!-- COD -->
            <div class="text-center p-4 border rounded-3 bg-light mb-4">
                <i class="fas fa-money-bill-wave fa-3x text-warning mb-3"></i>
                <h4 class="text-warning mb-3">Cash on Delivery (COD)</h4>

                <div class="cod-info mb-4">
                    <h5 class="text-success">Bayar ketika barang sampai</h5>
                    <p class="text-muted">Siapkan uang tunai sebesar:</p>
                    <h2 class="text-success fw-bold">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</h2>
                </div>

                <div class="instructions">
                    <h6 class="fw-bold">Informasi:</h6>
                    <ul class="text-start">
                        <li>Anda tidak perlu membayar sekarang</li>
                        <li>Bayar langsung kepada kurir ketika barang sampai</li>
                        <li>Pastikan menyiapkan uang pas</li>
                        <li>Periksa barang sebelum melakukan pembayaran</li>
                    </ul>
                </div>
            </div>
        @endif

        <!-- PERBAIKAN: Form Upload Bukti Pembayaran untuk Transfer dan QRIS -->
        @if(in_array($order->metode_pembayaran, ['transfer', 'qris']) && $order->status_pembayaran == 'menunggu_pembayaran')
        <div class="mt-4">
            <h5 class="fw-bold mb-3">Upload Bukti Pembayaran</h5>
            <form action="{{ route('pelanggan.pesanan.upload-bukti', $order->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if($order->metode_pembayaran == 'transfer')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nomor Rekening Pengirim *</label>
                        <input type="text" name="nomor_rekening" class="form-control @error('nomor_rekening') is-invalid @enderror"
                               value="{{ old('nomor_rekening') }}" placeholder="Contoh: 1234567890" required>
                        @error('nomor_rekening')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nama Bank Pengirim *</label>
                        <select name="nama_bank" class="form-control @error('nama_bank') is-invalid @enderror" required>
                            <option value="">Pilih Bank</option>
                            <option value="BCA" {{ old('nama_bank') == 'BCA' ? 'selected' : '' }}>BCA</option>
                            <option value="Mandiri" {{ old('nama_bank') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                            <option value="BRI" {{ old('nama_bank') == 'BRI' ? 'selected' : '' }}>BRI</option>
                            <option value="BNI" {{ old('nama_bank') == 'BNI' ? 'selected' : '' }}>BNI</option>
                            <option value="Bank Riau" {{ old('nama_bank') == 'Bank Riau' ? 'selected' : '' }}>Bank Riau</option>
                            <option value="Lainnya" {{ old('nama_bank') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('nama_bank')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @endif

                <div class="mb-3">
                    <label class="form-label fw-bold">Bukti Pembayaran *</label>
                    <input type="file" name="bukti_pembayaran" class="form-control @error('bukti_pembayaran') is-invalid @enderror"
                           accept="image/*,.pdf" required>
                    @error('bukti_pembayaran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Format: JPG, PNG, PDF (Maks. 2MB)</small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload me-2"></i> Upload Bukti Pembayaran
                </button>
            </form>
        </div>
        @endif

        <!-- PERBAIKAN: Tampilkan status menunggu verifikasi -->
        @if($order->status_pembayaran == 'menunggu_verifikasi')
        <div class="alert alert-info mt-4">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Bukti pembayaran telah diupload!</strong> Menunggu verifikasi dari admin. Proses verifikasi membutuhkan waktu 1x24 jam.
        </div>
        @endif
    </div>
</div>
@endif
                    <!-- Produk Dipesan -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-box me-2"></i> Produk Dipesan</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="60"></th>
                                            <th>Produk</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Harga</th>
                                            <th class="text-end">Subtotal</th>
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
                                            <td>
                                                @if($item->product->gambar_url)
                                                    <img src="{{ asset('storage/' . $item->product->gambar_url) }}"
                                                         class="rounded" width="50" height="50" style="object-fit: cover;"
                                                         onerror="this.src='data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'50\' height=\'50\' viewBox=\'0 0 50 50\'%3E%3Crect width=\'50\' height=\'50\' fill=\'%23f8f9fa\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'Arial, sans-serif\' font-size=\'8\' fill=\'%236c757d\'%3E{{ urlencode($item->product->nama_produk) }}%3C/text%3E%3C/svg%3E'">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                         style="width: 50px; height: 50px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <h6 class="mb-1">{{ $item->product->nama_produk }}</h6>
                                                <small class="text-muted">SKU: {{ $item->product->sku ?? '-' }}</small>
                                            </td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">Rp {{ number_format($item->harga_saat_beli, 0, ',', '.') }}</td>
                                            <td class="text-end fw-bold">Rp {{ number_format($subtotalItem, 0, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pengiriman -->
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-truck me-2"></i> Informasi Pengiriman</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="fw-bold">Penerima</h6>
                                    <p class="mb-1">{{ $order->nama_lengkap }}</p>
                                    <p class="text-muted mb-3">{{ $order->no_telepon }}</p>

                                    <h6 class="fw-bold">Alamat Pengiriman</h6>
                                    <p class="mb-1">{{ $order->alamat }}</p>
                                    <p class="text-muted">{{ $order->kota }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold">Metode Pengiriman</h6>
                                    <p class="mb-3 text-capitalize">{{ $order->metode_pengiriman }}</p>

                                    @if($order->catatan)
                                    <h6 class="fw-bold">Catatan</h6>
                                    <p class="text-muted">{{ $order->catatan }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Informasi -->
                <div class="col-lg-4">
                    <!-- Ringkasan Pembayaran -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-receipt me-2"></i> Ringkasan Pembayaran</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal Produk:</span>
                                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Biaya Pengiriman:</span>
                                <span>{{ $order->shipping_cost == 0 ? 'Gratis' : 'Rp ' . number_format($order->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                            @if($order->total_diskon > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span>Diskon:</span>
                                <span class="text-success">- Rp {{ number_format($order->total_diskon, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <strong class="fs-5">Total Bayar:</strong>
                                <strong class="fs-5 text-primary">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</strong>
                            </div>

                            <div class="mb-3">
                                <h6 class="fw-bold">Metode Pembayaran</h6>
                                <span class="badge bg-light text-dark fs-6 text-capitalize">
                                    @if($order->metode_pembayaran == 'tunai')
                                        Tunai (COD)
                                    @elseif($order->metode_pembayaran == 'transfer')
                                        Transfer Bank
                                    @else
                                        QRIS
                                    @endif
                                </span>
                            </div>

                            @if($order->nomor_rekening)
                            <div class="mb-3">
                                <h6 class="fw-bold">Nomor Rekening</h6>
                                <p class="mb-1">{{ $order->nomor_rekening }}</p>
                            </div>
                            @endif

                            @if($order->bukti_pembayaran)
                            <div class="mb-3">
                                <h6 class="fw-bold">Bukti Pembayaran</h6>
                                <a href="{{ asset('storage/' . $order->bukti_pembayaran) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i> Lihat Bukti
                                </a>
                                <small class="d-block text-muted mt-1">Status:
                                    @if($order->status_pembayaran == 'menunggu_verifikasi')
                                        <span class="text-warning">Menunggu Verifikasi</span>
                                    @elseif($order->status_pembayaran == 'lunas')
                                        <span class="text-success">Terverifikasi</span>
                                    @elseif($order->status_pembayaran == 'ditolak')
                                        <span class="text-danger">Ditolak</span>
                                    @else
                                        <span class="text-secondary">{{ $order->status_pembayaran }}</span>
                                    @endif
                                </small>
                            </div>
                            @endif

                            <div class="mt-4">
                                <h6 class="fw-bold">Status Pembayaran</h6>
                                <span class="badge bg-{{ $order->status_pembayaran == 'lunas' ? 'success' : ($order->status_pembayaran == 'menunggu_verifikasi' ? 'warning' : ($order->status_pembayaran == 'dibatalkan' ? 'danger' : ($order->status_pembayaran == 'ditolak' ? 'danger' : 'secondary'))) }} fs-6 text-capitalize">
                                    {{ str_replace('_', ' ', $order->status_pembayaran) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Aksi -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                @if($order->status_pesanan == 'menunggu_pembayaran' && $order->metode_pembayaran == 'tunai')
                                    <form action="{{ route('pelanggan.pesanan.bayar', $order->id) }}" method="POST" class="d-grid">
                                        @csrf
                                        <button type="submit" class="btn btn-primary" onclick="return confirm('Konfirmasi pembayaran tunai?')">
                                            <i class="fas fa-credit-card me-2"></i> Konfirmasi Pembayaran
                                        </button>
                                    </form>
                                @endif

                                @if($order->status_pesanan == 'menunggu_pembayaran' && !in_array($order->metode_pembayaran, ['transfer', 'qris']))
                                    <form action="{{ route('pelanggan.pesanan.batalkan', $order->id) }}" method="POST" class="d-grid">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-outline-danger"
                                                onclick="return confirm('Yakin ingin membatalkan pesanan?')">
                                            <i class="fas fa-times me-2"></i> Batalkan Pesanan
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('pelanggan.pesanan') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Pesanan
                                </a>

                                <button onclick="window.print()" class="btn btn-outline-primary">
                                    <i class="fas fa-print me-2"></i> Cetak Invoice
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Bantuan -->
                    <div class="card mt-4">
                        <div class="card-body text-center">
                            <h6 class="fw-bold mb-2">Butuh Bantuan?</h6>
                            <p class="text-muted mb-2">Hubungi customer service kami</p>
                            <div class="d-flex flex-column gap-2">
                                <div>
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    <span>0812-3456-7890</span>
                                </div>
                                <div>
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    <span>cs@tokosaudara.com</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding: 15px 0;
    border-left: 2px solid #dee2e6;
}

.timeline-item.active {
    border-left-color: var(--color-primary);
}

.timeline-item:last-child {
    border-left: 2px solid transparent;
}

.timeline-icon {
    position: absolute;
    left: -40px;
    top: 50%;
    transform: translateY(-50%);
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #dee2e6;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
}

.timeline-item.active .timeline-icon {
    background: var(--color-primary);
    color: white;
}

.timeline-content {
    padding-left: 20px;
}

@media print {
    .btn, .form-control, .card-header {
        display: none !important;
    }

    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endsection
