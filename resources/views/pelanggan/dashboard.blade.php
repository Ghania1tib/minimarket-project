@extends('layouts.pelanggan')

@section('title', 'Dashboard Saya')

@section('content')
    <div class="welcome-section" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%); color: white; padding: 2rem; border-radius: 15px; margin-bottom: 2rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-2">Halo, {{ $user->nama_lengkap ?? $user->name }}!</h1>
                <p class="mb-0 opacity-75">Kelola akun dan pantau pesanan Anda di sini.</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('home') }}" class="btn btn-outline-light me-2">
                    <i class="fas fa-home me-2"></i>Halaman Utama
                </a>
                <a href="{{ route('cart.index') }}" class="btn btn-light" style="color: var(--color-primary);">
                    <i class="fas fa-shopping-cart me-2"></i>Keranjang ({{ $cartCount }})
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row mb-4 g-4">
        <div class="col-md-4">
            <div class="card p-3 text-center" style="border-top: 4px solid var(--color-success); background: var(--color-light);">
                <div class="text-success mb-2"><i class="fas fa-box fa-3x"></i></div>
                <div class="stats-number fw-bold text-theme-primary">{{ $totalOrders ?? 0 }}</div>
                <div class="stats-label text-muted">Total Pesanan</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 text-center" style="border-top: 4px solid var(--color-danger); background: var(--color-light);">
                <div class="text-danger mb-2"><i class="fas fa-clock fa-3x"></i></div>
                <div class="stats-number fw-bold text-theme-primary">{{ $pendingOrders ?? 0 }}</div>
                <div class="stats-label text-muted">Pesanan Menunggu/Diproses</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 text-center" style="border-top: 4px solid var(--color-primary); background: var(--color-light);">
                <div class="text-theme-primary mb-2"><i class="fas fa-shopping-cart fa-3x"></i></div>
                <div class="stats-number fw-bold text-theme-primary">{{ $cartCount ?? 0 }}</div>
                <div class="stats-label text-muted">Item di Keranjang</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-theme-accent">
                    <h5 class="card-title mb-0 text-theme-primary fw-bold">
                        <i class="fas fa-user-edit me-2"></i>Profil Saya
                    </h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="profile-info flex-grow-1">
                        <div class="mb-3 border-bottom pb-2">
                            <strong class="d-block mb-1">Nama:</strong>
                            <span class="text-muted">{{ $user->nama_lengkap ?? $user->name }}</span>
                        </div>
                        <div class="mb-3 border-bottom pb-2">
                            <strong class="d-block mb-1">Email:</strong>
                            <span class="text-muted">{{ $user->email }}</span>
                        </div>
                        <div class="mb-3 border-bottom pb-2">
                            <strong class="d-block mb-1">Telepon:</strong>
                            <span class="text-muted">{{ $user->no_telepon ?? $user->phone ?? 'Belum diatur' }}</span>
                        </div>
                        <div class="mb-3">
                            <strong class="d-block mb-1">Alamat:</strong>
                            <span class="text-muted">{{ $user->alamat ?? $user->address ?? 'Belum diatur' }}</span>
                        </div>
                    </div>
                    <div class="mt-auto pt-3">
                        <a href="{{ route('pelanggan.profil') }}" class="btn btn-primary-custom w-100">
                            <i class="fas fa-edit me-2"></i>Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center bg-theme-accent">
                    <h5 class="card-title mb-0 text-theme-primary fw-bold">
                        <i class="fas fa-history me-2"></i>Riwayat Pesanan Terbaru
                    </h5>
                    <a href="{{ route('pelanggan.pesanan') }}" class="btn btn-primary-custom btn-sm">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body p-0">
                    @if(isset($orders) && $orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-theme-light">
                                    <tr>
                                        <th>No. Pesanan</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td><strong>#{{ $order->order_number ?? $order->id }}</strong></td>
                                            <td>{{ $order->created_at->format('d M Y') }}</td>
                                            <td class="fw-bold" style="color: var(--color-danger);">Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}</td>
                                            <td>
                                                @php
                                                    $status = $order->status_pesanan ?? 'pending';
                                                    $badgeClass = [
                                                        'selesai' => 'bg-success-custom',
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
                                            <td>
                                                <a href="{{ route('pelanggan.pesanan.detail', $order->id) }}" class="btn btn-outline-primary-custom btn-sm" style="color: var(--color-primary); border-color: var(--color-primary);">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-receipt fa-3x text-secondary mb-3"></i>
                            <h4 class="mt-3 mb-2 text-muted">Belum Ada Pesanan</h4>
                            <p class="mb-4 text-muted">Ayo, buat pesanan pertama Anda sekarang juga!</p>
                            <a href="{{ route('home') }}" class="btn btn-primary-custom">
                                <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
