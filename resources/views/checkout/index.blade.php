@extends('layouts.app')

@section('title', 'Checkout - Toko Saudara')

@section('navbar')
    @include('layouts.partials.header')
@endsection

@section('content')
<div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 100vh;">
    <div class="container">
        <div class="row g-4">
            <!-- Form Checkout -->
            <div class="col-lg-8">
                <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                    @csrf

                    <!-- Informasi Pengiriman -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-truck me-2"></i> Informasi Pengiriman</h5>
                        </div>
                        <div class="card-body">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Gratis Ongkir!</strong> Untuk wilayah sekitar Rumbai. Sistem akan otomatis mendeteksi alamat Anda.
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap *</label>
                                    <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                           value="{{ old('nama_lengkap', $user->nama_lengkap ?? $user->name ?? '') }}" required>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">No. Telepon *</label>
                                    <input type="text" name="no_telepon" class="form-control @error('no_telepon') is-invalid @enderror"
                                           value="{{ old('no_telepon', $user->no_telepon ?? $user->phone ?? '') }}" required>
                                    @error('no_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat Lengkap *</label>
                                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" required
                                          placeholder="Contoh: Jl. Kaharuddin Nasution Gg. Melati No. 110">{{ old('alamat', $user->alamat ?? $user->address ?? '') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Sertakan nama jalan, gang, dan nomor rumah. Cantumkan 'Rumbai' jika di wilayah Rumbai untuk gratis ongkir.</small>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Kota *</label>
                                    <input type="text" name="kota" class="form-control @error('kota') is-invalid @enderror"
                                           value="{{ old('kota', 'Pekanbaru') }}" required>
                                    @error('kota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Kode Pos</label>
                                    <input type="text" name="kode_pos" class="form-control" value="28284" placeholder="28284">
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
                                    <span class="fw-bold text-primary" id="reguler-cost">Rp 15.000</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metode_pengiriman" id="express" value="express">
                                <label class="form-check-label d-flex justify-content-between w-100" for="express">
                                    <div>
                                        <span class="fw-bold">Express</span>
                                        <p class="mb-0 text-muted">Estimasi 1-2 hari</p>
                                    </div>
                                    <span class="fw-bold text-primary" id="express-cost">Rp 25.000</span>
                                </label>
                            </div>
                            <div class="mt-3 p-3 bg-light rounded">
                                <small class="text-success">
                                    <i class="fas fa-check-circle me-1"></i>
                                    <span id="shipping-info">Gratis ongkir untuk wilayah Rumbai akan diterapkan otomatis</span>
                                </small>
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
                                    ['id' => 'tunai', 'icon' => 'fas fa-money-bill-wave', 'color' => 'success', 'title' => 'Tunai (COD)', 'subtitle' => 'Bayar ketika barang sampai'],
                                    ['id' => 'transfer', 'icon' => 'fas fa-university', 'color' => 'primary', 'title' => 'Transfer Bank', 'subtitle' => 'Mandiri, BCA, BRI, BNI'],
                                    ['id' => 'qris', 'icon' => 'fas fa-qrcode', 'color' => 'warning', 'title' => 'QRIS', 'subtitle' => 'Gopay, OVO, Dana, ShopeePay'],
                                ];
                                @endphp

                                @foreach ($paymentMethods as $method)
                                <div class="payment-method mb-3" data-method="{{ $method['id'] }}">
                                    <input type="radio" name="metode_pembayaran" value="{{ $method['id'] }}" id="{{ $method['id'] }}"
                                           {{ old('metode_pembayaran', 'tunai') == $method['id'] ? 'checked' : '' }} hidden>
                                    <div class="d-flex align-items-center p-3 border rounded-3 transition-all payment-option
                                                {{ old('metode_pembayaran', 'tunai') == $method['id'] ? 'border-primary bg-light' : '' }}">
                                        <i class="{{ $method['icon'] }} fa-2x me-3 text-{{ $method['color'] }}"></i>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">{{ $method['title'] }}</h6>
                                            <small class="text-muted">{{ $method['subtitle'] }}</small>
                                        </div>
                                        <i class="fas fa-check-circle text-success {{ old('metode_pembayaran', 'tunai') == $method['id'] ? '' : 'd-none' }}"></i>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Informasi Pembayaran -->
                            <div class="mt-3 p-3 bg-light rounded">
                                <small class="text-info">
                                    <i class="fas fa-info-circle me-1"></i>
                                    <span id="payment-instruction">
                                        @if(old('metode_pembayaran', 'tunai') == 'tunai')
                                            Bayar tunai ketika barang sampai (COD)
                                        @elseif(old('metode_pembayaran', 'tunai') == 'transfer')
                                            Transfer ke rekening bank yang akan ditampilkan di halaman berikutnya
                                        @else
                                            Scan QRIS yang akan ditampilkan di halaman berikutnya
                                        @endif
                                    </span>
                                </small>
                            </div>

                            @error('metode_pembayaran')
                                <div class="text-danger mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Catatan Pesanan -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i> Catatan Pesanan (Opsional)</h5>
                        </div>
                        <div class="card-body">
                            <textarea name="catatan" class="form-control" rows="3" placeholder="Contoh: Tolong dikirim sebelum jam 5 sore, atau catatan khusus lainnya...">{{ old('catatan') }}</textarea>
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
                                    @if($item->product->gambar_url)
                                        <img src="{{ asset('storage/' . $item->product->gambar_url) }}"
                                             class="rounded me-3" alt="{{ $item->product->nama_produk }}"
                                             style="width: 60px; height: 60px; object-fit: cover;"
                                             onerror="this.src='data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'60\' height=\'60\' viewBox=\'0 0 60 60\'%3E%3Crect width=\'60\' height=\'60\' fill=\'%23f8f9fa\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'Arial, sans-serif\' font-size=\'8\' fill=\'%236c757d\'%3E{{ urlencode($item->product->nama_produk) }}%3C/text%3E%3C/svg%3E'">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center me-3"
                                             style="width: 60px; height: 60px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-1 fw-bold">{{ $item->product->nama_produk }}</h6>
                                        <p class="mb-1 text-muted small">{{ $item->quantity }} x Rp {{ number_format($item->product->harga_jual, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <span class="fw-bold text-primary">Rp {{ number_format($item->quantity * $item->product->harga_jual, 0, ',', '.') }}</span>
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
                                <span id="shipping-cost-display">Rp 15.000</span>
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
                        <button type="submit" form="checkout-form" class="btn btn-primary btn-lg w-100 py-3 mb-3" id="confirm-button">
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
        border: 2px solid #dee2e6;
    }

    .payment-option:hover {
        border-color: var(--color-primary) !important;
        background-color: rgba(94, 84, 142, 0.05);
    }

    .payment-method.selected .payment-option,
    .payment-option.border-primary {
        border-color: var(--color-primary) !important;
        background-color: rgba(94, 84, 142, 0.1);
    }

    .payment-method.selected .fa-check-circle,
    .fa-check-circle:not(.d-none) {
        display: block !important;
    }

    .sticky-top {
        position: sticky;
        z-index: 10;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }

    .form-check-input:checked {
        background-color: var(--color-primary);
        border-color: var(--color-primary);
    }
</style>
@endpush

@push('scripts')
<script>
    function selectPayment(method) {
        console.log('Selected payment method:', method);

        // Remove selected class from all
        document.querySelectorAll('.payment-method').forEach(pm => {
            pm.classList.remove('selected');
        });

        // Remove border-primary from all options
        document.querySelectorAll('.payment-option').forEach(option => {
            option.classList.remove('border-primary', 'bg-light');
        });

        // Hide all check icons
        document.querySelectorAll('.fa-check-circle').forEach(icon => {
            icon.classList.add('d-none');
        });

        // Add selected class to chosen method
        const selectedMethod = document.querySelector(`[data-method="${method}"]`);
        if (selectedMethod) {
            selectedMethod.classList.add('selected');
            const radioInput = document.getElementById(method);
            if (radioInput) {
                radioInput.checked = true;
            }

            // Update UI
            const paymentOption = selectedMethod.querySelector('.payment-option');
            if (paymentOption) {
                paymentOption.classList.add('border-primary', 'bg-light');
            }

            const checkIcon = selectedMethod.querySelector('.fa-check-circle');
            if (checkIcon) {
                checkIcon.classList.remove('d-none');
            }
        }

        // Update payment instruction
        const instructionElement = document.getElementById('payment-instruction');
        if (instructionElement) {
            if (method === 'tunai') {
                instructionElement.textContent = 'Bayar tunai ketika barang sampai (COD)';
            } else if (method === 'transfer') {
                instructionElement.textContent = 'Transfer ke rekening bank yang akan ditampilkan di halaman berikutnya';
            } else if (method === 'qris') {
                instructionElement.textContent = 'Scan QRIS yang akan ditampilkan di halaman berikutnya';
            }
        }
    }

    function calculateShippingCost() {
        const alamat = document.querySelector('textarea[name="alamat"]').value.toLowerCase();
        const kota = document.querySelector('input[name="kota"]').value.toLowerCase();
        const metodePengiriman = document.querySelector('input[name="metode_pengiriman"]:checked').value;

        // Cek apakah alamat mengandung "rumbai"
        const isRumbaiArea = alamat.includes('rumbai') || kota.includes('rumbai');

        let shippingCost = 0;
        if (!isRumbaiArea) {
            shippingCost = metodePengiriman === 'express' ? 25000 : 15000;
        }

        // Update tampilan
        const shippingDisplay = document.getElementById('shipping-cost-display');
        const totalPayment = document.getElementById('total-payment');
        const subtotal = {{ $total }};
        const total = subtotal + shippingCost;

        shippingDisplay.textContent = isRumbaiArea ? 'Gratis' : `Rp ${shippingCost.toLocaleString('id-ID')}`;
        totalPayment.textContent = `Rp ${total.toLocaleString('id-ID')}`;

        // Update info
        document.getElementById('shipping-info').textContent =
            isRumbaiArea ? 'Gratis ongkir diterapkan untuk wilayah Rumbai' : 'Ongkir berlaku untuk luar wilayah Rumbai';

        return shippingCost;
    }

    document.addEventListener('DOMContentLoaded', function() {
        console.log('Checkout page loaded');

        // Inisialisasi metode pembayaran yang terpilih
        const checkedRadio = document.querySelector('input[name="metode_pembayaran"]:checked');
        if (checkedRadio) {
            console.log('Initial payment method:', checkedRadio.value);
            selectPayment(checkedRadio.value);
        } else {
            // Default to 'tunai' jika tidak ada yang terpilih
            const tunaiMethod = document.querySelector('[data-method="tunai"]');
            if (tunaiMethod) {
                const methodId = tunaiMethod.getAttribute('data-method');
                selectPayment(methodId);
            }
        }

        // Event listener untuk metode pembayaran
        document.querySelectorAll('.payment-method').forEach(method => {
            method.addEventListener('click', function() {
                const methodId = this.getAttribute('data-method');
                console.log('Payment method clicked:', methodId);
                selectPayment(methodId);
            });
        });

        // Update biaya pengiriman saat metode pengiriman berubah
        const shippingRadios = document.querySelectorAll('input[name="metode_pengiriman"]');
        shippingRadios.forEach(radio => {
            radio.addEventListener('change', calculateShippingCost);
        });

        // Update biaya pengiriman saat alamat diubah
        document.querySelector('textarea[name="alamat"]').addEventListener('input', calculateShippingCost);
        document.querySelector('input[name="kota"]').addEventListener('input', calculateShippingCost);

        // Hitung ongkir pertama kali
        calculateShippingCost();

        // Validasi form sebelum submit
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            console.log('Form submitted');

            const confirmButton = document.getElementById('confirm-button');
            confirmButton.disabled = true;
            confirmButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';

            const requiredFields = this.querySelectorAll('[required]');
            let valid = true;
            let firstInvalidField = null;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.classList.add('is-invalid');

                    if (!firstInvalidField) {
                        firstInvalidField = field;
                    }
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            // Validasi metode pembayaran
            const selectedPayment = document.querySelector('input[name="metode_pembayaran"]:checked');
            if (!selectedPayment) {
                valid = false;
                const paymentContainer = document.querySelector('.payment-methods');
                let paymentError = paymentContainer.querySelector('.payment-error');
                if (!paymentError) {
                    paymentError = document.createElement('div');
                    paymentError.className = 'payment-error text-danger mt-2';
                    paymentError.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i>Pilih metode pembayaran';
                    paymentContainer.appendChild(paymentError);
                }
            } else {
                // Remove payment error if exists
                const paymentError = document.querySelector('.payment-error');
                if (paymentError) {
                    paymentError.remove();
                }
                console.log('Selected payment method:', selectedPayment.value);
            }

            if (!valid) {
                e.preventDefault();
                console.log('Form validation failed');

                if (firstInvalidField) {
                    firstInvalidField.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    firstInvalidField.focus();
                }

                const existingAlert = document.querySelector('.alert.alert-danger.temporary');
                if (!existingAlert) {
                    const errorAlert = document.createElement('div');
                    errorAlert.className = 'alert alert-danger alert-dismissible fade show mb-4 temporary';
                    errorAlert.innerHTML = `
                        <strong><i class="fas fa-exclamation-triangle me-2"></i>Perhatian!</strong> Harap lengkapi semua field yang wajib diisi.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;

                    const firstCard = document.querySelector('.card');
                    firstCard.parentNode.insertBefore(errorAlert, firstCard);

                    setTimeout(() => {
                        if (errorAlert.parentNode) {
                            errorAlert.remove();
                        }
                    }, 5000);
                }

                setTimeout(() => {
                    confirmButton.disabled = false;
                    confirmButton.innerHTML = '<i class="fas fa-lock me-2"></i> Konfirmasi & Bayar';
                }, 1000);

                return false;
            }

            console.log('Form validation passed');
            return true;
        });

        // Hapus error state ketika user mulai mengetik
        document.querySelectorAll('input, textarea').forEach(field => {
            field.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.classList.remove('is-invalid');
                }
            });
        });
    });
</script>
@endpush
