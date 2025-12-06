@extends('layouts.app')

@section('title', 'Hubungi Kami')

@section('navbar')
    @include('layouts.partials.header')
@endsection

@section('content')
<div class="content-container">
    <div class="text-center mb-5">
        <h1 class="text-theme-primary mb-3">
            <i class="fas fa-headset me-2"></i>Hubungi Kami
        </h1>
        <p class="lead text-muted">Kami siap membantu Anda. Silakan hubungi kami melalui saluran berikut:</p>
    </div>

    <div class="row g-4">
        <!-- Email -->
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <div class="icon-wrapper bg-theme-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-envelope fa-2x text-theme-primary"></i>
                    </div>
                    <h5 class="card-title fw-bold text-theme-primary mb-2">Email</h5>
                    <p class="text-muted mb-3">Kirim pertanyaan atau keluhan Anda via email</p>
                    <a href="mailto:saudara2@example.com" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-envelope me-1"></i> saudara2@gmail.com
                    </a>
                </div>
            </div>
        </div>

        <!-- WhatsApp -->
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <div class="icon-wrapper bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fab fa-whatsapp fa-2x text-success"></i>
                    </div>
                    <h5 class="card-title fw-bold text-theme-primary mb-2">WhatsApp</h5>
                    <p class="text-muted mb-3">Chat langsung dengan tim kami</p>
                    <a href="https://wa.me/628123456789" target="_blank" class="btn btn-success btn-sm">
                        <i class="fab fa-whatsapp me-1"></i> 081-2345-6789
                    </a>
                </div>
            </div>
        </div>

        <!-- Google Maps -->
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0 overflow-hidden">
                <div class="card-body p-0">
                    <!-- Map Container -->
                    <div class="ratio ratio-16x9">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15958.694551232437!2d101.4533037!3d0.538018!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5ab3d648ab9c9%3A0xfdf2f0a429bca26f!2sJl.%20Patria%20Sari%20No.1C%2C%20RT.001%2FRW.007%2C%20Umban%20Sari%2C%20Kec.%20Rumbai%2C%20Kota%20Pekanbaru%2C%20Riau%2028266!5e0!3m2!1sen!2sid!4v1698274067898!5m2!1sen!2sid"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            class="rounded-top">
                        </iframe>
                    </div>

                    <!-- Alamat Info -->
                    <div class="p-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-map-marker-alt fa-lg text-danger me-2"></i>
                            <h5 class="card-title fw-bold mb-0 text-theme-primary">Lokasi Toko</h5>
                        </div>
                        <div class="ms-4">
                            <p class="text-muted small mb-1">
                                <i class="fas fa-location-dot text-theme-secondary me-1"></i>
                                Jl. Patria Sari No.1C, RT.001/RW.007
                            </p>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-city text-theme-secondary me-1"></i>
                                Umban Sari, Kec. Rumbai, Kota Pekanbaru
                            </p>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-map-pin text-theme-secondary me-1"></i>
                                Riau 28266
                            </p>
                            <a href="https://maps.google.com/?q=Jl.+Patria+Sari+No.1C,+Pekanbaru,+Riau+28266"
                               target="_blank"
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-directions me-1"></i> Buka di Google Maps
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jam Operasional -->
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <div class="icon-wrapper bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-clock fa-2x text-warning"></i>
                    </div>
                    <h5 class="card-title fw-bold text-theme-primary mb-2">Jam Operasional</h5>
                    <div class="text-start mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                            <span class="fw-medium">Senin - Jumat</span>
                            <span class="badge bg-primary">08:00 - 22:00</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                            <span class="fw-medium">Sabtu - Minggu</span>
                            <span class="badge bg-primary">09:00 - 22:00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="text-center mt-5 pt-4 border-top">
        <div class="d-flex gap-2 justify-content-center">
            <a href="{{ route('home') }}" class="btn btn-outline-primary">
                <i class="fas fa-home me-2"></i>Kembali ke Beranda
            </a>
        </div>
    </div>
</div>

<style>
.icon-wrapper {
    transition: transform 0.3s ease;
}
.card:hover .icon-wrapper {
    transform: scale(1.1);
}
</style>
@endsection
