@extends('layouts.app')

@section('title', 'Detail Verifikasi Pembayaran')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Detail Verifikasi Pembayaran</h1>
                <a href="{{ route('payment.verification.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
            </div>

            <div class="row">
                <!-- Informasi Pesanan -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Informasi Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">No. Pesanan</th>
                                            <td>{{ $order->order_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Customer</th>
                                            <td>{{ $order->nama_lengkap }}</td>
                                        </tr>
                                        <tr>
                                            <th>Telepon</th>
                                            <td>{{ $order->no_telepon }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $order->alamat }}, {{ $order->kota }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">Tanggal</th>
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Metode Bayar</th>
                                            <td>
                                                <span class="badge bg-info text-uppercase">
                                                    {{ $order->metode_pembayaran }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @if($order->status_pembayaran == 'menunggu_verifikasi')
                                                    <span class="badge bg-warning">Menunggu Verifikasi</span>
                                                @elseif($order->status_pembayaran == 'terverifikasi')
                                                    <span class="badge bg-success">Terverifikasi</span>
                                                @else
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Pengiriman</th>
                                            <td>{{ ucfirst($order->metode_pengiriman) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Items Pesanan -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Items Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Harga</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderItems as $item)
                                        <tr>
                                            <td>{{ $item->product->nama_produk }}</td>
                                            <td>Rp {{ number_format($item->harga_saat_beli, 0, ',', '.') }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>Rp {{ number_format($item->harga_saat_beli * $item->quantity, 0, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bukti Pembayaran & Aksi -->
                <div class="col-lg-4">
                    @if($order->bukti_pembayaran)
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Bukti Pembayaran</h5>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ asset('storage/' . $order->bukti_pembayaran) }}"
                                 alt="Bukti Pembayaran"
                                 class="img-fluid rounded shadow-sm mb-3"
                                 style="max-height: 300px;">
                            <div class="d-grid gap-2">
                                <a href="{{ asset('storage/' . $order->bukti_pembayaran) }}"
                                   target="_blank"
                                   class="btn btn-outline-primary">
                                    <i class="fas fa-expand me-1"></i>Lihat Full Size
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Ringkasan Pembayaran -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Ringkasan Pembayaran</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Subtotal</th>
                                    <td class="text-end">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Ongkos Kirim</th>
                                    <td class="text-end">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Total Bayar</th>
                                    <td class="text-end fw-bold text-success">
                                        Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Aksi Verifikasi -->
                    @if($order->status_pembayaran == 'menunggu_verifikasi')
                    <div class="card">
                        <div class="card-header bg-warning">
                            <h5 class="mb-0 text-white">Verifikasi Pembayaran</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('payment.verification.verify', $order->id) }}" method="POST" class="mb-3">
                                @csrf
                                <div class="mb-3">
                                    <label for="catatan" class="form-label">Catatan (Opsional)</label>
                                    <textarea name="catatan" id="catatan" rows="3"
                                              class="form-control"
                                              placeholder="Tambahkan catatan verifikasi..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check me-1"></i>Verifikasi Pembayaran
                                </button>
                            </form>

                            <form action="{{ route('payment.verification.reject', $order->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="alasan_penolakan" class="form-label">Alasan Penolakan</label>
                                    <textarea name="alasan_penolakan" id="alasan_penolakan" rows="3"
                                              class="form-control"
                                              placeholder="Berikan alasan penolakan..."
                                              required></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger w-100"
                                        onclick="return confirm('Yakin ingin menolak pembayaran ini?')">
                                    <i class="fas fa-times me-1"></i>Tolak Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="card">
                        <div class="card-header
                            @if($order->status_pembayaran == 'terverifikasi') bg-success
                            @else bg-danger @endif text-white">
                            <h5 class="mb-0">Status Verifikasi</h5>
                        </div>
                        <div class="card-body">
                            @if($order->status_pembayaran == 'terverifikasi')
                                <div class="text-center text-success">
                                    <i class="fas fa-check-circle fa-3x mb-3"></i>
                                    <h5>Pembayaran Terverifikasi</h5>
                                    <p class="mb-0">Pesanan sedang diproses</p>
                                </div>
                            @else
                                <div class="text-center text-danger">
                                    <i class="fas fa-times-circle fa-3x mb-3"></i>
                                    <h5>Pembayaran Ditolak</h5>
                                    @if($order->catatan_verifikasi)
                                        <p class="mb-0">Alasan: {{ $order->catatan_verifikasi }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
