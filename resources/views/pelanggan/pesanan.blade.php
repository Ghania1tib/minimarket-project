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

           @if($orders->hasPages())
                        <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                            <div class="text-muted">
                                <small>
                                    Menampilkan
                                    <strong>{{ $orders->firstItem() ?? 0 }}</strong>
                                    sampai
                                    <strong>{{ $orders->lastItem() ?? 0 }}</strong>
                                    dari
                                    <strong>{{ $orders->total() }}</strong>
                                    hasil
                                </small>
                            </div>

                            <nav aria-label="Page navigation">
                                <ul class="pagination mb-0">
                                    {{-- Previous Page --}}
                                    @if($orders->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-left me-1"></i>Sebelumnya
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $orders->previousPageUrl() }}">
                                                <i class="fas fa-chevron-left me-1"></i>Sebelumnya
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Page Numbers --}}
                                    @php
                                        $current = $orders->currentPage();
                                        $last = $orders->lastPage();
                                        $start = max(1, $current - 1);
                                        $end = min($last, $current + 1);
                                    @endphp

                                    {{-- First Page --}}
                                    @if($start > 1)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $orders->url(1) }}">1</a>
                                        </li>
                                        @if($start > 2)
                                            <li class="page-item disabled">
                                                <span class="page-link">...</span>
                                            </li>
                                        @endif
                                    @endif

                                    {{-- Middle Pages --}}
                                    @for($page = $start; $page <= $end; $page++)
                                        @if($page == $current)
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $orders->url($page) }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endfor

                                    {{-- Last Page --}}
                                    @if($end < $last)
                                        @if($end < $last - 1)
                                            <li class="page-item disabled">
                                                <span class="page-link">...</span>
                                            </li>
                                        @endif
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $orders->url($last) }}">{{ $last }}</a>
                                        </li>
                                    @endif

                                    {{-- Next Page --}}
                                    @if($orders->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $orders->nextPageUrl() }}">
                                                Selanjutnya<i class="fas fa-chevron-right ms-1"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                Selanjutnya<i class="fas fa-chevron-right ms-1"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
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
