<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --color-primary: #004f7c;
            --color-accent: #ff6347;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .content-container {
            max-width: 1200px;
            margin: 30px auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .checkout-steps {
            background: linear-gradient(45deg, #004f7c, #0066a5);
            color: white;
            padding: 20px;
        }

        .step {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: bold;
        }

        .step.active .step-number {
            background: #ff6347;
        }

        .form-section {
            padding: 30px;
            border-bottom: 1px solid #e0e0e0;
        }

        .summary-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .btn-checkout {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            color: white;
            padding: 15px 30px;
            font-weight: bold;
            border-radius: 10px;
            width: 100%;
            font-size: 18px;
        }

        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
            color: white;
        }

        .payment-method {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-method:hover {
            border-color: #004f7c;
        }

        .payment-method.selected {
            border-color: #004f7c;
            background: #f0f8ff;
        }
    </style>
</head>
<body>
    <!-- NAV BAR -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top navbar-custom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="fas fa-shopping-basket me-2"></i> MINI<span style="color: var(--color-accent);">MARKET</span>
            </a>
            <div class="navbar-nav ms-auto">
                <a href="{{ route('cart.index') }}" class="btn btn-outline-dark position-relative">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count">
                        {{ $cartItems->count() }}
                    </span>
                </a>
            </div>
        </div>
    </nav>

    <div class="content-container">
        <!-- Checkout Steps -->
        <div class="checkout-steps">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="step active">
                            <div class="step-number">1</div>
                            <div>
                                <small>Step 1</small>
                                <div>Keranjang</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step active">
                            <div class="step-number">2</div>
                            <div>
                                <small>Step 2</small>
                                <div>Checkout</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step">
                            <div class="step-number">3</div>
                            <div>
                                <small>Step 3</small>
                                <div>Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <!-- Form Section -->
                <div class="col-lg-8">
                    <form action="{{ route('cart.checkout') }}" method="POST" id="checkout-form">
                        @csrf

                        <!-- Informasi Pengiriman -->
                        <div class="form-section">
                            <h4><i class="fas fa-truck me-2"></i> Informasi Pengiriman</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Lengkap *</label>
                                    <input type="text" name="nama_lengkap" class="form-control"
                                           value="{{ $user->nama_lengkap ?? $user->name }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No. Telepon *</label>
                                    <input type="text" name="no_telepon" class="form-control"
                                           value="{{ $user->no_telepon ?? '' }}" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap *</label>
                                <textarea name="alamat" class="form-control" rows="3" required>{{ $user->alamat ?? '' }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kota *</label>
                                    <input type="text" name="kota" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kode Pos</label>
                                    <input type="text" name="kode_pos" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="form-section">
                            <h4><i class="fas fa-credit-card me-2"></i> Metode Pembayaran</h4>
                            <div class="payment-methods">
                                <div class="payment-method" onclick="selectPayment('transfer')">
                                    <input type="radio" name="metode_pembayaran" value="transfer" id="transfer" checked hidden>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-university fa-2x me-3 text-primary"></i>
                                        <div>
                                            <h6 class="mb-1">Transfer Bank</h6>
                                            <small class="text-muted">BCA, BNI, BRI, Mandiri</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="payment-method" onclick="selectPayment('cod')">
                                    <input type="radio" name="metode_pembayaran" value="cod" id="cod" hidden>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-money-bill-wave fa-2x me-3 text-success"></i>
                                        <div>
                                            <h6 class="mb-1">Cash on Delivery (COD)</h6>
                                            <small class="text-muted">Bayar ketika barang sampai</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="payment-method" onclick="selectPayment('ewallet')">
                                    <input type="radio" name="metode_pembayaran" value="ewallet" id="ewallet" hidden>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-wallet fa-2x me-3 text-warning"></i>
                                        <div>
                                            <h6 class="mb-1">E-Wallet</h6>
                                            <small class="text-muted">Gopay, OVO, Dana, LinkAja</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div class="form-section">
                            <h4><i class="fas fa-sticky-note me-2"></i> Catatan Pesanan</h4>
                            <textarea name="catatan" class="form-control" rows="3"
                                      placeholder="Contoh: Tolong dikirim sebelum jam 5 sore..."></textarea>
                        </div>
                    </form>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4 bg-light">
                    <div class="p-4">
                        <h4 class="mb-4">Ringkasan Pesanan</h4>

                        <div class="summary-card">
                            @foreach($cartItems as $item)
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">{{ $item->product->nama_produk }}</h6>
                                        <small class="text-muted">{{ $item->jumlah }} x Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</small>
                                    </div>
                                    <span class="fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach

                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Biaya Pengiriman:</span>
                                <span>Rp 15.000</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="fw-bold fs-5">Total:</span>
                                <span class="fw-bold fs-5 text-success">Rp {{ number_format($total + 15000, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="submit" form="checkout-form" class="btn btn-checkout">
                            <i class="fas fa-lock me-2"></i> Bayar Sekarang
                        </button>

                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Keranjang
                        </a>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Transaksi Anda aman dan terenkripsi
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectPayment(method) {
            // Remove selected class from all payment methods
            document.querySelectorAll('.payment-method').forEach(pm => {
                pm.classList.remove('selected');
            });

            // Add selected class to clicked payment method
            event.currentTarget.classList.add('selected');

            // Check the corresponding radio button
            document.getElementById(method).checked = true;
        }

        // Initialize first payment method as selected
        document.addEventListener('DOMContentLoaded', function() {
            selectPayment('transfer');

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
                    alert('Harap lengkapi semua field yang wajib diisi!');
                }
            });
        });
    </script>
</body>
</html>
