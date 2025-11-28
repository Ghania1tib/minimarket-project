@extends('layouts.app')

@section('title', 'POS - Transaksi Baru')

@push('styles')
    <style>
        body {
            padding-top: 0 !important;
            background: var(--color-light) !important;
        }

        .pos-container {
            margin: 0 auto;
            max-width: 1400px;
            padding: 10px;
        }

        .pos-header {
            background-color: var(--color-primary);
            color: white;
            padding: 15px 25px;
            border-radius: var(--border-radius-sm);
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .product-card {
            border: 1px solid var(--color-light);
            border-radius: var(--border-radius-sm);
            padding: 10px;
            text-align: center;
            background: white;
            transition: transform 0.2s;
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .cart-item {
            border-bottom: 1px solid var(--color-light);
            padding: 10px 0;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .quantity-controls button {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .total-box {
            background-color: var(--color-primary);
            color: white;
            padding: 20px;
            border-radius: var(--border-radius-sm);
            text-align: right;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .total-box h1 {
            font-size: 2.5rem;
            font-weight: 900;
            margin: 0;
            color: white;
        }

        .total-box small {
            font-size: 0.9rem;
            opacity: 0.9;
            letter-spacing: 1px;
            display: block;
        }

        .payment-section {
            background: white;
            border-radius: var(--border-radius-sm);
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .change-box {
            background-color: var(--color-success);
            color: white;
            padding: 15px;
            border-radius: var(--border-radius-sm);
            text-align: center;
            margin-top: 15px;
            display: none;
        }

        .change-box.negative {
            background-color: var(--color-danger);
        }

        .change-box h5 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }

        .total-after-discount {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-top: 5px;
            display: none;
        }

        /* Style untuk filter kategori */
        .category-filter {
            margin-bottom: 15px;
        }

        .category-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 15px;
        }

        .category-btn {
            padding: 6px 12px;
            border: 1px solid var(--color-light);
            border-radius: var(--border-radius-sm);
            background: white;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.85rem;
        }

        .category-btn.active {
            background-color: var(--color-primary);
            color: white;
            border-color: var(--color-primary);
        }

        .category-btn:hover {
            background-color: var(--color-light);
        }

        /* Style untuk card member info */
        #memberInfo .card-body {
            padding: 1rem !important;
        }

        #memberInfo .border-light {
            opacity: 0.3;
        }

        /* Perbaikan responsive */
        @media (max-width: 576px) {
            #memberInfo .row .col-6 {
                margin-bottom: 0.5rem;
            }

            #memberInfo .mx-3 {
                margin-left: 1rem !important;
                margin-right: 1rem !important;
            }
        }

        /* Style untuk tombol di modal struk */
        #receiptModal .modal-footer {
            display: flex;
            justify-content: space-between;
            padding: 1rem;
            border-top: 1px solid #dee2e6;
            background: #f8f9fa;
        }

        #receiptModal .modal-footer .btn {
            flex: 1;
            margin: 0 5px;
            padding: 10px 15px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        #receiptModal .modal-footer .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        #receiptModal .modal-footer .btn:active {
            transform: translateY(0);
        }

        #receiptModal .modal-footer .btn-secondary {
            background: #6c757d;
            color: white;
        }

        #receiptModal .modal-footer .btn-success {
            background: #28a745;
            color: white;
        }

        #receiptModal .modal-footer .btn-primary {
            background: #007bff;
            color: white;
        }

        /* Toast notification */
        .toast {
            opacity: 1 !important;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        .toast-body {
            padding: 12px 15px;
            font-weight: 500;
        }

        /* Responsive design untuk modal footer */
        @media (max-width: 576px) {
            #receiptModal .modal-footer {
                flex-direction: column;
                gap: 10px;
            }

            #receiptModal .modal-footer .btn {
                margin: 0;
                width: 100%;
            }
        }

        /* Style untuk struk transaksi */
        .receipt-content {
            font-family: 'Courier New', monospace;
            font-size: 14px;
        }

        .receipt-header {
            border-bottom: 2px dashed #dee2e6;
        }

        .receipt-items .row {
            border-bottom: 1px dashed #dee2e6;
        }

        .receipt-summary .row {
            border-bottom: 1px dashed #dee2e6;
        }

        /* Style untuk modal struk */
        #receiptModal .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }

        /* Style untuk button group metode pembayaran */
        .btn-group .btn {
            padding: 10px;
        }

        .btn-check:checked+.btn {
            background-color: var(--color-primary);
            color: white;
            border-color: var(--color-primary);
        }

        /* Style untuk loading */
        #completeTransaction .fa-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        /* Style untuk metode pembayaran tambahan */
        .payment-extra {
            margin-top: 15px;
            padding: 15px;
            border: 1px solid #e9ecef;
            border-radius: var(--border-radius-sm);
            background: #f8f9fa;
            display: none;
        }

        .payment-extra.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .bank-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
            margin-top: 10px;
        }

        .bank-option {
            border: 2px solid #e9ecef;
            border-radius: var(--border-radius-sm);
            padding: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: white;
        }

        .bank-option:hover {
            border-color: var(--color-primary);
        }

        .bank-option.selected {
            border-color: var(--color-primary);
            background-color: rgba(var(--color-primary-rgb), 0.1);
        }

        .bank-logo {
            width: 40px;
            height: 40px;
            margin: 0 auto 5px;
            background: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 12px;
            color: var(--color-primary);
        }

        .qris-container {
            text-align: center;
            padding: 20px;
        }

        .qris-code {
            width: 200px;
            height: 200px;
            margin: 0 auto 15px;
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .qris-code::before {
            content: '';
            position: absolute;
            width: 180px;
            height: 180px;
            background:
                linear-gradient(45deg, transparent 45%, #000 45%, #000 55%, transparent 55%),
                linear-gradient(-45deg, transparent 45%, #000 45%, #000 55%, transparent 55%);
            background-size: 20px 20px;
        }

        .qris-placeholder {
            position: relative;
            z-index: 1;
            background: white;
            padding: 5px;
            font-size: 12px;
            color: #666;
        }

        .payment-timer {
            background: var(--color-warning);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: bold;
            margin-bottom: 15px;
            display: inline-block;
        }

        .payment-instruction {
            background: #e7f3ff;
            border-left: 4px solid var(--color-primary);
            padding: 10px 15px;
            margin-top: 15px;
            border-radius: 0 var(--border-radius-sm) var(--border-radius-sm) 0;
        }

        /* Style untuk gambar produk */
        .product-image {
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            overflow: hidden;
            border-radius: 8px;
        }

        .product-image img {
            max-height: 100%;
            max-width: 100%;
            object-fit: cover;
        }

        /* Style untuk diskon grosir */
        .wholesale-badge {
            background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: bold;
            margin-top: 3px;
            display: inline-block;
        }

        .wholesale-discount {
            background: #e7f7ff;
            border-left: 3px solid #1890ff;
            padding: 8px 12px;
            margin-top: 5px;
            border-radius: 4px;
            font-size: 0.8rem;
        }

        .wholesale-info {
            font-size: 0.75rem;
            color: #52c41a;
            margin-top: 2px;
        }

        .wholesale-rules {
            font-size: 0.7rem;
            color: #666;
            margin-top: 2px;
        }

        .low-stock {
            color: #ff4d4f !important;
            font-weight: bold;
        }

        .out-of-stock {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .out-of-stock::after {
            content: "HABIS";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 0, 0, 0.8);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
        }

        /* Style untuk produk habis */
.product-card.out-of-stock {
    opacity: 0.6;
    cursor: not-allowed;
    pointer-events: none;
    position: relative;
}

.product-card.out-of-stock::after {
    content: "HABIS";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(255, 0, 0, 0.8);
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
    font-weight: bold;
    z-index: 10;
}

.product-card {
    position: relative;
    transition: all 0.3s ease;
}
    </style>
@endpush

@section('navbar')
    {{-- Tidak ada navbar untuk mode POS --}}
@endsection

@section('content')
    <div class="pos-container">
        <div class="pos-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-cash-register me-3"></i> POINT OF SALE (POS) - Toko Saudara 2</h4>
            <div>
                <span class="me-3">Kasir: {{ Auth::user()->nama_lengkap }}</span>
                <a href="{{ route('dashboard.staff') }}" class="btn btn-sm btn-outline-light shadow-sm">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>

        <div class="row g-3">
            <!-- Kolom Kiri: Daftar Produk -->
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-theme-accent p-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search text-theme-primary"></i></span>
                            <input type="text" class="form-control form-control-lg"
                                placeholder="Scan Barcode atau Cari Produk..." id="productSearch" autofocus>
                            <button class="btn btn-primary-custom" id="searchBtn">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filter Kategori -->
                        <div class="category-filter">
                            <h6 class="text-theme-primary mb-2">Filter Kategori:</h6>
                            <div class="category-buttons" id="categoryButtons">
                                <button class="category-btn active" data-category-id="">Semua Kategori</button>
                                @foreach ($categories as $category)
                                    <button class="category-btn" data-category-id="{{ $category->id }}">
                                        {{ $category->nama_kategori }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <h5 class="text-theme-primary mb-3">Daftar Produk</h5>
                        <div class="product-grid" id="productList">
                            <!-- Produk dari database -->
                            @foreach ($products as $product)
                                <div class="product-card {{ $product->stok == 0 ? 'out-of-stock' : '' }}"
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->nama_produk }}"
                                    data-product-price="{{ $product->harga_jual }}"
                                    data-product-stock="{{ $product->stok }}"
                                    data-category-id="{{ $product->kategori ? $product->kategori->id : '' }}"
                                    data-category-name="{{ $product->kategori ? $product->kategori->nama_kategori : 'Tanpa Kategori' }}"
                                    data-product-barcode="{{ $product->barcode ?? '' }}"
                                    data-wholesale-rules="{{ json_encode($product->wholesale_rules ?? []) }}"
                                    onclick="{{ $product->stok > 0 ? "addToCartFromCard(this)" : "void(0)" }}">

                                      <div class="product-image mb-2 position-relative">
            @if($product->gambar_url)
                <img src="{{ $product->full_gambar_url }}" alt="{{ $product->nama_produk }}" class="img-fluid">
            @else
                <div class="bg-theme-light d-flex align-items-center justify-content-center w-100 h-100">
                    <i class="fas fa-box text-secondary"></i>
                </div>
            @endif
        </div>
                                    <h6 class="mb-1">{{ $product->nama_produk }}</h6>
                                    <p class="text-success fw-bold mb-1">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</p>
                                    <small class="text-muted {{ $product->stok <= 3 ? 'low-stock' : '' }}">Stok: {{ $product->stok }}</small>
                                    @if ($product->kategori)
                                        <br><small class="text-info">{{ $product->kategori->nama_kategori }}</small>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Keranjang & Pembayaran -->
            <div class="col-lg-4">
                <div class="d-grid gap-2 mb-3">
                    <button class="btn btn-primary shadow-sm d-flex align-items-center justify-content-center py-2"
                        data-bs-toggle="modal" data-bs-target="#memberModal">
                        <i class="fas fa-user-plus me-2"></i> Cari Member
                    </button>
                </div>

                <div class="card text-white mb-3 shadow" id="memberInfo"
                    style="display: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Info Member -->
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-crown me-2 fs-5 text-warning"></i>
                                    <h5 class="mb-0 fw-bold" id="memberName">Nama Member</h5>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-phone me-2"></i>
                                            <span id="memberPhone">Nomor Telepon</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-star me-2 text-warning"></i>
                                            <span id="memberPoints">0 Poin</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Info Diskon -->
                            <div class="text-center mx-3 px-3">
                                <div class="fs-6 fw-semibold">DISKON</div>
                                <h2 class="mb-0 fw-bold text-warning" id="discountPercentage"
                                    style="text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">0%</h2>
                            </div>

                            <!-- Tombol Hapus -->
                            <button class="btn btn-sm btn-light rounded-circle" id="removeMember" title="Hapus Member">
                                <i class="fas fa-times text-dark"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="total-box">
                    <small>TOTAL BELANJA</small>
                    <h1 id="totalAmount">Rp 0</h1>
                    <small class="total-after-discount" id="totalAfterDiscount"></small>
                    <small class="total-after-discount" id="wholesaleDiscountText" style="color: #ffeb3b;"></small>
                </div>

                <div class="payment-section">
                    <h5 class="text-theme-primary mb-3">Ringkasan Transaksi</h5>

                    <div class="cart-items mb-3" id="cartItems" style="max-height: 300px; overflow-y: auto;">
                        <!-- Item keranjang akan dimuat di sini -->
                        <div class="text-center text-muted py-4" id="emptyCartMessage">
                            <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                            <p>Keranjang kosong</p>
                        </div>
                    </div>

                    <!-- Metode Pembayaran yang Diperbarui -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-theme-primary">Metode Pembayaran</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="paymentMethod" id="cashMethod" value="tunai" checked>
                            <label class="btn btn-outline-primary" for="cashMethod">
                                <i class="fas fa-money-bill-wave me-2"></i>Tunai
                            </label>

                            <input type="radio" class="btn-check" name="paymentMethod" id="debitMethod" value="debit_kredit">
                            <label class="btn btn-outline-primary" for="debitMethod">
                                <i class="fas fa-credit-card me-2"></i>Debit/Kredit
                            </label>

                            <input type="radio" class="btn-check" name="paymentMethod" id="qrisMethod" value="qris_ewallet">
                            <label class="btn btn-outline-primary" for="qrisMethod">
                                <i class="fas fa-qrcode me-2"></i>QRIS/E-Wallet
                            </label>
                        </div>
                    </div>

                    <!-- Tambahan untuk Metode Debit -->
                    <div class="payment-extra" id="debitExtra">
                        <h6 class="text-theme-primary mb-2">Pilih Bank</h6>
                        <div class="bank-options" id="bankOptions">
                            <div class="bank-option" data-bank="bca">
                                <div class="bank-logo">BCA</div>
                                <small>BCA</small>
                            </div>
                            <div class="bank-option" data-bank="bni">
                                <div class="bank-logo">BNI</div>
                                <small>BNI</small>
                            </div>
                            <div class="bank-option" data-bank="bri">
                                <div class="bank-logo">BRI</div>
                                <small>BRI</small>
                            </div>
                            <div class="bank-option" data-bank="mandiri">
                                <div class="bank-logo">MDR</div>
                                <small>Mandiri</small>
                            </div>
                            <div class="bank-option" data-bank="cimb">
                                <div class="bank-logo">CIMB</div>
                                <small>CIMB</small>
                            </div>
                            <div class="bank-option" data-bank="other">
                                <div class="bank-logo">OTH</div>
                                <small>Lainnya</small>
                            </div>
                        </div>
                        <input type="hidden" id="selectedBank" name="selected_bank">
                    </div>

                    <!-- Tambahan untuk Metode QRIS -->
                    <div class="payment-extra" id="qrisExtra">
                        <div class="qris-container">
                            <div class="payment-timer" id="qrisTimer">
                                <i class="fas fa-clock me-2"></i>Batas Waktu: <span id="timerCountdown">05:00</span>
                            </div>
                            <div class="qris-code">
                                <div class="qris-placeholder">
                                    QR CODE<br>TOKO SAUDARA 2
                                </div>
                            </div>
                            <p class="text-muted mb-3">Scan QR code di atas untuk pembayaran</p>
                            <div class="payment-instruction">
                                <small>
                                    <i class="fas fa-info-circle me-1"></i>
                                    Gunakan aplikasi e-wallet atau mobile banking untuk scan QRIS
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Input Nominal Bayar -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-theme-primary">Nominal Bayar</label>
                        <input type="number" class="form-control form-control-lg" id="paymentAmount" placeholder="Rp ..." min="0">
                    </div>

                    <!-- Kolom Uang Kembalian -->
                    <div class="change-box" id="changeBox">
                        <small>UANG KEMBALI</small>
                        <h5 id="changeAmount">Rp 0</h5>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button class="btn btn-success-custom btn-lg py-3" id="completeTransaction">
                            <i class="fas fa-check-circle me-2"></i> SELESAI TRANSAKSI
                        </button>
                        <button class="btn btn-secondary btn-sm" id="clearCart">
                            <i class="fas fa-trash me-2"></i> Kosongkan Keranjang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Member -->
    <div class="modal fade" id="memberModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cari Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs mb-3" id="memberSearchTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#phoneSearch">Cari by Telepon</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="phoneSearch">
                            <div class="mb-3">
                                <label class="form-label">Nomor Telepon Member</label>
                                <input type="text" class="form-control" id="memberPhoneInput" placeholder="Contoh: 081234567890">
                                <small class="text-muted">Masukkan nomor telepon yang terdaftar</small>
                            </div>
                            <button type="button" class="btn btn-primary w-100" id="searchMemberByPhoneBtn">
                                <i class="fas fa-search me-1"></i> Cari by Telepon
                            </button>
                        </div>
                    </div>

                    <div id="memberSearchResult" class="mt-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Struk Transaksi -->
    <div class="modal fade" id="receiptModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-check-circle me-2"></i> TRANSAKSI BERHASIL
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold text-success">TOKO SAUDARA 2</h4>
                        <p class="mb-1">Jl. Contoh Alamat No. 123</p>
                        <p class="mb-1">Telp: (021) 123-4567</p>
                    </div>

                    <div class="receipt-content" id="receiptContent">
                        <!-- Struk akan diisi oleh JavaScript -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-success" onclick="printReceipt()">
                        <i class="fas fa-print me-2"></i> Cetak Struk
                    </button>
                    <button type="button" class="btn btn-primary" onclick="newTransaction()">
                        <i class="fas fa-plus me-2"></i> Transaksi Baru
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
       // ==================== VARIABEL GLOBAL ====================
let cart = [];
let selectedMember = null;
let selectedBank = null;
let qrisTimer = null;
let timerSeconds = 300;

// ==================== INISIALISASI ====================
document.addEventListener('DOMContentLoaded', function() {
    initializePOS();
    updateCartDisplay();
    initializePaymentMethods();
    initializeSearchAndFilter();
});

function initializePOS() {
    console.log('Menginisialisasi POS...');

    // Event listener untuk input pembayaran
    const paymentInput = document.getElementById('paymentAmount');
    if (paymentInput) {
        paymentInput.addEventListener('input', calculateChange);
    }

    // Event listener untuk tombol selesai transaksi
    const completeBtn = document.getElementById('completeTransaction');
    if (completeBtn) {
        completeBtn.addEventListener('click', processTransaction);
    }

    // Tombol clear cart
    const clearCartBtn = document.getElementById('clearCart');
    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', function() {
            if (cart.length === 0) {
                alert('Keranjang sudah kosong!');
                return;
            }
            if (confirm('Apakah Anda yakin ingin mengosongkan keranjang?')) {
                cart = [];
                updateCartDisplay();
                document.getElementById('paymentAmount').value = '';
            }
        });
    }

    // Pencarian member by phone
    const searchMemberByPhoneBtn = document.getElementById('searchMemberByPhoneBtn');
    if (searchMemberByPhoneBtn) {
        searchMemberByPhoneBtn.addEventListener('click', function() {
            const phone = document.getElementById('memberPhoneInput').value.trim();
            if (phone) {
                searchMemberByPhone(phone);
            } else {
                alert('Masukkan nomor telepon member terlebih dahulu');
            }
        });
    }

    // Tombol hapus member
    const removeMemberBtn = document.getElementById('removeMember');
    if (removeMemberBtn) {
        removeMemberBtn.addEventListener('click', function() {
            selectedMember = null;
            const memberInfo = document.getElementById('memberInfo');
            if (memberInfo) {
                memberInfo.style.display = 'none';
            }
            updateCartDisplay();
            alert('Member telah dihapus');
        });
    }

    console.log('POS berhasil diinisialisasi');
}

