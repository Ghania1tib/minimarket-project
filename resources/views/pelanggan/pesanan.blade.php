@extends('layouts.pelanggan')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="card content-container p-0">
    <div class="card-header d-flex justify-content-between align-items-center bg-theme-accent">
        <h4 class="card-title mb-0 text-theme-primary fw-bold">
            <i class="fas fa-history me-2"></i>Riwayat Pesanan
        </h4>
        <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-primary-custom btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Kembali ke Dashboard
        </a>
    </div>
    <div class="card-body p-4">
        @if(isset($orders) && $orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-theme-light">
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
                                @php
                                    $status = $order->status_pesanan ?? 'pending';
                                    $badgeClass = [
                                        'selesai' => 'bg-success',
                                        'menunggu_pembayaran' => 'bg-warning text-dark',
                                        'dibatalkan' => 'bg-danger',
                                        'diproses' => 'bg-info text-dark',
                                        'dikirim' => 'bg-primary',
                                    ][$status] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </span>
                            </td>
                            <td class="fw-bold" style="color: var(--color-danger);">
                                Rp {{ number_format($order->total_bayar ?? $order->total_amount ?? 0, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge bg-theme-light text-dark">
                                    {{ $order->metode_pembayaran ?? 'Transfer Bank' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('pelanggan.pesanan.detail', $order->id) }}"
                                   class="btn btn-outline-primary-custom btn-sm" style="color: var(--color-primary); border-color: var(--color-primary);">
                                    <i class="fas fa-eye me-1"></i>Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if(isset($orders) && $orders->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted small">
                    Menampilkan {{ $orders->firstItem() }} - {{ $orders->lastItem() }} dari {{ $orders->total() }} pesanan
                </div>
                <nav>
                    {{ $orders->links() }}
                </nav>
            </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-receipt fa-3x text-secondary mb-3"></i>
                <h4 class="text-muted">Belum Ada Riwayat Pesanan</h4>
                <p class="text-muted mb-4">Anda belum memiliki riwayat pesanan.</p>
                <a href="{{ route('home') }}" class="btn btn-primary-custom">
                    <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
