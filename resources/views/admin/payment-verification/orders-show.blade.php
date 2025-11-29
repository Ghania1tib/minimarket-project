@extends('layouts.app')

@section('title', 'Detail Pesanan - ' . $order->order_number)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Detail Pesanan: {{ $order->order_number }}</h1>
                <div>
                    <a href="{{ route('payment.verification.orders.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                    @if($order->tipe_pesanan == 'website' && $order->status_pembayaran == 'menunggu_verifikasi')
                        <a href="{{ route('payment.verification.show', $order->id) }}" class="btn btn-warning">
                            <i class="fas fa-check-circle me-1"></i>Verifikasi Pembayaran
                        </a>
                    @endif
                </div>
            </div>

            <div class="row">
                <!-- Informasi Pesanan -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Informasi Pesanan</h5>
                            <div>
                                <span class="badge bg-{{ $order->tipe_pesanan == 'website' ? 'info' : 'secondary' }}">
                                    {{ $order->tipe_pesanan == 'website' ? 'Online' : 'POS' }}
                                </span>
                            </div>
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
                                            <th>Status Pesanan</th>
                                            <td>
                                                @php
                                                    $statusLabels = [
                                                        'pending' => ['class' => 'secondary', 'label' => 'Pending'],
                                                        'menunggu_pembayaran' => ['class' => 'warning', 'label' => 'Menunggu Pembayaran'],
                                                        'menunggu_verifikasi' => ['class' => 'info', 'label' => 'Menunggu Verifikasi'],
                                                        'diproses' => ['class' => 'primary', 'label' => 'Diproses'],
                                                        'dikirim' => ['class' => 'info', 'label' => 'Dikirim'],
                                                        'selesai' => ['class' => 'success', 'label' => 'Selesai'],
                                                        'dibatalkan' => ['class' => 'danger', 'label' => 'Dibatalkan']
                                                    ];
                                                    $statusInfo = $statusLabels[$order->status_pesanan] ?? ['class' => 'secondary', 'label' => $order->status_pesanan];
                                                @endphp
                                                <span class="badge bg-{{ $statusInfo['class'] }}">
                                                    {{ $statusInfo['label'] }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status Pembayaran</th>
                                            <td>
                                                @if($order->status_pembayaran == 'menunggu_verifikasi')
                                                    <span class="badge bg-warning">Menunggu Verifikasi</span>
                                                @elseif($order->status_pembayaran == 'terverifikasi')
                                                    <span class="badge bg-success">Terverifikasi</span>
                                                @elseif($order->status_pembayaran == 'ditolak')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $order->status_pembayaran }}</span>
                                                @endif
                                            </td>
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
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-end">Subtotal:</th>
                                            <th class="text-success">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-end">Ongkos Kirim:</th>
                                            <th class="text-success">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-end">Total Bayar:</th>
                                            <th class="text-success">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Update Status -->
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Update Status Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('payment.verification.orders.update-status', $order->id) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status_pesanan" class="form-label">Status Pesanan</label>
                                            <select name="status_pesanan" id="status_pesanan" class="form-select" required>
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
                                            <textarea name="catatan_status" id="catatan_status" rows="3"
                                                      class="form-control" placeholder="Tambahkan catatan...">{{ $order->catatan }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Update Status
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Timeline Status -->
                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">Timeline Status</h5>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                @foreach($statusHistory as $history)
                                <div class="timeline-item {{ $history['active'] ? 'active' : '' }}">
                                    <div class="timeline-marker">
                                        <i class="{{ $history['icon'] }}"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">{{ $history['status'] }}</h6>
                                        <small class="text-muted">{{ $history['tanggal']->format('d/m/Y H:i') }}</small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Update Pengiriman -->
                    @if($order->tipe_pesanan == 'website')
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-white">
                            <h5 class="mb-0">Informasi Pengiriman</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('payment.verification.orders.update-shipping', $order->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="metode_pengiriman" class="form-label">Metode Pengiriman</label>
                                    <select name="metode_pengiriman" id="metode_pengiriman" class="form-select" required>
                                        <option value="reguler" {{ $order->metode_pengiriman == 'reguler' ? 'selected' : '' }}>Reguler</option>
                                        <option value="express" {{ $order->metode_pengiriman == 'express' ? 'selected' : '' }}>Express</option>
                                        <option value="ambil_ditempat" {{ $order->metode_pengiriman == 'ambil_ditempat' ? 'selected' : '' }}>Ambil di Tempat</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="catatan_pengiriman" class="form-label">Catatan Pengiriman</label>
                                    <textarea name="catatan_pengiriman" id="catatan_pengiriman" rows="3"
                                              class="form-control" placeholder="Tambahkan catatan pengiriman...">{{ $order->catatan }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fas fa-truck me-1"></i>Update Pengiriman
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    <!-- Ringkasan -->
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Ringkasan Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Subtotal</th>
                                    <td class="text-end">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Diskon</th>
                                    <td class="text-end">Rp {{ number_format($order->total_diskon, 0, ',', '.') }}</td>
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
    margin-bottom: 20px;
}
.timeline-marker {
    position: absolute;
    left: -30px;
    top: 0;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}
.timeline-item.active .timeline-marker {
    background: #0d6efd;
}
.timeline-content {
    padding-bottom: 10px;
    border-bottom: 1px solid #e9ecef;
}
.timeline-item:last-child .timeline-content {
    border-bottom: none;
}
</style>
@endsection
