@extends('layouts.admin-base')

@section('title', 'Verifikasi Pembayaran')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Verifikasi Pembayaran</h1>

            <!-- Filter Status -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">Filter Pesanan</h5>
                            <div class="btn-group" role="group">
                                <a href="{{ route('payment.verification.index', ['status' => 'menunggu_verifikasi']) }}"
                                   class="btn btn-{{ $status == 'menunggu_verifikasi' ? 'primary' : 'outline-primary' }}">
                                    Menunggu Verifikasi
                                    <span class="badge bg-danger ms-1">
                                        {{ \App\Models\Order::where('status_pembayaran', 'menunggu_verifikasi')->where('tipe_pesanan', 'website')->count() }}
                                    </span>
                                </a>
                                <a href="{{ route('payment.verification.index', ['status' => 'semua']) }}"
                                   class="btn btn-{{ $status == 'semua' ? 'primary' : 'outline-primary' }}">
                                    Semua Status
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Total: {{ $orders->total() }} pesanan
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Pesanan -->
            <div class="card">
                <div class="card-body">
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No. Pesanan</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Metode Bayar</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <strong>{{ $order->order_number }}</strong>
                                        </td>
                                        <td>
                                            <div>{{ $order->nama_lengkap }}</div>
                                            <small class="text-muted">{{ $order->no_telepon }}</small>
                                        </td>
                                        <td class="text-success fw-bold">
                                            Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <span class="badge bg-info text-uppercase">
                                                {{ $order->metode_pembayaran }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($order->status_pembayaran == 'menunggu_verifikasi')
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-clock me-1"></i>Menunggu Verifikasi
                                                </span>
                                            @elseif($order->status_pembayaran == 'terverifikasi')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Terverifikasi
                                                </span>
                                            @elseif($order->status_pembayaran == 'ditolak')
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times me-1"></i>Ditolak
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">{{ $order->status_pembayaran }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ $order->created_at->format('d/m/Y H:i') }}</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('payment.verification.show', $order->id) }}"
                                               class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye me-1"></i>Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h4>Tidak ada pesanan yang perlu diverifikasi</h4>
                            <p class="text-muted">Semua pembayaran sudah terverifikasi.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
