@extends('layouts.app')

@section('title', 'Pembayaran Berhasil - Toko Saudara')

@section('navbar')
    @include('layouts.partials.header')
@endsection

@section('content')
<div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-success text-white py-4">
                        <div class="text-center">
                            <i class="fas fa-check-circle fa-4x mb-3"></i>
                            <h2 class="mb-1">Pembayaran Berhasil!</h2>
                            <p class="mb-0 opacity-75">Pesanan Anda sedang diproses</p>
                        </div>
                    </div>

                    <div class="card-body p-5">
                        <!-- Informasi Pesanan -->
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <h5 class="fw-bold mb-3">Detail Pesanan</h5>
                                <p><strong>No. Pesanan:</strong> {{ $order->nomor_pesanan }}</p>
                                <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                                <p><strong>Total Pembayaran:</strong> Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</p>
                                <p><strong>Status:</strong>
                                    <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold mb-3">Informasi Pengiriman</h5>
                                <p><strong>Nama:</strong> {{ $order->nama_lengkap }}</p>
                                <p><strong>Telepon:</strong> {{ $order->no_telepon }}</p>
                                <p><strong>Alamat:</strong> {{ $order->alamat }}, {{ $order->kota }}</p>
                                <p><strong>Pengiriman:</strong> {{ ucfirst($order->metode_pengiriman) }}</p>
                            </div>
                        </div>

                        <!-- Instruksi Pembayaran -->
                        <div class="payment-instruction mb-5">
                            <h5 class="fw-bold mb-4 text-center">Instruksi Pembayaran</h5>

                            @if($order->metode_pembayaran == 'debit_kredit')
                                <!-- Virtual Account -->
                                <div class="text-center p-4 border rounded-3 bg-light">
                                    <i class="fas fa-university fa-3x text-primary mb-3"></i>
                                    <h4 class="text-primary mb-3">Virtual Account</h4>
                                    <div class="virtual-account mb-4">
                                        <h2 class="text-success fw-bold">8880 0888 0291 {{ $order->id }}</h2>
                                        <p class="text-muted">Bank BCA</p>
                                    </div>
                                    <div class="instructions">
                                        <h6 class="fw-bold">Cara Pembayaran:</h6>
                                        <ol class="text-start">
                                            <li>Buka aplikasi mobile banking atau ATM bank Anda</li>
                                            <li>Pilih menu "Transfer" atau "Bayar"</li>
                                            <li>Masukkan nomor virtual account di atas</li>
                                            <li>Masukkan jumlah yang harus dibayar: <strong>Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</strong></li>
                                            <li>Konfirmasi dan selesaikan pembayaran</li>
                                        </ol>
                                    </div>
                                </div>
                            @elseif($order->metode_pembayaran == 'qris_ewallet')
                                <!-- QRIS -->
                                <div class="text-center p-4 border rounded-3 bg-light">
                                    <i class="fas fa-qrcode fa-3x text-success mb-3"></i>
                                    <h4 class="text-success mb-3">QRIS Payment</h4>
                                    <div class="qris-code mb-4">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode('TOKOSAUDARA-ORDER-' . $order->id . '-AMOUNT-' . $order->total_bayar) }}"
                                             alt="QR Code" class="img-fluid border rounded" style="max-width: 200px;">
                                    </div>
                                    <div class="instructions">
                                        <h6 class="fw-bold">Cara Pembayaran:</h6>
                                        <ol class="text-start">
                                            <li>Buka aplikasi e-wallet atau mobile banking Anda</li>
                                            <li>Pilih menu "Scan QRIS" atau "Bayar dengan QR"</li>
                                            <li>Scan QR code di atas</li>
                                            <li>Pastikan jumlah: <strong>Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</strong></li>
                                            <li>Konfirmasi dan selesaikan pembayaran</li>
                                        </ol>
                                    </div>
                                </div>
                            @elseif($order->metode_pembayaran == 'tunai')
                                <!-- COD -->
                                <div class="text-center p-4 border rounded-3 bg-light">
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
                        </div>

                        <!-- Daftar Produk -->
                        <div class="products-ordered mb-4">
                            <h5 class="fw-bold mb-3">Produk yang Dipesan</h5>
                            @foreach($order->items as $item)
                            <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                                <div class="d-flex align-items-center">
                                    @if($item->product->gambar_url)
                                        <img src="{{ asset('storage/' . $item->product->gambar_url) }}"
                                             class="rounded me-3"
                                             alt="{{ $item->product->nama_produk }}"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center me-3"
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-1">{{ $item->product->nama_produk }}</h6>
                                        <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->harga_saat_beli, 0, ',', '.') }}</small>
                                    </div>
                                </div>
                                <span class="fw-bold">Rp {{ number_format($item->quantity * $item->harga_saat_beli, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>

                        <!-- Rincian Biaya -->
                        <div class="cost-breakdown mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal Produk:</span>
                                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Biaya Pengiriman:</span>
                                <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong class="fs-5">Total Bayar:</strong>
                                <strong class="fs-5 text-success">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</strong>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="text-center mt-5">
                            <a href="{{ route('pelanggan.pesanan.detail', $order->id) }}" class="btn btn-primary me-3">
                                <i class="fas fa-eye me-2"></i>Lihat Detail Pesanan
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-shopping-bag me-2"></i>Lanjutkan Belanja
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Informasi Kontak -->
                <div class="card mt-4 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="fw-bold mb-2">Butuh Bantuan?</h6>
                        <p class="text-muted mb-2">Hubungi customer service kami</p>
                        <div class="d-flex justify-content-center gap-4">
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
@endsection
