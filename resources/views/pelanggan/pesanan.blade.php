@extends('layouts.pelanggan')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i>Riwayat Pesanan
                    </h4>
                    <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Dashboard
                    </a>
                </div>
                <div class="card-body">
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No. Pesanan</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <strong>#{{ $order->order_number ?? $order->id }}</strong>
                                        </td>
                                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            <span class="badge
                                                @if($order->status_pesanan == 'selesai') bg-success
                                                @elseif($order->status_pesanan == 'menunggu_pembayaran') bg-warning
                                                @elseif($order->status_pesanan == 'dibatalkan') bg-danger
                                                @elseif($order->status_pesanan == 'diproses') bg-info
                                                @elseif($order->status_pesanan == 'dikirim') bg-primary
                                                @else bg-secondary @endif">
                                                {{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}
                                            </span>
                                        </td>
                                        <td class="fw-bold text-success">
                                            Rp {{ number_format($order->total_bayar ?? $order->total_amount, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                {{ $order->metode_pembayaran ?? 'Transfer Bank' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('pelanggan.pesanan.detail', $order->id) }}"
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye me-1"></i>Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($orders->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                Menampilkan {{ $orders->firstItem() }} - {{ $orders->lastItem() }} dari {{ $orders->total() }} pesanan
                            </div>
                            <nav>
                                {{ $orders->links() }}
                            </nav>
                        </div>
                        @endif
                    @else
                        <div class="empty-state text-center py-5">
                            <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">Belum Ada Pesanan</h4>
                            <p class="text-muted mb-4">Anda belum memiliki riwayat pesanan.</p>
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
