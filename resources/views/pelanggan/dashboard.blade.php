@extends('layouts.pelanggan')

@section('title', 'Dashboard Saya')

@section('content')
    <div class="container-fluid py-3">
        <div class="welcome-section mb-3" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%); color: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
            <div class="row align-items-center">
                <div class="col-12">
                    <h1 class="mb-1 fs-4 fw-bold">Halo, {{ $user->nama_lengkap ?? $user->name }}!</h1>
                    <p class="mb-0 opacity-75 fs-6">Kelola akun dan pantau pesanan Anda di sini.</p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3 py-2" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row mb-4 g-3">
            <div class="col-xl-3 col-md-6">
                <div class="card p-3 text-center h-100 border-0 shadow-sm">
                    <div class="text-success mb-2"><i class="fas fa-box fa-lg"></i></div>
                    <div class="stats-number fw-bold text-theme-primary fs-5 mb-1">{{ $totalOrders ?? 0 }}</div>
                    <div class="stats-label text-muted small">Total Pesanan</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card p-3 text-center h-100 border-0 shadow-sm">
                    <div class="text-danger mb-2"><i class="fas fa-clock fa-lg"></i></div>
                    <div class="stats-number fw-bold text-theme-primary fs-5 mb-1">{{ $pendingOrders ?? 0 }}</div>
                    <div class="stats-label text-muted small">Pesanan Menunggu</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card p-3 text-center h-100 border-0 shadow-sm">
                    <div class="text-theme-primary mb-2"><i class="fas fa-shopping-cart fa-lg"></i></div>
                    <div class="stats-number fw-bold text-theme-primary fs-5 mb-1">{{ $cartCount ?? 0 }}</div>
                    <div class="stats-label text-muted small">Item di Keranjang</div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-lg-5 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-theme-accent py-2">
                        <h5 class="card-title mb-0 text-theme-primary fw-bold fs-6">
                            <i class="fas fa-user-edit me-1"></i>Profil Saya
                        </h5>
                    </div>
                    <div class="card-body d-flex flex-column p-3">
                        <div class="profile-info flex-grow-1">
                            <div class="mb-2 pb-2 border-bottom">
                                <strong class="d-block mb-1 small text-dark">Nama:</strong>
                                <span class="text-muted small">{{ $user->nama_lengkap ?? $user->name }}</span>
                            </div>
                            <div class="mb-2 pb-2 border-bottom">
                                <strong class="d-block mb-1 small text-dark">Email:</strong>
                                <span class="text-muted small">{{ $user->email }}</span>
                            </div>
                            <div class="mb-2 pb-2 border-bottom">
                                <strong class="d-block mb-1 small text-dark">Telepon:</strong>
                                <span class="text-muted small">{{ $user->no_telepon ?? $user->phone ?? 'Belum diatur' }}</span>
                            </div>
                            <div class="mb-2">
                                <strong class="d-block mb-1 small text-dark">Alamat:</strong>
                                <span class="text-muted small">{{ $user->alamat ?? $user->address ?? 'Belum diatur' }}</span>
                            </div>
                        </div>
                        <div class="mt-2 pt-2">
                            <a href="{{ route('pelanggan.profil') }}" class="btn btn-primary-custom w-100 py-1 btn-sm">
                                <i class="fas fa-edit me-1"></i>Edit Profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center bg-theme-accent py-2">
                        <h5 class="card-title mb-0 text-theme-primary fw-bold fs-6">
                            <i class="fas fa-history me-1"></i>Riwayat Pesanan
                        </h5>
                        <a href="{{ route('pelanggan.pesanan') }}" class="btn btn-primary-custom btn-sm px-2 py-1">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="card-body p-0">
                        @if(isset($orders) && $orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead class="bg-theme-light small">
                                        <tr>
                                            <th class="ps-3">No. Pesanan</th>
                                            <th>Tanggal</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th class="pe-3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr class="small">
                                                <td class="ps-3"><strong>#{{ $order->order_number ?? $order->id }}</strong></td>
                                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                                <td class="fw-bold" style="color: var(--color-danger);">Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}</td>
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
                                                    <span class="badge {{ $badgeClass }} small">
                                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                                    </span>
                                                </td>
                                                <td class="pe-3">
                                                    <a href="{{ route('pelanggan.pesanan.detail', $order->id) }}" class="btn btn-outline-primary-custom btn-sm py-0 px-2" style="color: var(--color-primary); border-color: var(--color-primary); font-size: 0.75rem;">
                                                        <i class="fas fa-eye me-1"></i>Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4 px-3">
                                <i class="fas fa-receipt fa-2x text-secondary mb-2"></i>
                                <h6 class="mt-2 mb-1 text-muted">Belum Ada Pesanan</h6>
                                <p class="mb-3 text-muted small">Ayo, buat pesanan pertama Anda sekarang juga!</p>
                                <a href="{{ route('home') }}" class="btn btn-primary-custom btn-sm px-3">
                                    <i class="fas fa-shopping-bag me-1"></i>Mulai Belanja
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border-radius: 8px;
        }
        .btn-primary-custom {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            color: white;
            font-size: 0.875rem;
        }
        .btn-primary-custom:hover {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
        }
        .btn-outline-primary-custom {
            background-color: transparent;
            color: var(--color-primary);
            border: 1px solid var(--color-primary);
        }
        .btn-outline-primary-custom:hover {
            background-color: var(--color-primary);
            color: white;
        }
        .table-sm td, .table-sm th {
            padding: 0.5rem;
        }
        .bg-theme-accent {
            background-color: rgba(var(--color-primary-rgb), 0.1) !important;
        }
    </style>
@endsection
