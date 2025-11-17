<nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-store me-2"></i> TOKO **SAUDARA 2**
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#publicNavbar"
            aria-controls="publicNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="publicNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('produk.index') }}">Semua Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('kategori.index') }}">Kategori</a>
                </li>
            </ul>

            <div class="d-flex align-items-center">
                {{-- Form Pencarian --}}
                <div class="me-3 d-none d-lg-block">
                    <form action="{{ route('produk.search') }}" method="GET" role="search" class="d-flex">
                        <input type="search" name="keyword" class="form-control form-control-sm" placeholder="Cari produk..." value="{{ request('keyword') }}" style="width: 250px;">
                    </form>
                </div>

                {{-- Tombol Keranjang --}}
                <a href="{{ route('cart.index') }}" class="btn btn-outline-dark me-3 position-relative" style="color: var(--color-primary); border-color: var(--color-secondary);">
                    <i class="fas fa-shopping-cart fa-lg"></i>
                    <span class="cart-badge position-absolute top-0 start-100 translate-middle badge rounded-pill" id="cart-count-badge" style="background-color: var(--color-danger); font-size: 0.7em;">
                        0
                    </span>
                </a>

                {{-- Tombol Akun --}}
                @auth
                    @php
                        $userRole = Auth::user()->role;
                    @endphp
                    <div class="dropdown">
                        <button class="btn btn-primary-custom dropdown-toggle" type="button" id="userMenuDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->nama_lengkap ?? Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuDropdown">
                            @if ($userRole === 'pelanggan')
                                <li><a class="dropdown-item" href="{{ route('pelanggan.dashboard') }}"><i class="fas fa-tachometer-alt me-2 text-theme-primary"></i>Dashboard Pelanggan</a></li>
                                <li><a class="dropdown-item" href="{{ route('pelanggan.profil') }}"><i class="fas fa-user-edit me-2 text-theme-primary"></i>Profil Saya</a></li>
                                <li><a class="dropdown-item" href="{{ route('pelanggan.pesanan') }}"><i class="fas fa-history me-2 text-theme-primary"></i>Riwayat Pesanan</a></li>
                            @elseif ($userRole === 'admin' || $userRole === 'owner')
                                <li><a class="dropdown-item" href="{{ route('owner.dashboard') }}"><i class="fas fa-user-shield me-2 text-theme-primary"></i>Dashboard Admin/Owner</a></li>
                                <li><a class="dropdown-item" href="{{ route('produk.index') }}"><i class="fas fa-boxes me-2 text-theme-primary"></i>Manajemen Produk</a></li>
                            @elseif ($userRole === 'kasir' || $userRole === 'staff')
                                <li><a class="dropdown-item" href="{{ route('dashboard.staff') }}"><i class="fas fa-cash-register me-2 text-theme-primary"></i>Dashboard Staff/Kasir</a></li>
                                <li><a class="dropdown-item" href="{{ route('pos.new') }}"><i class="fas fa-barcode me-2 text-theme-primary"></i>Mulai Transaksi (POS)</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary-custom btn-sm">
                        <i class="fas fa-sign-in-alt me-1"></i> Masuk
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<style>
    .cart-badge {
        display: none; /* Disembunyikan secara default, akan ditampilkan oleh JS jika count > 0 */
    }
</style>
