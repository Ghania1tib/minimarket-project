@extends('layouts.app')

@section('title', 'Syarat & Ketentuan')

@section('navbar')
    @include('layouts.partials.header')
@endsection

@section('content')
    <div class="content-container">
        <!-- Header Section -->
        <div class="text-center mb-5">
            <div class="icon-wrapper d-inline-flex align-items-center justify-content-center mb-3"
                style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%); border-radius: 50%;">
                <i class="fas fa-scroll fa-2x text-white"></i>
            </div>
            <h1 class="text-theme-primary fw-bold mb-3">Syarat dan Ketentuan</h1>
            <div class="border-top pt-3 mt-3" style="max-width: 300px; margin: 0 auto;"></div>
        </div>

        <!-- Terms Content -->
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <!-- Penerimaan Ketentuan -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-theme-light d-flex align-items-center">
                        <div class="number-circle bg-theme-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 36px; height: 36px;">
                            <span class="fw-bold">1</span>
                        </div>
                        <h5 class="mb-0 fw-bold text-theme-primary">Penerimaan Ketentuan</h5>
                    </div>
                    <div class="card-body">
                        <p>Dengan mengakses atau menggunakan layanan Toko Saudara 2, Anda dianggap telah membaca, memahami,
                            dan setuju untuk terikat oleh seluruh Syarat dan Ketentuan yang berlaku.</p>
                        <p class="mb-0">Penggunaan berkelanjutan layanan kami berarti Anda menerima setiap perubahan atau
                            pembaruan pada syarat dan ketentuan ini.</p>
                    </div>
                </div>

                <!-- Pembelian dan Pembayaran -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-theme-light d-flex align-items-center">
                        <div class="number-circle bg-theme-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 36px; height: 36px;">
                            <span class="fw-bold">2</span>
                        </div>
                        <h5 class="mb-0 fw-bold text-theme-primary">Pembelian dan Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="fw-bold text-theme-secondary mb-2">Harga Produk</h6>
                            <p class="mb-0">Semua harga yang tertera di situs sudah termasuk PPN (jika berlaku) dan biaya
                                lainnya sesuai peraturan yang berlaku.</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-bold text-theme-secondary mb-2">Metode Pembayaran</h6>
                            <p class="mb-0">Pembayaran dapat dilakukan melalui berbagai metode yang tersedia saat proses
                                checkout, termasuk transfer bank, dompet digital, dan pembayaran tunai (COD).</p>
                        </div>
                        <div>
                            <h6 class="fw-bold text-theme-secondary mb-2">Konfirmasi Pesanan</h6>
                            <p class="mb-0">Pesanan akan diproses setelah pembayaran diverifikasi oleh sistem kami. Anda
                                akan menerima notifikasi konfirmasi via email atau WhatsApp.</p>
                        </div>
                    </div>
                </div>

                <!-- Pengembalian dan Penukaran -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-theme-light d-flex align-items-center">
                        <div class="number-circle bg-theme-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 36px; height: 36px;">
                            <span class="fw-bold">3</span>
                        </div>
                        <h5 class="mb-0 fw-bold text-theme-primary">Pengembalian dan Penukaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="fw-bold text-theme-secondary mb-2">Kebijakan Pengembalian</h6>
                            <p class="mb-0">Produk dapat dikembalikan dalam waktu maksimal 7 hari kerja sejak tanggal
                                penerimaan barang, dengan ketentuan:</p>
                            <ul class="mt-2 mb-0">
                                <li>Produk masih dalam kondisi baru dan belum digunakan</li>
                                <li>Kemasan asli produk masih utuh dan tersegel</li>
                                <li>Dilengkapi dengan bukti pembelian yang valid</li>
                                <li>Produk tidak termasuk dalam kategori yang tidak dapat dikembalikan</li>
                            </ul>
                        </div>
                        <div>
                            <h6 class="fw-bold text-theme-secondary mb-2">Proses Penukaran</h6>
                            <p class="mb-0">Untuk penukaran produk, silakan hubungi tim customer service kami dalam waktu
                                3 hari sejak penerimaan produk dengan melampirkan foto kondisi produk.</p>
                        </div>
                    </div>
                </div>

                <!-- Privasi dan Keamanan -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-theme-light d-flex align-items-center">
                        <div class="number-circle bg-theme-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 36px; height: 36px;">
                            <span class="fw-bold">4</span>
                        </div>
                        <h5 class="mb-0 fw-bold text-theme-primary">Privasi dan Keamanan</h5>
                    </div>
                    <div class="card-body">
                        <p>Kami berkomitmen untuk melindungi privasi dan data pribadi Anda. Informasi yang Anda berikan
                            hanya akan digunakan untuk keperluan pemrosesan pesanan dan peningkatan layanan.</p>
                        <p class="mb-0">Selengkapnya mengenai pengelolaan data pribadi dapat dilihat pada <a
                                href="#" class="text-decoration-none fw-bold text-theme-primary">Kebijakan Privasi</a>
                            kami.</p>
                    </div>
                </div>

                <!-- Informasi Kontak -->
                <div class="alert alert-info border-0 shadow-sm">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-info-circle fa-lg me-3 mt-1"></i>
                        <div>
                            <h6 class="alert-heading mb-2 fw-bold">Pertanyaan Lebih Lanjut?</h6>
                            <p class="mb-2">Jika Anda memiliki pertanyaan mengenai Syarat dan Ketentuan ini, silakan
                                hubungi tim dukungan kami:</p>
                            <div class="d-flex gap-3">
                                <a href="mailto:saudara2@example.com" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-envelope me-1"></i> Email
                                </a>
                                <a href="https://wa.me/628123456789" target="_blank" class="btn btn-sm btn-outline-success">
                                    <i class="fab fa-whatsapp me-1"></i> WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="text-center mt-5 pt-4 border-top">
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="fas fa-home me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .number-circle {
            font-size: 0.9rem;
        }

        .card-header {
            border-bottom: 2px solid var(--color-accent) !important;
        }

        .card-body ul {
            padding-left: 1.5rem;
        }

        .card-body ul li {
            margin-bottom: 0.5rem;
        }
    </style>
@endsection
