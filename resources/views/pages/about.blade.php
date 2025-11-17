@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('navbar')
    @include('layouts.partials.header')
@endsection

@section('content')
<div class="content-container">
    <h1 class="text-theme-primary mb-4"><i class="fas fa-info-circle me-3"></i>Tentang Toko Saudara 2</h1>
    <hr>
    <p class="lead">Kami adalah Toko Saudara 2, penyedia kebutuhan harian Anda yang berkomitmen pada kualitas dan pelayanan terbaik.</p>
    <p>Dibangun dengan semangat untuk memudahkan belanja, kami menawarkan berbagai produk segar, makanan, minuman, dan kebutuhan rumah tangga dengan harga kompetitif dan jaminan pengiriman cepat.</p>

    <h3 class="mt-5 text-theme-primary">Visi Kami</h3>
    <p>Menjadi platform *e-commerce* terdepan yang menyediakan pengalaman belanja paling nyaman dan menyenangkan bagi setiap keluarga.</p>

    <h3 class="mt-5 text-theme-primary">Misi Kami</h3>
    <ul>
        <li>Menjamin kualitas dan kesegaran setiap produk yang dijual.</li>
        <li>Menyediakan layanan pelanggan yang responsif dan solutif.</li>
        <li>Membangun ekosistem belanja *online* yang aman dan terpercaya.</li>
    </ul>

    <a href="{{ route('home') }}" class="btn btn-primary-custom mt-4">
        <i class="fas fa-home me-2"></i>Kembali ke Beranda
    </a>
</div>
@endsection
