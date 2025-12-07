@extends('layouts.pelanggan')
@section('title', 'Dashboard Saya')
@section('content')
<div class="container py-4">
    <!-- Welcome Card -->
    <div class="card border-0 shadow-lg mb-4 overflow-hidden" style="border-radius: 15px;">
        <div class="card-body p-4" style="background: linear-gradient(135deg, #5E548E 0%, #9F86C0 100%);">
            <div class="row align-items-center">
                <div class="col-12">
                    <h1 class="text-white mb-2 fw-bold fs-4">
                        <i class="fas fa-hand-wave me-2"></i>Halo, {{ $user->nama_lengkap ?? $user->name }}!
                    </h1>
                    <p class="text-white mb-0 opacity-90 fs-6">
                        Selamat datang di dashboard akun Anda. Kelola profil dan pantau pesanan dengan mudah.
                    </p>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="border-radius: 10px;">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle fs-5 text-success me-3"></i>
            <div class="flex-grow-1">
                <strong class="fw-semibold">Sukses!</strong>
                <p class="mb-0">{{ session('success') }}</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="row mb-4 g-3">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-4 text-center">
                    <div class="icon-container mb-3">
                        <div class="p-3 rounded-circle d-inline-flex" style="background: linear-gradient(135deg, rgba(94, 84, 142, 0.1) 0%, rgba(159, 134, 192, 0.1) 100%);">
                            <i class="fas fa-box fa-lg text-theme-primary"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-theme-primary mb-1">{{ $totalOrders ?? 0 }}</h3>
                    <p class="text-muted small mb-0">Total Pesanan</p>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-theme-primary" role="progressbar" style="width: 85%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-4 text-center">
                    <div class="icon-container mb-3">
                        <div class="p-3 rounded-circle d-inline-flex" style="background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(248, 108, 107, 0.1) 100%);">
                            <i class="fas fa-clock fa-lg text-danger"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-danger mb-1">{{ $pendingOrders ?? 0 }}</h3>
                    <p class="text-muted small mb-0">Menunggu Verifikasi</p>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 60%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-4 text-center">
                    <div class="icon-container mb-3">
                        <div class="p-3 rounded-circle d-inline-flex" style="background: linear-gradient(135deg, rgba(25, 135, 84, 0.1) 0%, rgba(112, 193, 179, 0.1) 100%);">
                            <i class="fas fa-check-circle fa-lg text-success"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-success mb-1">{{ ($totalOrders ?? 0) - ($pendingOrders ?? 0) }}</h3>
                    <p class="text-muted small mb-0">Pesanan Selesai</p>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 75%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-4 text-center">
                    <div class="icon-container mb-3">
                        <div class="p-3 rounded-circle d-inline-flex" style="background: linear-gradient(135deg, rgba(13, 110, 253, 0.1) 0%, rgba(159, 134, 192, 0.1) 100%);">
                            <i class="fas fa-shopping-cart fa-lg text-info"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-info mb-1">{{ $cartCount ?? 0 }}</h3>
                    <p class="text-muted small mb-0">Item di Keranjang</p>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 45%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Profile Section -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-header border-0 bg-white pt-4 pb-3 px-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-theme-light p-3 me-3 rounded-circle">
                            <i class="fas fa-user-edit fa-lg text-theme-primary"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-theme-primary mb-1">Profil Saya</h5>
                            <p class="text-muted small mb-0">Kelola informasi akun Anda</p>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="profile-details">
                        <div class="detail-item d-flex align-items-center mb-3 pb-3 border-bottom">
                            <div class="icon-container me-3">
                                <i class="fas fa-user text-theme-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <small class="text-muted d-block mb-1">Nama Lengkap</small>
                                <span class="fw-semibold">{{ $user->nama_lengkap ?? $user->name }}</span>
                            </div>
                        </div>

                        <div class="detail-item d-flex align-items-center mb-3 pb-3 border-bottom">
                            <div class="icon-container me-3">
                                <i class="fas fa-envelope text-theme-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <small class="text-muted d-block mb-1">Email</small>
                                <span class="fw-semibold">{{ $user->email }}</span>
                            </div>
                        </div>

                        <div class="detail-item d-flex align-items-center mb-3 pb-3 border-bottom">
                            <div class="icon-container me-3">
                                <i class="fas fa-phone text-theme-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <small class="text-muted d-block mb-1">Telepon</small>
                                <span class="fw-semibold">{{ $user->no_telepon ?? $user->phone ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="detail-item d-flex align-items-center mb-3">
                            <div class="icon-container me-3">
                                <i class="fas fa-map-marker-alt text-theme-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <small class="text-muted d-block mb-1">Alamat</small>
                                <span class="fw-semibold">{{ $user->alamat ?? $user->address ?? 'Belum diatur' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <a href="{{ route('pelanggan.profil') }}" class="btn btn-theme-primary w-100 py-2 fw-semibold">
                            <i class="fas fa-edit me-2"></i>Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order History -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-header border-0 bg-white pt-4 pb-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-theme-light p-3 me-3 rounded-circle">
                                <i class="fas fa-history fa-lg text-theme-primary"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-theme-primary mb-1">Riwayat Pesanan</h5>
                                <p class="text-muted small mb-0">Pesanan terbaru Anda</p>
                            </div>
                        </div>
                        <a href="{{ route('pelanggan.pesanan') }}" class="btn btn-outline-theme-primary btn-sm px-3 py-2 fw-semibold">
                            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body px-4 pb-4">
                    @if(isset($orders) && $orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr class="border-top-0">
                                        <th class="ps-0 border-bottom-0 text-muted small fw-semibold">No. Pesanan</th>
                                        <th class="border-bottom-0 text-muted small fw-semibold">Tanggal</th>
                                        <th class="border-bottom-0 text-muted small fw-semibold">Total</th>
                                        <th class="border-bottom-0 text-muted small fw-semibold">Status</th>
                                        <th class="pe-0 border-bottom-0 text-muted small fw-semibold text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr class="border-top">
                                            <td class="ps-0 align-middle">
                                                <strong class="text-theme-primary">#{{ $order->order_number ?? $order->id }}</strong>
                                            </td>
                                            <td class="align-middle">
                                                <small>{{ $order->created_at->format('d M Y') }}</small>
                                            </td>
                                            <td class="align-middle fw-bold text-dark">
                                                Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="align-middle">
                                                @php
                                                    $status = $order->status_pesanan ?? 'pending';
                                                    $badgeClass = [
                                                        'selesai' => 'bg-success-light text-success',
                                                        'menunggu_pembayaran' => 'bg-warning-light text-warning',
                                                        'menunggu_verifikasi' => 'bg-warning-light text-warning',
                                                        'dibatalkan' => 'bg-danger-light text-danger',
                                                        'diproses' => 'bg-info-light text-info',
                                                        'dikirim' => 'bg-primary-light text-primary',
                                                    ][$status] ?? 'bg-secondary-light text-secondary';
                                                @endphp
                                                <span class="badge rounded-pill fw-semibold px-3 py-1 {{ $badgeClass }}" style="font-size: 0.75rem;">
                                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                                </span>
                                            </td>
                                            <td class="pe-0 align-middle text-end">
                                                <a href="{{ route('pelanggan.pesanan.detail', $order->id) }}"
                                                   class="btn btn-sm btn-outline-theme-primary px-3 py-1">
                                                    <i class="fas fa-eye me-1"></i>Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="icon-circle bg-theme-light p-4 rounded-circle d-inline-flex mb-3">
                                <i class="fas fa-receipt fa-2x text-theme-primary"></i>
                            </div>
                            <h5 class="fw-semibold text-muted mb-2">Belum Ada Pesanan</h5>
                            <p class="text-muted mb-4">Mulai belanja dan buat pesanan pertama Anda!</p>
                            <a href="{{ route('home') }}" class="btn btn-theme-primary px-4 py-2 fw-semibold">
                                <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --color-primary: #5E548E;
        --color-secondary: #9F86C0;
        --color-light: #F0E6EF;
        --border-radius-lg: 15px;
    }

    .text-theme-primary {
        color: var(--color-primary) !important;
    }

    .bg-theme-primary {
        background-color: var(--color-primary) !important;
    }

    .bg-theme-light {
        background-color: var(--color-light) !important;
    }

    .btn-theme-primary {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
        border: none;
        color: white;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-theme-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(94, 84, 142, 0.3);
        color: white;
    }

    .btn-outline-theme-primary {
        color: var(--color-primary);
        border: 2px solid var(--color-primary);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-outline-theme-primary:hover {
        background-color: var(--color-primary);
        color: white;
        transform: translateY(-2px);
    }

    .icon-circle {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card {
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .badge {
        font-weight: 500;
    }

    .bg-success-light {
        background-color: rgba(25, 135, 84, 0.1) !important;
    }

    .bg-warning-light {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }

    .bg-danger-light {
        background-color: rgba(220, 53, 69, 0.1) !important;
    }

    .bg-info-light {
        background-color: rgba(13, 202, 240, 0.1) !important;
    }

    .bg-primary-light {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }

    .bg-secondary-light {
        background-color: rgba(108, 117, 125, 0.1) !important;
    }

    .progress-bar {
        border-radius: 2px;
    }

    .detail-item .icon-container {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, rgba(94, 84, 142, 0.1) 0%, rgba(159, 134, 192, 0.1) 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(94, 84, 142, 0.05);
    }
</style>
@endsection