// Fungsi untuk menambah produk dari card
function addToCartFromCard(cardElement) {
    const productId = cardElement.dataset.productId;
    const productName = cardElement.dataset.productName;
    const productPrice = parseInt(cardElement.dataset.productPrice);
    const wholesaleRules = JSON.parse(cardElement.dataset.wholesaleRules || '[]');
    const productStock = parseInt(cardElement.dataset.productStock);

    if (productStock <= 0) {
        alert('Stok produk habis!');
        return;
    }

    console.log('Menambah produk ke keranjang:', productName);
    addToCart(productId, productName, productPrice, wholesaleRules);
}

// PERBAIKAN: Inisialisasi search dan filter
function initializeSearchAndFilter() {
    const productSearch = document.getElementById('productSearch');
    const categoryButtons = document.querySelectorAll('.category-btn');
    const searchBtn = document.getElementById('searchBtn');

    // Event listener untuk pencarian real-time
    if (productSearch) {
        productSearch.addEventListener('input', function() {
            filterProducts();
        });
    }

    // Event listener untuk tombol search
    if (searchBtn) {
        searchBtn.addEventListener('click', function() {
            filterProducts();
        });
    }

    // Event listener untuk filter kategori
    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            filterProducts();
        });
    });

    console.log('Search dan filter diinisialisasi');
}

