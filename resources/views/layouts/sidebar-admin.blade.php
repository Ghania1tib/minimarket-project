<div class="admin-sidebar">
    <div class="sidebar-header">
        <div class="user-info">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->nama_lengkap ?? Auth::user()->name, 0, 2)) }}
            </div>
            <div class="user-details">
                <h6 class="username">{{ Auth::user()->nama_lengkap ?? Auth::user()->name }}</h6>
                <span class="user-role">Administrator</span>
            </div>
        </div>
    </div>

    <div class="sidebar-menu">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('produk.*') ? 'active' : '' }}"
                    href="{{ route('produk.index') }}">
                    <i class="fas fa-box me-2"></i>
                    <span>Manajemen Produk</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}"
                    href="{{ route('kategori.index') }}">
                    <i class="fas fa-tags me-2"></i>
                    <span>Manajemen Kategori</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}" href="{{ route('user.index') }}">
                    <i class="fas fa-users me-2"></i>
                    <span>Manajemen User</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('member.*') ? 'active' : '' }}"
                    href="{{ route('member.index') }}">
                    <i class="fas fa-users me-2"></i>
                    <span>Manajemen Member</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('payment.verification.orders.*') ? 'active' : '' }}"
                    href="{{ route('payment.verification.orders.index') }}">
                    <i class="fas fa-clipboard-list me-2"></i>
                    <span>Pesanan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('payment.verification.index') || request()->routeIs('payment.verification.show') ? 'active' : '' }}"
                    href="{{ route('payment.verification.index') }}">
                    <i class="fas fa-check-circle me-2"></i>
                    <span>Verifikasi Pembayaran</span>
                    @php
                        $pendingVerification = \App\Models\Order::where('status_pembayaran', 'menunggu_verifikasi')
                            ->where('tipe_pesanan', 'website')
                            ->count();
                    @endphp
                    @if ($pendingVerification > 0)
                        <span class="badge bg-warning ms-auto">{{ $pendingVerification }}</span>
                    @endif
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('cashier.report') ? 'active' : '' }}"
                    href="{{ route('cashier.report') }}">
                    <i class="fas fa-file-invoice-dollar me-2"></i>
                    <span>Laporan Penjualan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('inventory.check') ? 'active' : '' }}"
                    href="{{ route('inventory.check') }}">
                    <i class="fas fa-search me-2"></i>
                    <span>Cek Stok</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar-footer">
        <a href="{{ route('home') }}" class="btn btn-home mb-2">
            <i class="fas fa-home me-2"></i>
            <span>Beranda Toko</span>
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-logout">
                <i class="fas fa-sign-out-alt me-2"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</div>

<style>
    .admin-sidebar {
        width: 280px;
        height: 100vh;
        background: linear-gradient(180deg, #5E548E 0%, #9F86C0 100%);
        color: white;
        position: fixed;
        left: 0;
        top: 0;
        display: flex;
        flex-direction: column;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }

    .sidebar-header {
        padding: 2rem 1.5rem 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.1rem;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .user-details h6 {
        margin: 0;
        font-weight: 600;
        font-size: 1rem;
    }

    .user-role {
        font-size: 0.8rem;
        opacity: 0.8;
    }

    .sidebar-menu {
        flex: 1;
        padding: 1.5rem 0;
        overflow-y: auto;
    }

    .sidebar-menu .nav-link {
        color: rgba(255, 255, 255, 0.8);
        padding: 12px 1.5rem;
        border: none;
        border-radius: 0;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    .sidebar-menu .nav-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        padding-left: 2rem;
    }

    .sidebar-menu .nav-link.active {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border-right: 4px solid #E0B1CB;
        font-weight: 600;
    }

    .sidebar-menu .nav-link i {
        width: 20px;
        text-align: center;
    }

    .sidebar-menu .badge {
        font-size: 0.7rem;
        padding: 4px 8px;
    }

    .sidebar-footer {
        padding: 1.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    .btn-home {
        width: 100%;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        padding: 10px;
        border-radius: 8px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .btn-home:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-1px);
        color: white;
    }

    .btn-logout {
        width: 100%;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        padding: 10px;
        border-radius: 8px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-logout:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-1px);
    }

    /* Scrollbar styling */
    .sidebar-menu::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar-menu::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
    }

    .sidebar-menu::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 2px;
    }

    .sidebar-menu::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }
</style>
