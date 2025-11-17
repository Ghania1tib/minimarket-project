@extends('layouts.pelanggan')

@section('title', 'Detail Pesanan - ' . ($order->order_number ?? '#' . $order->id))

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-file-invoice me-2"></i>Detail Pesanan #{{ $order->order_number ?? $order->id }}
                    </h4>
                    <div>
                        <a href="{{ route('pelanggan.pesanan') }}" class="btn btn-outline-secondary btn-sm me-2">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                        <button onclick="window.print()" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-print me-1"></i>Cetak
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Info Pesanan -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary">Informasi Pesanan</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td width="40%">No. Pesanan</td>
                                    <td>: <strong>#{{ $order->order_number ?? $order->id }}</strong></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Pesan</td>
                                    <td>: {{ $order->created_at->format('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td>Status Pesanan</td>
                                    <td>
                                        : <span class="badge
                                            @if($order->status_pesanan == 'selesai') bg-success
                                            @elseif($order->status_pesanan == 'menunggu_pembayaran') bg-warning
                                            @elseif($order->status_pesanan == 'dibatalkan') bg-danger
                                            @elseif($order->status_pesanan == 'diproses') bg-info
                                            @elseif($order->status_pesanan == 'dikirim') bg-primary
                                            @else bg-secondary @endif">
                                            {{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary">Informasi Pembayaran</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td width="40%">Metode Bayar</td>
                                    <td>: {{ $order->metode_pembayaran ?? 'Transfer Bank' }}</td>
                                </tr>
                                <tr>
                                    <td>Status Pembayaran</td>
                                    <td>
                                        : <span class="badge
                                            @if($order->status_pembayaran == 'lunas') bg-success
                                            @elseif($order->status_pembayaran == 'menunggu') bg-warning
                                            @elseif($order->status_pembayaran == 'gagal') bg-danger
                                            @else bg-secondary @endif">
                                            {{ ucfirst($order->status_pembayaran ?? 'Menunggu') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Pembayaran</td>
                                    <td>: <strong class="text-success">Rp {{ number_format($order->total_bayar ?? $order->total_amount, 0, ',', '.') }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Timeline Status -->
                    <h6 class="fw-bold text-primary mb-3">Status Pesanan</h6>
                    <div class="timeline-wrapper mb-4">
                        @foreach($timeline as $item)
                        <div class="timeline-item {{ $item['active'] ? 'active' : '' }}">
                            <div class="timeline-point">
                                <i class="{{ $item['icon'] }}"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">{{ $item['status'] }}</h6>
                                <p class="text-muted mb-0">{{ $item['tanggal']->format('d M Y - H:i') }} WIB</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Detail Produk -->
                    <h6 class="fw-bold text-primary mb-3">Detail Produk</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th width="100" class="text-center">Qty</th>
                                    <th width="150" class="text-end">Harga Satuan</th>
                                    <th width="150" class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                    $items = $order->items ?? [];
                                @endphp

                                @if(count($items) > 0)
                                    @foreach($items as $item)
                                    @php
                                        $subtotal = $item->harga * $item->qty;
                                        $total += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if(isset($item->product->gambar) && $item->product->gambar)
                                                    <img src="{{ asset('storage/' . $item->product->gambar) }}"
                                                         alt="{{ $item->product->nama_produk ?? $item->nama_produk }}"
                                                         class="rounded me-3" width="50" height="50" style="object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center me-3"
                                                         style="width: 50px; height: 50px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $item->product->nama_produk ?? $item->nama_produk }}</h6>
                                                    <small class="text-muted">SKU: {{ $item->product->sku ?? '-' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->qty }}</td>
                                        <td class="text-end">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                        <td class="text-end fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">
                                            <i class="fas fa-info-circle me-2"></i>Tidak ada detail produk
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total</td>
                                    <td class="text-end fw-bold text-success">
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Informasi Pengiriman -->
                    @if(isset($order->alamat_pengiriman) && $order->alamat_pengiriman)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="fw-bold text-primary">Alamat Pengiriman</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-0">{{ $order->alamat_pengiriman }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline-wrapper {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 25px;
}

.timeline-item.active .timeline-point {
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
    border-color: var(--primary-blue);
    color: white;
}

.timeline-point {
    position: absolute;
    left: -30px;
    top: 0;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 2px solid #ddd;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    color: #ddd;
    z-index: 2;
}

.timeline-content {
    padding-bottom: 10px;
    padding-left: 20px;
}

.timeline-item:not(:last-child) .timeline-content::before {
    content: '';
    position: absolute;
    left: -21px;
    top: 24px;
    bottom: -25px;
    width: 2px;
    background: #ddd;
    z-index: 1;
}

.timeline-item.active:not(:last-child) .timeline-content::before {
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
}
</style>
@endsection