// PERBAIKAN: Fungsi filter produk
function filterProducts() {
    const searchTerm = document.getElementById('productSearch').value.toLowerCase();
    const activeCategory = document.querySelector('.category-btn.active').dataset.categoryId;

    document.querySelectorAll('.product-card').forEach(card => {
        const productName = card.dataset.productName.toLowerCase();
        const productBarcode = (card.dataset.productBarcode || '').toLowerCase();
        const productCategory = card.dataset.categoryId;

        const matchesSearch = productName.includes(searchTerm) ||
                            productBarcode.includes(searchTerm) ||
                            searchTerm === '';

        const matchesCategory = activeCategory === '' || productCategory === activeCategory;

        if (matchesSearch && matchesCategory) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// PERBAIKAN: Inisialisasi metode pembayaran
function initializePaymentMethods() {
    document.querySelectorAll('input[name="paymentMethod"]').forEach(radio => {
        radio.addEventListener('change', function() {
            handlePaymentMethodChange(this.value);
        });
    });

    document.querySelectorAll('.bank-option').forEach(option => {
        option.addEventListener('click', function() {
            selectBank(this.dataset.bank);
        });
    });

    console.log('Metode pembayaran diinisialisasi');
}

// PERBAIKAN: Handle perubahan metode pembayaran
function handlePaymentMethodChange(method) {
    document.getElementById('debitExtra').classList.remove('active');
    document.getElementById('qrisExtra').classList.remove('active');
    selectedBank = null;
    resetQRISTimer();

    if (method === 'debit_kredit') {
        document.getElementById('debitExtra').classList.add('active');
    } else if (method === 'qris_ewallet') {
        document.getElementById('qrisExtra').classList.add('active');
        startQRISTimer();
    }

    console.log('Metode pembayaran diubah:', method);
}

// PERBAIKAN: Fungsi pilih bank
function selectBank(bank) {
    selectedBank = bank;

    document.querySelectorAll('.bank-option').forEach(option => {
        option.classList.remove('selected');
    });
    document.querySelector(`.bank-option[data-bank="${bank}"]`).classList.add('selected');

    document.getElementById('selectedBank').value = bank;
    console.log('Bank dipilih:', bank);
}

// PERBAIKAN: Fungsi timer QRIS
function startQRISTimer() {
    resetQRISTimer();
    timerSeconds = 300;

    qrisTimer = setInterval(function() {
        timerSeconds--;
        updateTimerDisplay();

        if (timerSeconds <= 0) {
            resetQRISTimer();
            alert('Waktu pembayaran QRIS telah habis! Silakan pilih metode pembayaran lain.');
        }
    }, 1000);
}

function resetQRISTimer() {
    if (qrisTimer) {
        clearInterval(qrisTimer);
        qrisTimer = null;
    }
    timerSeconds = 300;
    updateTimerDisplay();
}

function updateTimerDisplay() {
    const minutes = Math.floor(timerSeconds / 60);
    const seconds = timerSeconds % 60;
    const timerElement = document.getElementById('timerCountdown');
    if (timerElement) {
        timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }
}

// ==================== FUNGSI CART ====================

// PERBAIKAN: Fungsi tambah produk ke keranjang dengan grosir
function addToCart(productId, productName, productPrice, wholesaleRules = []) {
    const existingItemIndex = cart.findIndex(item => item.id === productId);

    if (existingItemIndex !== -1) {
        cart[existingItemIndex].quantity += 1;
        const newQuantity = cart[existingItemIndex].quantity;
        const wholesalePrice = calculateWholesalePrice(productPrice, newQuantity, wholesaleRules);
        cart[existingItemIndex].price = wholesalePrice.actualPrice;
        cart[existingItemIndex].subtotal = newQuantity * wholesalePrice.actualPrice;
        cart[existingItemIndex].wholesaleDiscount = wholesalePrice.discount;
        cart[existingItemIndex].originalPrice = productPrice;
        cart[existingItemIndex].wholesaleRules = wholesaleRules;
    } else {
        const wholesalePrice = calculateWholesalePrice(productPrice, 1, wholesaleRules);
        cart.push({
            id: productId,
            name: productName,
            price: wholesalePrice.actualPrice,
            originalPrice: productPrice,
            quantity: 1,
            subtotal: wholesalePrice.actualPrice,
            wholesaleDiscount: wholesalePrice.discount,
            wholesaleRules: wholesaleRules
        });
    }

    console.log('Cart setelah ditambah:', cart);
    updateCartDisplay();
}

// PERBAIKAN: Hitung harga grosir yang benar
function calculateWholesalePrice(originalPrice, quantity, wholesaleRules) {
    if (!wholesaleRules || wholesaleRules.length === 0) {
        return { actualPrice: originalPrice, discount: 0 };
    }

    // Urutkan rules dari quantity terbesar ke terkecil
    const sortedRules = [...wholesaleRules].sort((a, b) => b.min_quantity - a.min_quantity);

    // Cari rule yang sesuai dengan quantity
    const applicableRule = sortedRules.find(rule => quantity >= rule.min_quantity);

    if (applicableRule) {
        const discountAmount = originalPrice * (applicableRule.discount_percent / 100);
        const actualPrice = originalPrice - discountAmount;
        return {
            actualPrice: actualPrice,
            discount: discountAmount * quantity,
            discountPercent: applicableRule.discount_percent,
            minQuantity: applicableRule.min_quantity
        };
    }

    return { actualPrice: originalPrice, discount: 0 };
}

// PERBAIKAN: Fungsi update tampilan keranjang dengan info grosir
function updateCartDisplay() {
    const cartItems = document.getElementById('cartItems');
    const totalAmount = document.getElementById('totalAmount');
    const emptyCartMessage = document.getElementById('emptyCartMessage');

    if (!cartItems || !totalAmount) {
        console.error('Element cart tidak ditemukan!');
        return;
    }

    const itemsToRemove = cartItems.querySelectorAll('.cart-item');
    itemsToRemove.forEach(item => item.remove());

    if (cart.length === 0) {
        emptyCartMessage.style.display = 'block';
    } else {
        emptyCartMessage.style.display = 'none';

        cart.forEach((item, index) => {
            const itemElement = document.createElement('div');
            itemElement.className = 'cart-item';

            let wholesaleInfo = '';
            if (item.wholesaleDiscount > 0) {
                const discountPercent = Math.round((item.wholesaleDiscount / (item.originalPrice * item.quantity)) * 100);
                wholesaleInfo = `
                    <div class="wholesale-discount">
                        <i class="fas fa-tag me-1 text-success"></i>
                        Diskon Grosir ${discountPercent}%: -Rp ${item.wholesaleDiscount.toLocaleString('id-ID')}
                    </div>
                `;
            }

            itemElement.innerHTML = `
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">${item.name}</h6>
                        <p class="text-success fw-bold mb-1">
                            Rp ${item.price.toLocaleString('id-ID')}
                            ${item.price !== item.originalPrice ?
                                `<small class="text-muted text-decoration-line-through">Rp ${item.originalPrice.toLocaleString('id-ID')}</small>` :
                                ''
                            }
                        </p>
                    </div>
                    <div class="quantity-controls">
                        <button class="btn btn-sm btn-outline-secondary" onclick="decreaseQuantity(${index})">
                            <i class="fas fa-minus"></i>
                        </button>
                        <span class="mx-2 fw-bold">${item.quantity}</span>
                        <button class="btn btn-sm btn-outline-secondary" onclick="increaseQuantity(${index})">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger ms-2" onclick="removeFromCart(${index})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                ${wholesaleInfo}
                <div class="d-flex justify-content-between">
                    <small>Subtotal</small>
                    <strong>Rp ${item.subtotal.toLocaleString('id-ID')}</strong>
                </div>
            `;
            cartItems.appendChild(itemElement);
        });
    }

    updateTotalAmount();
    calculateChange();
    console.log('Tampilan cart diperbarui, total item:', cart.length);
}

// PERBAIKAN: Fungsi untuk kontrol kuantitas dengan grosir
function decreaseQuantity(index) {
    if (index >= 0 && index < cart.length) {
        if (cart[index].quantity > 1) {
            cart[index].quantity -= 1;
            const wholesalePrice = calculateWholesalePrice(
                cart[index].originalPrice,
                cart[index].quantity,
                cart[index].wholesaleRules
            );
            cart[index].price = wholesalePrice.actualPrice;
            cart[index].subtotal = cart[index].quantity * wholesalePrice.actualPrice;
            cart[index].wholesaleDiscount = wholesalePrice.discount;
        } else {
            cart.splice(index, 1);
        }
        updateCartDisplay();
    }
}

function increaseQuantity(index) {
    if (index >= 0 && index < cart.length) {
        cart[index].quantity += 1;
        const wholesalePrice = calculateWholesalePrice(
            cart[index].originalPrice,
            cart[index].quantity,
            cart[index].wholesaleRules
        );
        cart[index].price = wholesalePrice.actualPrice;
        cart[index].subtotal = cart[index].quantity * wholesalePrice.actualPrice;
        cart[index].wholesaleDiscount = wholesalePrice.discount;
        updateCartDisplay();
    }
}

function removeFromCart(index) {
    if (index >= 0 && index < cart.length) {
        cart.splice(index, 1);
        updateCartDisplay();
    }
}

// ==================== FUNGSI PERHITUNGAN ====================

// PERBAIKAN: Fungsi update total amount dengan diskon member dan grosir
function updateTotalAmount() {
    const totalAmount = document.getElementById('totalAmount');
    const totalAfterDiscount = document.getElementById('totalAfterDiscount');
    const wholesaleDiscountText = document.getElementById('wholesaleDiscountText');

    if (!totalAmount) return;

    const subtotal = calculateSubtotal();
    const totalWholesaleDiscount = calculateTotalWholesaleDiscount();
    const total = calculateTotal();

    if (selectedMember && selectedMember.diskon > 0) {
        const memberDiscountAmount = subtotal * (selectedMember.diskon / 100);
        totalAfterDiscount.innerHTML = `Setelah diskon ${selectedMember.diskon}%: Rp ${(subtotal - memberDiscountAmount).toLocaleString('id-ID')}`;
        totalAfterDiscount.style.display = 'block';
    } else {
        totalAfterDiscount.style.display = 'none';
    }

    if (totalWholesaleDiscount > 0) {
        wholesaleDiscountText.innerHTML = `Diskon Grosir: -Rp ${totalWholesaleDiscount.toLocaleString('id-ID')}`;
        wholesaleDiscountText.style.display = 'block';
    } else {
        wholesaleDiscountText.style.display = 'none';
    }

    totalAmount.textContent = `Rp ${total.toLocaleString('id-ID')}`;
}

// FUNGSI BARU: Hitung total diskon grosir
function calculateTotalWholesaleDiscount() {
    return cart.reduce((sum, item) => sum + (item.wholesaleDiscount || 0), 0);
}

// PERBAIKAN: Fungsi hitung subtotal tanpa diskon
function calculateSubtotal() {
    return cart.reduce((sum, item) => sum + (item.originalPrice * item.quantity), 0);
}

// PERBAIKAN: Fungsi hitung total dengan diskon member dan grosir
function calculateTotal() {
    let total = calculateSubtotal();

    const totalWholesaleDiscount = calculateTotalWholesaleDiscount();
    total -= totalWholesaleDiscount;

    if (selectedMember && selectedMember.diskon > 0) {
        const discountAmount = total * (selectedMember.diskon / 100);
        total = total - discountAmount;
    }

    return Math.max(0, total);
}

// Fungsi hitung kembalian
function calculateChange() {
    const paymentAmount = parseInt(document.getElementById('paymentAmount').value) || 0;
    const total = calculateTotal();
    const change = paymentAmount - total;
    const changeBox = document.getElementById('changeBox');
    const changeAmount = document.getElementById('changeAmount');

    if (!changeBox || !changeAmount) return;

    if (paymentAmount > 0) {
        changeBox.style.display = 'block';
        if (change >= 0) {
            changeAmount.textContent = `Rp ${change.toLocaleString('id-ID')}`;
            changeBox.style.backgroundColor = 'var(--color-success)';
            changeBox.classList.remove('negative');
        } else {
            changeAmount.textContent = `Kurang: Rp ${Math.abs(change).toLocaleString('id-ID')}`;
            changeBox.style.backgroundColor = 'var(--color-danger)';
            changeBox.classList.add('negative');
        }
    } else {
        changeBox.style.display = 'none';
    }
}

// PERBAIKAN: Fungsi untuk mendapatkan metode pembayaran lengkap
function getPaymentMethod() {
    const selected = document.querySelector('input[name="paymentMethod"]:checked');
    const method = selected ? selected.value : 'tunai';

    if (method === 'debit_kredit' && selectedBank) {
        return {
            method: method,
            bank: selectedBank,
            description: `Debit/Kredit - ${selectedBank.toUpperCase()}`
        };
    } else if (method === 'qris_ewallet') {
        return {
            method: method,
            bank: null,
            description: 'QRIS/E-Wallet'
        };
    } else {
        return {
            method: method,
            bank: null,
            description: 'Tunai'
        };
    }
}

// ==================== FUNGSI TRANSAKSI ====================

// PERBAIKAN: Fungsi proses transaksi dengan validasi metode pembayaran
function processTransaction() {
    if (cart.length === 0) {
        alert('Keranjang kosong. Tambahkan produk terlebih dahulu.');
        return;
    }

    const paymentAmount = parseInt(document.getElementById('paymentAmount').value) || 0;
    const paymentMethod = getPaymentMethod();
    const total = calculateTotal();

    if (paymentMethod.method === 'debit_kredit' && !selectedBank) {
        alert('Silakan pilih bank untuk metode pembayaran debit/kredit.');
        return;
    }

    if (paymentMethod.method === 'tunai') {
        if (paymentAmount <= 0) {
            alert('Masukkan nominal pembayaran terlebih dahulu.');
            return;
        }

        if (paymentAmount < total) {
            alert('Nominal pembayaran kurang dari total belanja.');
            return;
        }
    } else {
        document.getElementById('paymentAmount').value = total;
    }

    const completeBtn = document.getElementById('completeTransaction');
    if (completeBtn) {
        completeBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
        completeBtn.disabled = true;
    }

    const transactionData = {
        items: cart.map(item => ({
            product_id: item.id,
            quantity: item.quantity
        })),
        member_id: selectedMember ? selectedMember.id : null,
        metode_pembayaran: paymentMethod.method,
        bank: paymentMethod.bank,
        uang_dibayar: paymentAmount,
        _token: '{{ csrf_token() }}'
    };

    console.log('Mengirim transaksi:', transactionData);

    fetch('{{ route("pos.process") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(transactionData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Response dari server:', data);
        if (data.success) {
            showReceipt(data);
            updateProductStockAfterTransaction();
        } else {
            throw new Error(data.message || 'Terjadi kesalahan saat memproses transaksi.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error: ' + error.message);
    })
    .finally(() => {
        if (completeBtn) {
            completeBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i> SELESAI TRANSAKSI';
            completeBtn.disabled = false;
        }
    });
}

// PERBAIKAN: Fungsi update stok produk setelah transaksi berhasil - FUNGSI YANG HILANG
function updateProductStockAfterTransaction() {
    console.log('Memperbarui stok produk setelah transaksi...');

    cart.forEach(item => {
        const productCard = document.querySelector(`.product-card[data-product-id="${item.id}"]`);
        if (productCard) {
            const currentStock = parseInt(productCard.dataset.productStock);
            const newStock = currentStock - item.quantity;

            // Update data attribute
            productCard.dataset.productStock = newStock;

            // Update tampilan stok
            const stockElement = productCard.querySelector('.text-muted');
            if (stockElement) {
                stockElement.textContent = `Stok: ${newStock}`;

                // Update kelas untuk stok rendah
                if (newStock <= 3) {
                    stockElement.classList.add('low-stock');
                } else {
                    stockElement.classList.remove('low-stock');
                }
            }

            // Update status out-of-stock
            if (newStock === 0) {
                productCard.classList.add('out-of-stock');
                productCard.style.pointerEvents = 'none';
                productCard.style.opacity = '0.6';

                // Tambahkan overlay "HABIS"
                let outOfStockOverlay = productCard.querySelector('.out-of-stock-overlay');
                if (!outOfStockOverlay) {
                    outOfStockOverlay = document.createElement('div');
                    outOfStockOverlay.className = 'out-of-stock-overlay';
                    outOfStockOverlay.style.position = 'absolute';
                    outOfStockOverlay.style.top = '50%';
                    outOfStockOverlay.style.left = '50%';
                    outOfStockOverlay.style.transform = 'translate(-50%, -50%)';
                    outOfStockOverlay.style.background = 'rgba(255, 0, 0, 0.8)';
                    outOfStockOverlay.style.color = 'white';
                    outOfStockOverlay.style.padding = '5px 10px';
                    outOfStockOverlay.style.borderRadius = '4px';
                    outOfStockOverlay.style.fontWeight = 'bold';
                    outOfStockOverlay.style.zIndex = '10';
                    outOfStockOverlay.textContent = 'HABIS';
                    productCard.style.position = 'relative';
                    productCard.appendChild(outOfStockOverlay);
                }
            } else {
                productCard.classList.remove('out-of-stock');
                productCard.style.pointerEvents = 'auto';
                productCard.style.opacity = '1';

                // Hapus overlay "HABIS" jika ada
                const outOfStockOverlay = productCard.querySelector('.out-of-stock-overlay');
                if (outOfStockOverlay) {
                    outOfStockOverlay.remove();
                }
            }
        }
    });

    console.log('Stok produk berhasil diperbarui');
}

// ==================== FUNGSI STRUK ====================

// PERBAIKAN: Fungsi tampilkan struk dengan info grosir
function showReceipt(data) {
    const receiptContent = document.getElementById('receiptContent');
    if (!receiptContent) {
        alert('Error: Tidak dapat menampilkan struk!');
        return;
    }

    const now = new Date();
    const dateTime = now.toLocaleString('id-ID');
    const paymentMethod = getPaymentMethod();

    let itemsHTML = '';
    cart.forEach(item => {
        let wholesaleInfo = '';
        if (item.wholesaleDiscount > 0) {
            wholesaleInfo = `
                <div class="row border-bottom py-1 small text-success">
                    <div class="col-8">↳ Diskon Grosir</div>
                    <div class="col-4 text-end">- Rp ${item.wholesaleDiscount.toLocaleString('id-ID')}</div>
                </div>
            `;
        }

        itemsHTML += `
            <div class="row border-bottom py-1">
                <div class="col-6">${item.name} (${item.quantity}x)</div>
                <div class="col-2 text-center">${item.quantity}</div>
                <div class="col-2 text-end">Rp ${item.originalPrice.toLocaleString('id-ID')}</div>
                <div class="col-2 text-end">Rp ${(item.originalPrice * item.quantity).toLocaleString('id-ID')}</div>
            </div>
            ${wholesaleInfo}
        `;
    });

    let paymentInfoHTML = '';
    if (paymentMethod.method === 'debit_kredit') {
        paymentInfoHTML = `
            <div class="row border-bottom py-1">
                <div class="col-8">Bank</div>
                <div class="col-4 text-end">${paymentMethod.bank.toUpperCase()}</div>
            </div>
        `;
    } else if (paymentMethod.method === 'qris_ewallet') {
        paymentInfoHTML = `
            <div class="row border-bottom py-1">
                <div class="col-8">Metode</div>
                <div class="col-4 text-end">QRIS</div>
            </div>
        `;
    }

    receiptContent.innerHTML = `
        <div class="receipt-header border-bottom pb-2 mb-2">
            <div class="row small">
                <div class="col-6">No. Transaksi:</div>
                <div class="col-6 text-end">${data.order_id}</div>
            </div>
            <div class="row small">
                <div class="col-6">Tanggal:</div>
                <div class="col-6 text-end">${dateTime}</div>
            </div>
            <div class="row small">
                <div class="col-6">Kasir:</div>
                <div class="col-6 text-end">{{ Auth::user()->nama_lengkap }}</div>
            </div>
        </div>

        <div class="receipt-items mb-3">
            <div class="row fw-bold border-bottom pb-1">
                <div class="col-6">Item</div>
                <div class="col-2 text-center">Qty</div>
                <div class="col-2 text-end">Harga</div>
                <div class="col-2 text-end">Subtotal</div>
            </div>
            ${itemsHTML}
        </div>

        <div class="receipt-summary">
            <div class="row border-bottom py-1">
                <div class="col-8">Subtotal</div>
                <div class="col-4 text-end">Rp ${data.subtotal.toLocaleString('id-ID')}</div>
            </div>
            ${data.total_wholesale_discount > 0 ? `
            <div class="row border-bottom py-1 text-success">
                <div class="col-8">Diskon Grosir</div>
                <div class="col-4 text-end">- Rp ${data.total_wholesale_discount.toLocaleString('id-ID')}</div>
            </div>
            ` : ''}
            ${data.total_diskon > 0 ? `
            <div class="row border-bottom py-1">
                <div class="col-8">Diskon Member ${selectedMember ? selectedMember.diskon + '%' : ''}</div>
                <div class="col-4 text-end">- Rp ${data.total_diskon.toLocaleString('id-ID')}</div>
            </div>
            ` : ''}
            <div class="row border-bottom py-2 fw-bold">
                <div class="col-8">TOTAL BAYAR</div>
                <div class="col-4 text-end">Rp ${data.total_bayar.toLocaleString('id-ID')}</div>
            </div>
            ${paymentInfoHTML}
            <div class="row border-bottom py-1">
                <div class="col-8">${paymentMethod.description.toUpperCase()}</div>
                <div class="col-4 text-end">Rp ${data.uang_dibayar.toLocaleString('id-ID')}</div>
            </div>
            ${paymentMethod.method === 'tunai' ? `
            <div class="row py-2 fw-bold text-success">
                <div class="col-8">KEMBALI</div>
                <div class="col-4 text-end">Rp ${data.kembalian.toLocaleString('id-ID')}</div>
            </div>
            ` : ''}
        </div>

        <div class="text-center mt-4 pt-3 border-top">
            <p class="mb-1 fw-bold">✅ TRANSAKSI BERHASIL</p>
            <small class="text-muted">${getPaymentSuccessMessage(paymentMethod.method)}</small>
        </div>
    `;

    const receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
    receiptModal.show();

    console.log('Struk berhasil ditampilkan');
}

// PERBAIKAN: Fungsi pesan sukses berdasarkan metode pembayaran
function getPaymentSuccessMessage(method) {
    switch(method) {
        case 'debit_kredit':
            return 'Pembayaran debit/kredit berhasil diproses';
        case 'qris_ewallet':
            return 'Pembayaran QRIS berhasil diproses';
        default:
            return 'Pembayaran Tunai berhasil diproses';
    }
}

// ==================== FUNGSI MEMBER ====================

// PERBAIKAN: Fungsi pencarian member by phone dengan AJAX
function searchMemberByPhone(phone) {
    const cleanPhone = phone.replace(/\D/g, '');
    const resultDiv = document.getElementById('memberSearchResult');

    if (!resultDiv) return;

    resultDiv.innerHTML = '<div class="text-center">Mencari member...</div>';

    fetch(`{{ route('pos.member.search.phone') }}?phone=${cleanPhone}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                resultDiv.innerHTML = `
                    <div class="alert alert-success">
                        <p><strong>${data.member.nama_lengkap}</strong></p>
                        <p>Telepon: ${data.member.nomor_telepon}</p>
                        <p>Diskon: ${data.member.diskon}%</p>
                        <p>Poin: ${data.member.poin}</p>
                        <button class="btn btn-sm btn-success w-100" onclick="selectMember(${JSON.stringify(data.member).replace(/"/g, '&quot;')})">
                            Pilih Member
                        </button>
                    </div>
                `;
            } else {
                resultDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            resultDiv.innerHTML = '<div class="alert alert-danger">Gagal mencari member</div>';
        });
}

// PERBAIKAN: Fungsi pilih member
function selectMember(member) {
    selectedMember = member;
    const memberInfo = document.getElementById('memberInfo');
    if (memberInfo) {
        memberInfo.style.display = 'block';
        memberInfo.querySelector('#memberName').textContent = member.nama_lengkap;
        memberInfo.querySelector('#memberPhone').textContent = member.nomor_telepon;
        memberInfo.querySelector('#memberPoints').textContent = `Poin: ${member.poin}`;
        memberInfo.querySelector('#discountPercentage').textContent = `${member.diskon}%`;
    }

    const memberModal = bootstrap.Modal.getInstance(document.getElementById('memberModal'));
    if (memberModal) {
        memberModal.hide();
    }

    updateCartDisplay();
    alert(`Member ${member.nama_lengkap} berhasil dipilih! Mendapatkan diskon ${member.diskon}%`);
}

// ==================== FUNGSI LAINNYA ====================

// Fungsi cetak struk
function printReceipt() {
    const receiptContent = document.getElementById('receiptContent');
    if (!receiptContent) {
        alert('Tidak ada struk untuk dicetak!');
        return;
    }

    const printWindow = window.open('', '_blank', 'width=280,height=600,left=100,top=100');
    const paymentMethod = getPaymentMethod();

    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Struk Transaksi</title>
            <meta charset="UTF-8">
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                    font-family: 'Courier New', Courier, monospace;
                }

                body {
                    width: 80mm;
                    min-height: 100mm;
                    padding: 5mm;
                    font-size: 12px;
                    line-height: 1.2;
                    background: white;
                    color: black;
                }

                .receipt-header {
                    text-align: center;
                    margin-bottom: 8px;
                    padding-bottom: 6px;
                    border-bottom: 1px dashed #000;
                }

                .store-name {
                    font-weight: bold;
                    font-size: 16px;
                    margin-bottom: 3px;
                    text-transform: uppercase;
                }

                .store-address, .store-phone {
                    font-size: 10px;
                    margin-bottom: 2px;
                }

                .transaction-info {
                    margin-bottom: 8px;
                    font-size: 10px;
                }

                .transaction-info .row {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 2px;
                }

                .items-header {
                    font-weight: bold;
                    border-bottom: 1px solid #000;
                    padding-bottom: 3px;
                    margin-bottom: 4px;
                    font-size: 11px;
                }

                .item-row {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 3px;
                    font-size: 11px;
                }

                .item-name {
                    flex: 3;
                    text-align: left;
                }

                .item-qty {
                    flex: 1;
                    text-align: center;
                }

                .item-price {
                    flex: 2;
                    text-align: right;
                }

                .item-subtotal {
                    flex: 2;
                    text-align: right;
                }

                .summary {
                    margin-top: 8px;
                    border-top: 1px dashed #000;
                    padding-top: 6px;
                }

                .summary-row {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 3px;
                }

                .total-row {
                    font-weight: bold;
                    border-top: 1px solid #000;
                    padding-top: 4px;
                    margin-top: 4px;
                }

                .change-row {
                    font-weight: bold;
                    color: #000;
                    background: #f0f0f0;
                    padding: 4px;
                    margin-top: 6px;
                }

                .footer {
                    text-align: center;
                    margin-top: 15px;
                    padding-top: 8px;
                    border-top: 1px dashed #000;
                    font-size: 10px;
                }

                .thank-you {
                    font-weight: bold;
                    margin-bottom: 5px;
                }

                .divider {
                    border-bottom: 1px dashed #000;
                    margin: 8px 0;
                }

                .double-divider {
                    border-bottom: 2px solid #000;
                    margin: 10px 0;
                }
            </style>
        </head>
        <body onload="window.print(); setTimeout(() => { window.close(); }, 500);">
            <div class="receipt-header">
                <div class="store-name">TOKO SAUDARA 2</div>
                <div class="store-address">Jl. Contoh Alamat No. 123</div>
                <div class="store-phone">Telp: (021) 123-4567</div>
            </div>

            <div class="transaction-info">
                <div class="row">
                    <div>No. Transaksi:</div>
                    <div>TRX-${Date.now()}</div>
                </div>
                <div class="row">
                    <div>Tanggal:</div>
                    <div>${new Date().toLocaleString('id-ID')}</div>
                </div>
                <div class="row">
                    <div>Kasir:</div>
                    <div>{{ Auth::user()->nama_lengkap }}</div>
                </div>
                <div class="row">
                    <div>Metode:</div>
                    <div>${paymentMethod.description}</div>
                </div>
            </div>

            <div class="divider"></div>

            <div class="items-header">
                <div class="item-row">
                    <div class="item-name">ITEM</div>
                    <div class="item-qty">QTY</div>
                    <div class="item-price">HARGA</div>
                    <div class="item-subtotal">SUBTOTAL</div>
                </div>
            </div>

            ${generatePrintableItems()}

            <div class="double-divider"></div>

            <div class="summary">
                ${generatePrintableSummary(paymentMethod)}
            </div>

            <div class="footer">
                <div class="thank-you">TERIMA KASIH</div>
                <div>Barang yang sudah dibeli</div>
                <div>tidak dapat ditukar/dikembalikan</div>
            </div>
        </body>
        </html>
    `);
    printWindow.document.close();
}

