@extends('layouts.app')

@section('title', 'Syarat & Ketentuan')

@section('navbar')
    @include('layouts.partials.header')
@endsection

@section('content')
<div class="content-container">
    <h1 class="text-theme-primary mb-4"><i class="fas fa-scroll me-3"></i>Syarat dan Ketentuan Penggunaan</h1>
    <hr>

    <h3 class="mt-5 text-theme-primary">1. Penerimaan Ketentuan</h3>
    <p>Dengan mengakses atau menggunakan layanan Toko Saudara 2, Anda setuju untuk terikat oleh Syarat dan Ketentuan ini.</p>

    <h3 class="mt-5 text-theme-primary">2. Pembelian dan Pembayaran</h3>
    <p>Semua harga yang tertera sudah termasuk PPN (jika berlaku). Pembayaran dapat dilakukan melalui metode yang tersedia saat proses *checkout*.</p>

    <h3 class="mt-5 text-theme-primary">3. Pengembalian dan Penukaran</h3>
    <p>Produk dapat dikembalikan dalam waktu 7 hari sejak penerimaan, asalkan produk dalam kondisi yang sama saat diterima.</p>

    <a href="{{ route('home') }}" class="btn btn-primary-custom mt-4">
        <i class="fas fa-home me-2"></i>Kembali ke Beranda
    </a>
</div>
@endsection
