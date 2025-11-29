@extends('layouts.admin-base')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-clipboard-list me-2"></i>Manajemen Pesanan
                    </h1>
                </div>
                <div class="text-muted">
                    <small>Total: <strong>{{ $totalOrders }}</strong> pesanan</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-filter me-2"></i>Filter Pesanan
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('payment.verification.orders.index') }}" method="GET">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Status Pesanan</label>
                                <select name="status" class="form-select">
                                    @foreach($statusOptions as $value => $label)
                                        <option value="{{ $value }}" {{ $status == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Tipe Pesanan</label>
                                <select name="tipe" class="form-select">
                                    @foreach($tipeOptions as $value => $label)
                                        <option value="{{ $value }}" {{ $tipe == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Pencarian</label>
                                <input type="text" name="search" class="form-control"
                                       placeholder="Cari no. pesanan, nama, telepon..." value="{{ $search }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-1"></i>Terapkan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Summary -->
    @if($status != 'all' || $tipe != 'all')
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info d-flex align-items-center">
                <i class="fas fa-info-circle me-3 fs-5"></i>
                <div>
                    Menampilkan <strong>{{ $totalOrders }}</strong> pesanan
                    @if($status != 'all')
                        dengan status <strong>{{ $statusOptions[$status] }}</strong>
                    @endif
                    @if($tipe != 'all')
                        @if($status != 'all') dan @else dengan @endif tipe <strong>{{ $tipeOptions[$tipe] }}</strong>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Orders Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light py-3">
                    <h5 class="card-title mb-0">Daftar Pesanan</h5>
                </div>
                <div class="card-body p-0">
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">No. Pesanan</th>
                                        <th>Customer</th>
                                        <th>Tipe</th>
                                        <th>Total</th>
                                        <th>Status Pesanan</th>
                                        <th>Status Bayar</th>
                                        <th>Tanggal</th>
                                        <th class="text-center pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td class="ps-4">
                                            <strong>{{ $order->order_number }}</strong>
                                        </td>
                                        <td>
                                            <div class="fw-medium">{{ $order->nama_lengkap }}</div>
                                            <small class="text-muted">{{ $order->no_telepon }}</small>
                                        </td>
                                        <td>
                                            @if($order->tipe_pesanan == 'website')
                                                <span class="badge bg-info">Online</span>
                                            @else
                                                <span class="badge bg-secondary">POS</span>
                                            @endif
                                        </td>
                                        <td class="fw-bold text-success">
                                            Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
                                        </td>
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
                                        <td>
                                            <small>{{ $order->created_at->format('d/m/Y H:i') }}</small>
                                        </td>
                                        <td class="text-center pe-4">
                                            <div class="d-flex flex-column gap-1">
                                                <a href="{{ route('payment.verification.orders.show', $order->id) }}"
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye me-1"></i>Detail
                                                </a>
                                                @if($order->tipe_pesanan == 'website' && $order->status_pembayaran == 'menunggu_verifikasi')
                                                    <a href="{{ route('payment.verification.show', $order->id) }}"
                                                       class="btn btn-warning btn-sm">
                                                        <i class="fas fa-check-circle me-1"></i>Verifikasi
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination - Manual Solution -->
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
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">Tidak ada pesanan ditemukan</h4>
                            <p class="text-muted">Coba ubah filter pencarian Anda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