// Fungsi generate item untuk print
function generatePrintableItems() {
    let itemsHTML = '';
    cart.forEach(item => {
        itemsHTML += `
            <div class="item-row">
                <div class="item-name">${item.name}</div>
                <div class="item-qty">${item.quantity}</div>
                <div class="item-price">${formatCurrency(item.originalPrice)}</div>
                <div class="item-subtotal">${formatCurrency(item.originalPrice * item.quantity)}</div>
            </div>
            ${item.wholesaleDiscount > 0 ? `
            <div class="item-row" style="font-size: 10px; color: #008000;">
                <div class="item-name">↳ Diskon Grosir</div>
                <div class="item-qty"></div>
                <div class="item-price"></div>
                <div class="item-subtotal">- ${formatCurrency(item.wholesaleDiscount)}</div>
            </div>
            ` : ''}
        `;
    });
    return itemsHTML;
}

// PERBAIKAN: Fungsi generate summary untuk print dengan info grosir
function generatePrintableSummary(paymentMethod) {
    const subtotal = calculateSubtotal();
    const totalWholesaleDiscount = calculateTotalWholesaleDiscount();
    const memberDiscount = selectedMember ? (calculateTotal() + totalWholesaleDiscount) * (selectedMember.diskon / 100) : 0;
    const total = calculateTotal();
    const paymentAmount = parseInt(document.getElementById('paymentAmount').value) || 0;
    const change = paymentAmount - total;

    let summaryHTML = `
        <div class="summary-row">
            <div>Subtotal:</div>
            <div>${formatCurrency(subtotal)}</div>
        </div>
    `;

    if (totalWholesaleDiscount > 0) {
        summaryHTML += `
            <div class="summary-row" style="color: #008000;">
                <div>Diskon Grosir:</div>
                <div>- ${formatCurrency(totalWholesaleDiscount)}</div>
            </div>
        `;
    }

    if (memberDiscount > 0) {
        summaryHTML += `
            <div class="summary-row">
                <div>Diskon Member:</div>
                <div>- ${formatCurrency(memberDiscount)}</div>
            </div>
        `;
    }

    summaryHTML += `
        <div class="summary-row total-row">
            <div>TOTAL:</div>
            <div>${formatCurrency(total)}</div>
        </div>
        <div class="summary-row">
            <div>${paymentMethod.description}:</div>
            <div>${formatCurrency(paymentAmount)}</div>
        </div>
    `;

    if (paymentMethod.method === 'tunai' && change >= 0) {
        summaryHTML += `
            <div class="summary-row change-row">
                <div>KEMBALI:</div>
                <div>${formatCurrency(change)}</div>
            </div>
        `;
    }

    if (paymentMethod.bank) {
        summaryHTML += `
            <div class="summary-row">
                <div>Bank:</div>
                <div>${paymentMethod.bank.toUpperCase()}</div>
            </div>
        `;
    }

    return summaryHTML;
}

