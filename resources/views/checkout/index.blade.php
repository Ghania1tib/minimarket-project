@extends('layouts.app')

@section('title', 'Checkout - Toko Saudara')

@section('navbar')
    @include('layouts.partials.header')
@endsection

@section('content')
<div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 100vh;">
    <div class="container">
        <!-- Progress Steps -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    <div class="d-flex align-items-center w-75">
                        <div class="d-flex flex-column align-items-center position-relative flex-fill">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px; z-index: 2;">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <span class="text-primary fw-bold">Keranjang</span>
                        </div>
                        <div class="progress flex-fill mx-2" style="height: 4px; margin-top: -30px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                        </div>
                        <div class="d-flex flex-column align-items-center position-relative flex-fill">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px; z-index: 2;">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <span class="text-primary fw-bold">Checkout</span>
                        </div>
                        <div class="progress flex-fill mx-2" style="height: 4px; margin-top: -30px;">
                            <div class="progress-bar bg-secondary" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="d-flex flex-column align-items-center position-relative flex-fill">
                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px; z-index: 2;">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <span class="text-muted">Pembayaran</span>
                        </div>
                        <div class="progress flex-fill mx-2" style="height: 4px; margin-top: -30px;">
                            <div class="progress-bar bg-secondary" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="d-flex flex-column align-items-center position-relative flex-fill">
                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px; z-index: 2;">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="text-muted">Selesai</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Form Checkout -->
            <div class="col-lg-8">
                <form action="{{ route('cart.checkout') }}" method="POST" id="checkout-form">
                    @csrf

                    <!-- Informasi Pengiriman -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-truck me-2"></i> Informasi Pengiriman</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap *</label>
                                    <input type="text" name="nama_lengkap" class="form-control"
                                           value="{{ $user->nama_lengkap ?? $user->name ?? '' }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">No. Telepon *</label>
                                    <input type="text" name="no_telepon" class="form-control"
                                           value="{{ $user->no_telepon ?? '' }}" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat Lengkap *</label>
                                <textarea name="alamat" class="form-control" rows="3" required>{{ $user->alamat ?? '' }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Kota *</label>
                                    <input type="text" name="kota" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Kode Pos</label>
                                    <input type="text" name="kode_pos" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Metode Pengiriman -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-shipping-fast me-2"></i> Metode Pengiriman</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="metode_pengiriman" id="reguler" value="reguler" checked>
                                <label class="form-check-label d-flex justify-content-between w-100" for="reguler">
                                    <div>
                                        <span class="fw-bold">Reguler</span>
                                        <p class="mb-0 text-muted">Estimasi 3-5 hari</p>
                                    </div>
                                    <span class="fw-bold text-primary">Rp 15.000</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metode_pengiriman" id="express" value="express">
                                <label class="form-check-label d-flex justify-content-between w-100" for="express">
                                    <div>
                                        <span class="fw-bold">Express</span>
                                        <p class="mb-0 text-muted">Estimasi 1-2 hari</p>
                                    </div>
                                    <span class="fw-bold text-primary">Rp 25.000</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i> Metode Pembayaran</h5>
                        </div>
                        <div class="card-body">
                            <div class="payment-methods">
                                @php
                                $paymentMethods = [
                                    ['id' => 'transfer', 'icon' => 'fas fa-university', 'color' => 'primary', 'title' => 'Transfer Bank', 'subtitle' => 'BCA, BNI, BRI, Mandiri'],
                                    ['id' => 'cod', 'icon' => 'fas fa-money-bill-wave', 'color' => 'success', 'title' => 'Cash on Delivery (COD)', 'subtitle' => 'Bayar ketika barang sampai'],
                                    ['id' => 'ewallet', 'icon' => 'fas fa-wallet', 'color' => 'warning', 'title' => 'E-Wallet', 'subtitle' => 'Gopay, OVO, Dana, LinkAja']
                                ];
                                @endphp

                                @foreach ($paymentMethods as $method)
                                <div class="payment-method mb-3" onclick="selectPayment('{{ $method['id'] }}')">
                                    <input type="radio" name="metode_pembayaran" value="{{ $method['id'] }}" id="{{ $method['id'] }}" {{ $method['id'] == 'transfer' ? 'checked' : '' }} hidden>
                                    <div class="d-flex align-items-center p-3 border rounded-3 transition-all payment-option">
                                        <i class="{{ $method['icon'] }} fa-2x me-3 text-{{ $method['color'] }}"></i>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">{{ $method['title'] }}</h6>
                                            <small class="text-muted">{{ $method['subtitle'] }}</small>
                                        </div>
                                        <i class="fas fa-check-circle text-success d-none"></i>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Catatan Pesanan -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i> Catatan Pesanan (Opsional)</h5>
                        </div>
                        <div class="card-body">
                            <textarea name="catatan" class="form-control" rows="3" placeholder="Contoh: Tolong dikirim sebelum jam 5 sore, atau catatan khusus lainnya..."></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="col-lg-4">
                <div class="card shadow-lg sticky-top" style="top: 20px;">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0"><i class="fas fa-receipt me-2"></i> Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <!-- Daftar Produk -->
                        <div class="mb-3">
                            <h6 class="fw-bold mb-3">Produk Dipesan</h6>
                            @foreach($cartItems as $item)
                            <div class="d-flex justify-content-between align-items-start mb-3 border-bottom pb-3">
                                <div class="d-flex">
                                    <img src="{{ $item->product->gambar ?? '/images/placeholder-product.jpg' }}"
                                         class="rounded me-3" alt="{{ $item->product->nama_produk }}"
                                         style="width: 60px; height: 60px; object-fit: cover;">
                                    <div>
                                        <h6 class="mb-1 fw-bold">{{ $item->product->nama_produk }}</h6>
                                        <p class="mb-1 text-muted small">{{ $item->quantity }} x Rp {{ number_format($item->product->harga_jual, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <span class="fw-bold text-primary">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>

                        <!-- Rincian Biaya -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal Produk:</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Biaya Pengiriman:</span>
                                <span id="shipping-cost">Rp 15.000</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Biaya Layanan:</span>
                                <span>Rp 0</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="fw-bold fs-5">Total Bayar:</span>
                                <span class="fw-bold fs-5 text-primary" id="total-payment">Rp {{ number_format($total + 15000, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Tombol Konfirmasi -->
                        <button type="submit" form="checkout-form" class="btn btn-primary btn-lg w-100 py-3 mb-3">
                            <i class="fas fa-lock me-2"></i> Konfirmasi & Bayar
                        </button>

                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Keranjang
                        </a>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1 text-primary"></i>
                                Transaksi Anda aman dan terenkripsi
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .payment-option {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-option:hover {
        border-color: var(--color-primary) !important;
        background-color: rgba(94, 84, 142, 0.05);
    }

    .payment-method.selected .payment-option {
        border-color: var(--color-primary) !important;
        background-color: rgba(94, 84, 142, 0.1);
    }

    .payment-method.selected .fa-check-circle {
        display: block !important;
    }

    .sticky-top {
        position: sticky;
        z-index: 10;
    }
</style>
@endpush

@push('scripts')
<script>
    function selectPayment(method) {
        document.querySelectorAll('.payment-method').forEach(pm => {
            pm.classList.remove('selected');
        });
        event.currentTarget.classList.add('selected');
        document.getElementById(method).checked = true;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi metode pembayaran yang terpilih
        const checkedRadio = document.querySelector('input[name="metode_pembayaran"]:checked');
        if (checkedRadio) {
            const methodId = checkedRadio.value;
            document.getElementById(methodId).closest('.payment-method').classList.add('selected');
        }

        // Update biaya pengiriman dan total saat metode pengiriman berubah
        const shippingRadios = document.querySelectorAll('input[name="metode_pengiriman"]');
        shippingRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                const shippingCost = this.value === 'express' ? 25000 : 15000;
                document.getElementById('shipping-cost').textContent = 'Rp ' + shippingCost.toLocaleString('id-ID');

                const subtotal = {{ $total }};
                const totalPayment = subtotal + shippingCost;
                document.getElementById('total-payment').textContent = 'Rp ' + totalPayment.toLocaleString('id-ID');
            });
        });

        // Validasi form sebelum submit
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let valid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.classList.add('is-invalid');

                    // Scroll ke field yang error
                    if (valid === false) {
                        field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!valid) {
                e.preventDefault();
                // Tampilkan pesan error
                const errorAlert = document.createElement('div');
                errorAlert.className = 'alert alert-danger alert-dismissible fade show';
                errorAlert.innerHTML = `
                    <strong>Perhatian!</strong> Harap lengkapi semua field yang wajib diisi.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;

                // Tambahkan alert di atas form
                const form = document.getElementById('checkout-form');
                form.parentNode.insertBefore(errorAlert, form);

                // Auto close alert setelah 5 detik
                setTimeout(() => {
                    if (errorAlert) errorAlert.remove();
                }, 5000);
            }
        });
    });
</script>
@endpush
