@extends('layouts.app')

@section('title', $__env->yieldContent('title'))

@section('navbar')
    <nav class="navbar navbar-expand-lg fixed-top navbar-custom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('pelanggan.dashboard') }}">
                <i class="fas fa-store me-2"></i>TOKO SAUDARA 2
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
                                        class="fas fa-sign-out-alt me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
@endsection

@section('content')
    <div class="content-container">
        @yield('content')
    </div>
@endsection
