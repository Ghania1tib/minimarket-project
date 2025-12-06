<nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <!-- Logo container dari login page -->
            <div class="logo-container" style="display: inline-flex; align-items: center; margin-right: 10px;">
                <div class="logo" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #5E548E 0%, #9F86C0 100%); display: flex; align-items: center; justify-content: center; color: white; border: 3px solid #9F86C0; box-shadow: 0 5px 15px rgba(94, 84, 142, 0.3);">
                    <img src="{{ asset('storage/logo-toko.png') }}"
                         alt="Toko Saudara Logo"
                         height="50"
                         style="border-radius: 50%;"
                         onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiByeD0iOCIgZmlsbD0iIzVFMzQ4RSIvPgo8cGF0aCBkPSJNMTggMTVIMjJWMjVIMThWMTVaTTI1IDE1SDI5VjI1SDI1VjE1Wk0xMSAxNUgxNVYyNUgxMVYxNVoiIGZpbGw9IndoaXRlIi8+Cjwvc3ZnPg=='">
                </div>
            </div>
            <span class="brand-text" style="color: #5E548E !important; font-weight: 700; font-size: 1.5rem;">TOKO SAUDARA 2</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#publicNavbar"
            aria-controls="publicNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="publicNavbar">
            <!-- Menu Aksi -->
            <div class="d-flex align-items-left ms-auto">
                {{-- Tombol Keranjang - DIUBAH WARNA --}}
                <a href="{{ route('cart.index') }}" class="btn btn-cart me-3 position-relative"
                   style="border-color: #5E548E !important; color: #5E548E !important;">
                    <i class="fas fa-shopping-cart fa-lg"></i>
                    <span class="cart-badge position-absolute top-0 start-100 translate-middle badge rounded-pill"
                        id="cart-count-badge" style="display: none; background-color: #E07A5F !important;">
                        0
                    </span>
                    <span class="cart-text ms-1 d-none d-sm-inline"></span>
                </a>

                {{-- Tombol Akun - DIUBAH WARNA BUTTON --}}
                @auth
                    @php
                        $userRole = Auth::user()->role;
                        $userInitials = strtoupper(substr(Auth::user()->nama_lengkap ?? Auth::user()->name, 0, 2));

                        // Tentukan route dashboard berdasarkan role
                        $dashboardRoute = '';
                        $dashboardText = '';
                        $dashboardIcon = 'fas fa-tachometer-alt';

                        if ($userRole === 'customer' || $userRole === 'pelanggan') {
                            $dashboardRoute = route('pelanggan.dashboard');
                            $dashboardText = 'Dashboard Pelanggan';
                        } elseif ($userRole === 'admin' || $userRole === 'owner') {
                            $dashboardRoute = route('admin.dashboard');
                            $dashboardText = 'Dashboard Admin';
                            $dashboardIcon = 'fas fa-user-shield';
                        } elseif ($userRole === 'kasir' || $userRole === 'staff') {
                            $dashboardRoute = route('dashboard.staff');
                            $dashboardText = 'Dashboard Staff';
                            $dashboardIcon = 'fas fa-cash-register';
                        }
                    @endphp
                    <div class="dropdown">
                        <button class="btn btn-user dropdown-toggle d-flex align-items-center" type="button"
                            id="userMenuDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                            style="border-color: #5E548E !important; color: #5E548E !important;">
                            <div class="user-avatar me-2">
                                {{ $userInitials }}
                            </div>
                            <span class="user-name d-none d-md-inline">
                                {{ Auth::user()->nama_lengkap ?? Auth::user()->name }}
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuDropdown">
                            <!-- Header User Info -->
                            <li class="dropdown-header">
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-2">
                                        {{ $userInitials }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ Auth::user()->nama_lengkap ?? Auth::user()->name }}</div>
                                        <small class="text-muted">
                                            @if ($userRole === 'pelanggan')
                                                Pelanggan
                                            @elseif($userRole === 'admin')
                                                Administrator
                                            @elseif($userRole === 'owner')
                                                Owner
                                            @elseif($userRole === 'kasir')
                                                Kasir
                                            @elseif($userRole === 'staff')
                                                Staff
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>

                            <!-- Tombol Dashboard -->
                            @if(!empty($dashboardRoute))
                                <li>
                                    <a class="dropdown-item dashboard-item" href="{{ $dashboardRoute }}">
                                        <i class="{{ $dashboardIcon }} me-2"></i>{{ $dashboardText }}
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            @endif

                            <!-- Menu berdasarkan role -->
                            @if ($userRole === 'pelanggan')
                                <li>
                                    <a class="dropdown-item" href="{{ route('pelanggan.profil') }}">
                                        <i class="fas fa-user-edit me-2"></i>Profil Saya
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('pelanggan.pesanan') }}">
                                        <i class="fas fa-history me-2"></i>Riwayat Pesanan
                                    </a>
                                </li>
                            @elseif ($userRole === 'kasir' || $userRole === 'staff')
                                <li>
                                    <a class="dropdown-item" href="{{ route('pos.new') }}">
                                        <i class="fas fa-barcode me-2"></i>Transaksi POS
                                    </a>
                                </li>
                            @endif

                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    {{-- Button Masuk & Daftar - DIUBAH WARNA --}}
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm"
                           style="background-color: #5E548E !important; border-color: #5E548E !important; color: white !important;">
                            <i class="fas fa-sign-in-alt me-1"></i> Masuk
                        </a>
                        <a href="{{ route('signup') }}" class="btn btn-primary btn-sm"
                           style="background-color: #5E548E !important; border-color: #5E548E !important; color: white !important;">
                            <i class="fas fa-user-plus me-1"></i> Daftar
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<style>
    /* CSS NAVBAR CUSTOM - DIUBAH WARNA BACKGROUND */
    .navbar-custom {
        background-color: #E0B1CB; /* Tetap menggunakan warna accent */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 12px 0;
        transition: all 0.3s ease;
    }

    .navbar-custom.scrolled {
        padding: 8px 0;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }

    /* NAVBAR BRAND - DIUBAH WARNA */
    .navbar-brand {
        font-weight: 700;
        font-size: 1.5rem;
        color: #5E548E !important; /* Warna ungu tema */
        display: flex;
        align-items: center;
    }

    .brand-text {
        color: #5E548E !important; /* Warna ungu tema */
    }

    /* NAV LINK - DIUBAH WARNA */
    .nav-link {
        color: #5E548E !important; /* Warna ungu tema */
        font-weight: 500;
        padding: 8px 15px !important;
        border-radius: 8px;
        margin: 0 2px;
        transition: all 0.3s ease;
    }

    .nav-link:hover,
    .nav-link.active {
        color: #5E548E !important; /* Tetap ungu */
        background: rgba(94, 84, 142, 0.1); /* Warna ungu dengan opacity */
        transform: translateY(-1px);
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 8px;
        margin-top: 8px;
        min-width: 220px;
    }

    .dropdown-item {
        border-radius: 6px;
        padding: 8px 12px;
        margin: 2px 0;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
    }

    .dropdown-item:hover {
        background-color: #5E548E !important; /* Warna ungu tema */
        color: white !important;
        transform: translateX(3px);
    }

    .dropdown-header {
        padding: 12px 16px;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 8px;
    }

    /* BUTTON CART - DIUBAH WARNA */
    .btn-cart {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(94, 84, 142, 0.3); /* Border ungu */
        color: #5E548E !important; /* Warna ungu */
        border-radius: 8px;
        padding: 8px 12px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }

    .btn-cart:hover {
        background: rgba(94, 84, 142, 0.1); /* Background ungu saat hover */
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(94, 84, 142, 0.2); /* Shadow ungu */
        color: #5E548E !important; /* Tetap ungu */
    }

    .cart-badge {
        background: #E07A5F !important; /* Warna danger tema */
        font-size: 0.65rem;
        padding: 4px 6px;
        min-width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    /* BUTTON USER - DIUBAH WARNA */
    .btn-user {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(94, 84, 142, 0.3); /* Border ungu */
        color: #5E548E !important; /* Warna ungu */
        border-radius: 8px;
        padding: 6px 12px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }

    .btn-user:hover {
        background: rgba(94, 84, 142, 0.1); /* Background ungu saat hover */
        transform: translateY(-2px);
        color: #5E548E !important; /* Tetap ungu */
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #5E548E, #9F86C0); /* Gradient ungu tema */
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .user-name {
        font-weight: 500;
        max-width: 120px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #5E548E; /* Warna ungu */
    }

    .navbar-toggler {
        border: 1px solid rgba(94, 84, 142, 0.3); /* Border ungu */
        padding: 4px 8px;
    }

    /* DASHBOARD ITEM - DIUBAH WARNA */
    .dashboard-item {
        background: linear-gradient(135deg, #5E548E 0%, #9F86C0 100%) !important; /* Gradient ungu tema */
        color: white !important;
        font-weight: 600;
        margin: 5px 0;
        border-radius: 6px;
        border: none;
    }

    .dashboard-item:hover {
        background: linear-gradient(135deg, #4d4579 0%, #8a73ad 100%) !important; /* Gradient ungu lebih gelap */
        color: white !important;
        transform: translateX(3px);
    }

    .dashboard-item i {
        color: white !important;
    }

    /* Pastikan item dashboard tidak terpengaruh hover default */
    .dropdown-item.dashboard-item:hover {
        background: linear-gradient(135deg, #4d4579 0%, #8a73ad 100%) !important;
        color: white !important;
    }

    /* Dropdown divider styling */
    .dropdown-divider {
        margin: 8px 0;
        border-color: rgba(94, 84, 142, 0.1); /* Warna ungu dengan opacity */
    }

    /* HOVER EFFECT UNTUK DROPDOWN ITEM REGULAR */
    .dropdown-item:not(.dashboard-item):hover {
        background-color: #5E548E !important; /* Warna ungu */
        color: white !important;
    }

    @media (max-width: 991.98px) {
        .navbar-collapse {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin-top: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .nav-link {
            padding: 10px 15px !important;
            margin: 2px 0;
            color: #5E548E !important; /* Warna ungu untuk mobile */
        }

        .btn-cart,
        .btn-user {
            margin: 5px 0;
        }

        .dropdown-menu {
            min-width: 200px;
        }

        /* Untuk logo di mobile */
        .navbar-brand .logo {
            width: 50px !important;
            height: 50px !important;
        }

        .navbar-brand .logo img {
            height: 45px !important;
        }
    }
</style>

<script>
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar-custom');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Initialize navbar state
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.querySelector('.navbar-custom');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        }

        // Update active nav link based on current page
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });

        // Debug: Log untuk memastikan dropdown berfungsi
        console.log('Navbar initialized');
        console.log('User role: {{ Auth::check() ? Auth::user()->role : "Guest" }}');

        @auth
            @php
                $userRole = Auth::user()->role;
                if ($userRole === 'pelanggan') {
                    $dashboardRoute = route('pelanggan.dashboard');
                } elseif ($userRole === 'admin' || $userRole === 'owner') {
                    $dashboardRoute = route('admin.dashboard');
                } elseif ($userRole === 'kasir' || $userRole === 'staff') {
                    $dashboardRoute = route('dashboard.staff');
                } else {
                    $dashboardRoute = '';
                }
            @endphp
            console.log('Dashboard route: {{ $dashboardRoute }}');
        @endauth
    });

    // Fungsi untuk update cart count
    function updateCartCount() {
        // Implementasi fungsi update cart count
        console.log('Updating cart count...');
    }
</script>
