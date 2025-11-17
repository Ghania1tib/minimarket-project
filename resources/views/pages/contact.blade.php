@extends('layouts.app')

@section('title', 'Hubungi Kami')

@section('navbar')
    @include('layouts.partials.header')
@endsection

@section('content')
<div class="content-container">
    <h1 class="text-theme-primary mb-4"><i class="fas fa-headset me-3"></i>Hubungi Toko Saudara 2</h1>
    <hr>
    <p class="lead">Kami siap membantu Anda. Silakan hubungi kami melalui saluran berikut:</p>

    <div class="row mt-5">
        <div class="col-md-6 mb-4">
            <div class="card p-4 text-center h-100 bg-theme-light">
                <i class="fas fa-envelope fa-3x mb-3 text-theme-primary"></i>
                <h5 class="card-title fw-bold">Email Layanan Pelanggan</h5>
                <p class="card-text">saudara2@example.com</p>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card p-4 text-center h-100 bg-theme-light">
                <i class="fab fa-whatsapp fa-3x mb-3 text-success"></i>
                <h5 class="card-title fw-bold">Hotline (WhatsApp)</h5>
                <p class="card-text">081-2345-6789 (Respons Cepat)</p>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card p-4 text-center h-100 bg-theme-light">
                <i class="fas fa-map-marker-alt fa-3x mb-3 text-danger"></i>
                <h5 class="card-title fw-bold">Alamat Kantor Pusat</h5>
                <p class="card-text">Jl. Merdeka No. 45, Jakarta Pusat, Indonesia</p>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card p-4 text-center h-100 bg-theme-light">
                <i class="fas fa-clock fa-3x mb-3 text-secondary"></i>
                <h5 class="card-title fw-bold">Jam Operasional</h5>
                <p class="card-text">Senin - Minggu: 08:00 - 22:00 WIB</p>
            </div>
        </div>
    </div>

    <a href="{{ route('home') }}" class="btn btn-primary-custom mt-4">
        <i class="fas fa-home me-2"></i>Kembali ke Beranda
    </a>
</div>
@endsection
