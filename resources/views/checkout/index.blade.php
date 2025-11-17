@extends('layouts.app')

@section('title', 'Checkout')

@section('navbar')
    @include('layouts.partials.header')
@endsection

@section('content')
    <div class="content-container p-0">

        <div class="p-4 rounded-top-4" style="background: linear-gradient(90deg, var(--color-primary) 0%, var(--color-secondary) 100%); color: white;">
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="step active">
                        <div class="step-number" style="background: var(--color-accent); color: var(--color-primary); border: 2px solid white;">1</div>
                        <div>Keranjang</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step active">
                        <div class="step-number" style="background: var(--color-success); color: white; border: 2px solid white;">2</div>
                        <div>**Checkout & Pembayaran**</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step">
                        <div class="step-number" style="background: rgba(255,255,255,0.2); color: white; border: 2px solid rgba(255,255,255,0.2);">3</div>
                        <div>Selesai</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid py-4">
            <div class="row g-4">
                <div class="col-lg-8">
                    <form action="{{ route('cart.checkout') }}" method="POST" id="checkout-form">
                        @csrf

                        <div class="p-3 mb-4 card shadow-sm">
                            <h4 class="text-theme-primary"><i class="fas fa-truck me-2"></i> Informasi Pengiriman</h4>
                            <hr class="text-theme-primary">
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

                        <div class="p-3 mb-4 card shadow-sm">
                            <h4 class="text-theme-primary"><i class="fas fa-credit-card me-2"></i> Metode Pembayaran</h4>
                            <hr class="text-theme-primary">
                            <div class="payment-methods">
                                @php $paymentMethods = [
                                    ['id' => 'transfer', 'icon' => 'fas fa-university', 'color' => 'var(--color-primary)', 'title' => 'Transfer Bank', 'subtitle' => 'BCA, BNI, BRI, Mandiri'],
                                    ['id' => 'cod', 'icon' => 'fas fa-money-bill-wave', 'color' => 'var(--color-success)', 'title' => 'Cash on Delivery (COD)', 'subtitle' => 'Bayar ketika barang sampai'],
                                    ['id' => 'ewallet', 'icon' => 'fas fa-wallet', 'color' => 'var(--color-danger)', 'title' => 'E-Wallet', 'subtitle' => 'Gopay, OVO, Dana, LinkAja']
                                ]; @endphp

                                @foreach ($paymentMethods as $method)
                                <div class="payment-method mb-2" onclick="selectPayment('{{ $method['id'] }}')">
                                    <input type="radio" name="metode_pembayaran" value="{{ $method['id'] }}" id="{{ $method['id'] }}" {{ $method['id'] == 'transfer' ? 'checked' : '' }} hidden>
                                    <div class="d-flex align-items-center p-3 border rounded-3 transition-all">
                                        <i class="{{ $method['icon'] }} fa-2x me-3" style="color: {{ $method['color'] }};"></i>
                                        <div>
                                            <h6 class="mb-1 fw-bold">{{ $method['title'] }}</h6>
                                            <small class="text-muted">{{ $method['subtitle'] }}</small>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="p-3 mb-4 card shadow-sm">
                            <h4 class="text-theme-primary"><i class="fas fa-sticky-note me-2"></i> Catatan Pesanan</h4>
                            <hr class="text-theme-primary">
                            <textarea name="catatan" class="form-control" rows="3"
                                      placeholder="Contoh: Tolong dikirim sebelum jam 5 sore..."></textarea>
                        </div>
                    </form>
                </div>

                <div class="col-lg-4">
                    <div class="card p-3 shadow-lg h-100" style="background: var(--color-light);">
                        <h4 class="mb-4 text-theme-primary fw-bold">Ringkasan Pesanan</h4>

                        <div class="summary-card p-3 bg-white rounded-3 mb-4">
                            @foreach($cartItems as $item)
                                <div class="d-flex justify-content-between align-items-center mb-2 small border-bottom pb-2">
                                    <div>
                                        <span class="text-dark fw-bold">{{ $item->product->nama_produk }}</span>
                                        <span class="text-muted d-block">{{ $item->jumlah }} x Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</span>
                                    </div>
                                    <span class="fw-bold" style="color: var(--color-danger);">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach

                            <div class="d-flex justify-content-between mt-3">
                                <span>Subtotal Produk:</span>
                                <span>Rp {{ number_format($total ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Biaya Pengiriman:</span>
                                <span>Rp 15.000</span>
                            </div>

                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="fw-bold fs-5 text-theme-primary">Total Bayar:</span>
                                <span class="fw-bold fs-5 text-success">Rp {{ number_format(($total ?? 0) + 15000, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="submit" form="checkout-form" class="btn btn-success-custom btn-lg">
                            <i class="fas fa-check-circle me-2"></i> **Konfirmasi & Bayar**
                        </button>

                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Keranjang
                        </a>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1 text-theme-primary"></i>
                                Transaksi Anda aman dan terenkripsi
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 0;
    }

    .step-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 5px;
        font-weight: bold;
    }
    .payment-method .rounded-3 {
        border-color: var(--color-light) !important;
    }
    .payment-method:hover .rounded-3 {
        border-color: var(--color-accent) !important;
        background: var(--color-light);
    }
    .payment-method.selected .rounded-3 {
        border-color: var(--color-primary) !important;
        background: var(--color-light);
        box-shadow: 0 0 0 2px rgba(94, 84, 142, 0.1);
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

        // Initialize first payment method as selected and logic to ensure selection
        document.addEventListener('DOMContentLoaded', function() {
            // Select the payment method based on the checked radio input (default: transfer)
            const checkedRadio = document.querySelector('input[name="metode_pembayaran"]:checked');
            if (checkedRadio) {
                const methodId = checkedRadio.value;
                document.getElementById(methodId).closest('.payment-method').classList.add('selected');
            } else {
                // Fallback to select 'transfer' if none is checked
                selectPayment('transfer');
            }

            // Form validation
            document.getElementById('checkout-form').addEventListener('submit', function(e) {
                const requiredFields = this.querySelectorAll('[required]');
                let valid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        valid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    // Optionally show a generic alert instead of the default browser one
                    // alert('Harap lengkapi semua field yang wajib diisi!');
                }
            });
        });
    </script>
@endpush
