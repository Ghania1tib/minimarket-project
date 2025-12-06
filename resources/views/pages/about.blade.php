@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('navbar')
    @include('layouts.partials.header')
@endsection

@section('content')
<div class="content-container">
    <!-- Hero Section -->
    <div class="hero-section rounded-3 mb-5" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="p-4 p-lg-5 text-white">
                    <h1 class="display-5 fw-bold mb-3">Tentang Toko Saudara 2</h1>
                    <p class="lead mb-4" style="opacity: 0.9;">Solusi belanja kebutuhan sehari-hari yang praktis, cepat, dan terpercaya untuk keluarga Indonesia.</p>
                    <div class="d-flex gap-3">
                        <span class="badge bg-light text-theme-primary p-2">Sejak 2020</span>
                        <span class="badge bg-light text-theme-primary p-2">100% Produk Fresh</span>
                        <span class="badge bg-light text-theme-primary p-2">Pengiriman Cepat</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <div class="p-3">
                    <div class="logo-container" style="display: inline-flex; align-items: center; margin-right: 10px;">
                <div class="logo" style="width: 200px; height: 200px; border-radius: 50%; background: linear-gradient(135deg, #5E548E 0%, #9F86C0 100%); display: flex; align-items: center; justify-content: center; color: white; border: 3px solid #9F86C0; box-shadow: 0 5px 15px rgba(94, 84, 142, 0.3);">
                    <img src="{{ asset('storage/logo-toko.png') }}"
                         alt="Toko Saudara Logo"
                         height="200"
                         style="border-radius: 50%;"
                         onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiByeD0iOCIgZmlsbD0iIzVFMzQ4RSIvPgo8cGF0aCBkPSJNMTggMTVIMjJWMjVIMThWMTVaTTI1IDE1SDI5VjI1SDI1VjE1Wk0xMSAxNUgxNVYyNUgxMVYxNVoiIGZpbGw9IndoaXRlIi8+Cjwvc3ZnPg=='">
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Content -->
    <div class="row g-4 mb-5">
        <!-- Our Story -->
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-theme-light d-flex align-items-center">
                    <i class="fas fa-history fa-lg text-theme-primary me-3"></i>
                    <h5 class="mb-0 fw-bold text-theme-primary">Cerita Kami</h5>
                </div>
                <div class="card-body">
                    <p>Toko Saudara 2 lahir dari keinginan untuk memberikan solusi belanja yang lebih praktis dan efisien bagi masyarakat. Dimulai dari toko kelontong kecil di tahun 2020, kami berkembang menjadi platform e-commerce yang melayani ribuan pelanggan setiap bulan.</p>
                    <p class="mb-0">Dengan semangat kekeluargaan dan komitmen pada kualitas, kami terus berinovasi untuk memberikan pengalaman belanja terbaik dengan produk segar, harga kompetitif, dan layanan pelanggan yang responsif.</p>
                </div>
            </div>
        </div>

        <!-- Our Values -->
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-theme-light d-flex align-items-center">
                    <i class="fas fa-heart fa-lg text-danger me-3"></i>
                    <h5 class="mb-0 fw-bold text-theme-primary">Nilai Kami</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center p-3 border rounded">
                                <i class="fas fa-award fa-2x text-warning mb-2"></i>
                                <h6 class="fw-bold mb-1">Kualitas</h6>
                                <p class="small text-muted mb-0">Produk terjamin kualitasnya</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 border rounded">
                                <i class="fas fa-shield-alt fa-2x text-success mb-2"></i>
                                <h6 class="fw-bold mb-1">Keamanan</h6>
                                <p class="small text-muted mb-0">Transaksi aman & terpercaya</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 border rounded">
                                <i class="fas fa-truck fa-2x text-primary mb-2"></i>
                                <h6 class="fw-bold mb-1">Cepat</h6>
                                <p class="small text-muted mb-0">Pengiriman tepat waktu</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 border rounded">
                                <i class="fas fa-headset fa-2x text-info mb-2"></i>
                                <h6 class="fw-bold mb-1">Layanan</h6>
                                <p class="small text-muted mb-0">Support 24/7</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vision & Mission -->
    <div class="row g-4 mb-5">
        <!-- Vision -->
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-theme-light d-flex align-items-center">
                    <i class="fas fa-eye fa-lg text-theme-primary me-3"></i>
                    <h5 class="mb-0 fw-bold text-theme-primary">Visi Kami</h5>
                </div>
                <div class="card-body">
                    <div class="vision-content p-3 rounded" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-left: 4px solid var(--color-primary);">
                        <p class="lead fst-italic mb-0">
                            "Menjadi platform e-commerce terdepan yang menyediakan pengalaman belanja paling nyaman, aman, dan menyenangkan bagi setiap keluarga di Indonesia."
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mission -->
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-theme-light d-flex align-items-center">
                    <i class="fas fa-bullseye fa-lg text-theme-primary me-3"></i>
                    <h5 class="mb-0 fw-bold text-theme-primary">Misi Kami</h5>
                </div>
                <div class="card-body">
                    <div class="mission-list">
                        <div class="d-flex align-items-start mb-3">
                            <div class="mission-icon bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-check-circle text-primary"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Kualitas Produk</h6>
                                <p class="small text-muted mb-0">Menjamin kualitas dan kesegaran setiap produk yang dijual melalui proses seleksi ketat.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <div class="mission-icon bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-users text-success"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Pelayanan Prima</h6>
                                <p class="small text-muted mb-0">Menyediakan layanan pelanggan yang responsif, ramah, dan solutif.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start">
                            <div class="mission-icon bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-lock text-warning"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Keamanan Sistem</h6>
                                <p class="small text-muted mb-0">Membangun ekosistem belanja online yang aman, transparan, dan terpercaya.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-body p-4">
            <div class="row text-center g-4">
                <div class="col-md-3">
                    <div class="stat-number display-6 fw-bold text-theme-primary mb-2">5K+</div>
                    <p class="text-muted mb-0">Pelanggan Setia</p>
                </div>
                <div class="col-md-3">
                    <div class="stat-number display-6 fw-bold text-theme-primary mb-2">10K+</div>
                    <p class="text-muted mb-0">Produk Tersedia</p>
                </div>
                <div class="col-md-3">
                    <div class="stat-number display-6 fw-bold text-theme-primary mb-2">99%</div>
                    <p class="text-muted mb-0">Kepuasan Pelanggan</p>
                </div>
                <div class="col-md-3">
                    <div class="stat-number display-6 fw-bold text-theme-primary mb-2">24/7</div>
                    <p class="text-muted mb-0">Layanan Dukungan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="text-center mt-4">
        <div class="bg-theme-light rounded-3 p-4 mb-4">
            <h4 class="text-theme-primary mb-3">Siap Berbelanja?</h4>
            <p class="text-muted mb-4">Bergabunglah dengan ribuan pelanggan yang telah mempercayakan kebutuhan belanja mereka pada Toko Saudara 2.</p>
            <div class="d-flex gap-3 justify-content-center">
                <a href="{{ route('home') }}" class="btn btn-outline-primary px-4">
                    <i class="fas fa-store me-2"></i> Jelajahi Produk
                </a>
                <a href="{{ route('contact') }}" class="btn btn-primary px-4">
                    <i class="fas fa-headset me-2"></i> Hubungi Kami
                </a>
            </div>
        </div>

        <div class="text-center mt-5 pt-4 border-top">
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="fas fa-home me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
    </div>
</div>

<style>
.hero-section {
    position: relative;
    overflow: hidden;
}
.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
    border-radius: 50%;
}
.stat-number {
    font-size: 2.5rem;
}
.mission-icon {
    flex-shrink: 0;
}
.border {
    border-color: var(--color-light) !important;
}
</style>
@endsection