// Fungsi format currency untuk print
function formatCurrency(amount) {
    return 'Rp ' + amount.toLocaleString('id-ID');
}

// ==================== FUNGSI TRANSAKSI BARU ====================

function newTransaction() {
    console.log('Memulai transaksi baru...');

    const receiptModal = bootstrap.Modal.getInstance(document.getElementById('receiptModal'));
    if (receiptModal) {
        receiptModal.hide();
    }

    resetTransaction();

    setTimeout(() => {
        alert('Transaksi baru siap! Silakan tambah produk.');
    }, 300);
}

// PERBAIKAN: Fungsi reset transaksi lengkap termasuk pembayaran
function resetTransaction() {
    cart = [];
    selectedMember = null;
    selectedBank = null;
    updateCartDisplay();

    const paymentAmountInput = document.getElementById('paymentAmount');
    if (paymentAmountInput) {
        paymentAmountInput.value = '';
    }

    const cashMethod = document.getElementById('cashMethod');
    if (cashMethod) {
        cashMethod.checked = true;
    }

    const memberInfo = document.getElementById('memberInfo');
    if (memberInfo) {
        memberInfo.style.display = 'none';
    }

    const changeBox = document.getElementById('changeBox');
    if (changeBox) {
        changeBox.style.display = 'none';
    }

    document.getElementById('debitExtra').classList.remove('active');
    document.getElementById('qrisExtra').classList.remove('active');
    document.querySelectorAll('.bank-option').forEach(option => {
        option.classList.remove('selected');
    });
    resetQRISTimer();

    console.log('Transaksi telah direset');
}
    </script>
@endpush
