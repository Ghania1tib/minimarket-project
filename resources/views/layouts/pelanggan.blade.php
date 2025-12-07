@extends('layouts.app')

@section('title', $__env->yieldContent('title'))

@section('navbar')
    <nav class="navbar navbar-expand-lg fixed-top navbar-custom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('pelanggan.dashboard') }}">
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
            <div class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="fas fa-home me-1"></i> Beranda
                    </a>
                </li>
                <a class="nav-link" href="{{ route('cart.index') }}" title="Keranjang Belanja">
                    <i class="fas fa-shopping-cart me-1"></i>Keranjang
                </a>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        title="Menu Akun">
                        <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('pelanggan.profil') }}"><i
                                    class="fas fa-user-edit me-2 text-theme-primary"></i>Profil</a></li>
                        <li><a class="dropdown-item" href="{{ route('pelanggan.pesanan') }}"><i
                                    class="fas fa-history me-2 text-theme-primary"></i>Riwayat Pesanan</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"><i
                                        class="fas fa-sign-out-alt me-2"></i>Keluar</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
@endsection
<br>
@section('content')
    <div class="content-container">
        @yield('content')
    </div>
@endsection
