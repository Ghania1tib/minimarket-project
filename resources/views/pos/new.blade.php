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
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
                                   placeholder="Scan Barcode atau Cari Produk..."
                                   id="productSearch" autofocus>
                            <button class="btn btn-primary-custom" id="searchBtn">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="text-theme-primary mb-3">Daftar Produk</h5>
                        <div class="product-grid" id="productList">
                            <!-- Produk akan dimuat di sini -->
                            <div class="product-card" data-product-id="1"
                                 data-product-name="Aqua 500ml"
                                 data-product-price="6000">
                                <div class="product-image mb-2">
                                    <div class="bg-theme-light d-flex align-items-center justify-content-center"
                                         style="height: 80px;">
                                        <i class="fas fa-box text-secondary"></i>
                                    </div>
                                </div>
                                <h6 class="mb-1">Aqua 500ml</h6>
                                <p class="text-success fw-bold mb-1">Rp 6.000</p>
                                <small class="text-muted">Stok: 10</small>
                            </div>
                            <div class="product-card" data-product-id="2"
                                 data-product-name="Chitato"
                                 data-product-price="5000">
                                <div class="product-image mb-2">
                                    <div class="bg-theme-light d-flex align-items-center justify-content-center"
                                         style="height: 80px;">
                                        <i class="fas fa-box text-secondary"></i>
                                    </div>
                                </div>
                                <h6 class="mb-1">Chitato</h6>
                                <p class="text-success fw-bold mb-1">Rp 5.000</p>
                                <small class="text-muted">Stok: 12</small>
                            </div>
                            <div class="product-card" data-product-id="3"
                                 data-product-name="Minyak"
                                 data-product-price="25000">
                                <div class="product-image mb-2">
                                    <div class="bg-theme-light d-flex align-items-center justify-content-center"
                                         style="height: 80px;">
                                        <i class="fas fa-box text-secondary"></i>
                                    </div>
                                </div>
                                <h6 class="mb-1">Minyak</h6>
                                <p class="text-success fw-bold mb-1">Rp 25.000</p>
                                <small class="text-muted">Stok: 3</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Keranjang & Pembayaran -->
            <div class="col-lg-4">
                <div class="d-grid gap-2 mb-3">
                    <button class="btn btn-primary shadow-sm d-flex align-items-center justify-content-center py-2"
                            data-bs-toggle="modal" data-bs-target="#memberModal">
                        <i class="fas fa-user-plus me-2"></i> Tambah Member
                    </button>
                    <button class="btn btn-warning shadow-sm d-flex align-items-center justify-content-center py-2"
                            id="applyDiscountBtn">
                        <i class="fas fa-tags me-2"></i> Tambah Diskon
                    </button>
                </div>

                <div class="total-box">
                    <small>TOTAL BELANJA</small>
                    <h1 id="totalAmount">Rp 0</h1>
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

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-theme-primary">Metode Pembayaran</label>
                        <select class="form-select" id="paymentMethod">
                            <option value="tunai">Tunai</option>
                            <option value="qris">QRIS/E-Wallet</option>
                            <option value="debit">Debit/Kredit</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-theme-primary">Nominal Bayar</label>
                        <input type="number" class="form-control form-control-lg"
                               id="paymentAmount" placeholder="Rp ..." min="0">
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
                    <h5 class="modal-title">Tambah Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="memberForm">
                        <div class="mb-3">
                            <label class="form-label">Kode Member</label>
                            <input type="text" class="form-control" placeholder="Masukkan kode member">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let cart = [];
        const cartItems = document.getElementById('cartItems');
        const totalAmount = document.getElementById('totalAmount');
        const emptyCartMessage = document.getElementById('emptyCartMessage');
        const changeBox = document.getElementById('changeBox');
        const changeAmount = document.getElementById('changeAmount');
        const paymentAmountInput = document.getElementById('paymentAmount');

        // Event listener untuk menambah produk ke keranjang
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const productName = this.dataset.productName;
                const productPrice = parseInt(this.dataset.productPrice);

                addToCart(productId, productName, productPrice);
            });
        });

        // Event listener untuk input nominal bayar
        paymentAmountInput.addEventListener('input', function() {
            calculateChange();
        });

        // Fungsi untuk menghitung uang kembalian
        function calculateChange() {
            const paymentAmount = parseInt(paymentAmountInput.value) || 0;
            const total = cart.reduce((sum, item) => sum + item.subtotal, 0);
            const change = paymentAmount - total;

            if (paymentAmount > 0) {
                changeBox.style.display = 'block';

                if (change >= 0) {
                    changeBox.classList.remove('negative');
                    changeBox.style.backgroundColor = 'var(--color-success)';
                    changeAmount.textContent = `Rp ${change.toLocaleString('id-ID')}`;
                } else {
                    changeBox.classList.add('negative');
                    changeBox.style.backgroundColor = 'var(--color-danger)';
                    changeAmount.textContent = `Kurang: Rp ${Math.abs(change).toLocaleString('id-ID')}`;
                }
            } else {
                changeBox.style.display = 'none';
            }
        }

        // Fungsi untuk menambah produk ke keranjang
        function addToCart(id, name, price) {
            const existingItem = cart.find(item => item.id === id);

            if (existingItem) {
                existingItem.quantity += 1;
                existingItem.subtotal = existingItem.quantity * price;
            } else {
                cart.push({
                    id: id,
                    name: name,
                    price: price,
                    quantity: 1,
                    subtotal: price
                });
            }

            updateCartDisplay();
        }

        // Fungsi untuk memperbarui tampilan keranjang
        function updateCartDisplay() {
            // Kosongkan tampilan keranjang
            cartItems.innerHTML = '';

            if (cart.length === 0) {
                cartItems.appendChild(emptyCartMessage);
                emptyCartMessage.style.display = 'block';
                changeBox.style.display = 'none';
            } else {
                emptyCartMessage.style.display = 'none';

                let total = 0;

                cart.forEach((item, index) => {
                    total += item.subtotal;

                    const cartItem = document.createElement('div');
                    cartItem.className = 'cart-item';
                    cartItem.innerHTML = `
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">${item.name}</h6>
                                <p class="text-success fw-bold mb-1">Rp ${item.price.toLocaleString('id-ID')}</p>
                            </div>
                            <div class="quantity-controls">
                                <button class="btn btn-sm btn-outline-secondary decrease-qty" data-index="${index}">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <span class="mx-2 fw-bold">${item.quantity}</span>
                                <button class="btn btn-sm btn-outline-secondary increase-qty" data-index="${index}">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger ms-2 remove-item" data-index="${index}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small>Subtotal</small>
                            <strong>Rp ${item.subtotal.toLocaleString('id-ID')}</strong>
                        </div>
                    `;

                    cartItems.appendChild(cartItem);
                });

                // Tambahkan event listener untuk kontrol kuantitas
                document.querySelectorAll('.decrease-qty').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        decreaseQuantity(index);
                    });
                });

                document.querySelectorAll('.increase-qty').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        increaseQuantity(index);
                    });
                });

                document.querySelectorAll('.remove-item').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        removeFromCart(index);
                    });
                });
            }

            // Perbarui total
            updateTotalAmount();
            // Hitung ulang kembalian
            calculateChange();
        }

        // Fungsi untuk mengupdate total amount
        function updateTotalAmount() {
            let total = 0;
            cart.forEach(item => {
                total += item.subtotal;
            });
            totalAmount.textContent = `Rp ${total.toLocaleString('id-ID')}`;
        }

        // Fungsi untuk mengurangi kuantitas
        function decreaseQuantity(index) {
            if (cart[index].quantity > 1) {
                cart[index].quantity -= 1;
                cart[index].subtotal = cart[index].quantity * cart[index].price;
            } else {
                cart.splice(index, 1);
            }
            updateCartDisplay();
        }

        // Fungsi untuk menambah kuantitas
        function increaseQuantity(index) {
            cart[index].quantity += 1;
            cart[index].subtotal = cart[index].quantity * cart[index].price;
            updateCartDisplay();
        }

        // Fungsi untuk menghapus item dari keranjang
        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCartDisplay();
        }

        // Event listener untuk tombol kosongkan keranjang
        document.getElementById('clearCart').addEventListener('click', function() {
            cart = [];
            updateCartDisplay();
            paymentAmountInput.value = '';
        });

        // Event listener untuk tombol selesai transaksi
        document.getElementById('completeTransaction').addEventListener('click', function() {
            if (cart.length === 0) {
                alert('Keranjang kosong. Tambahkan produk terlebih dahulu.');
                return;
            }

            const paymentAmount = parseInt(paymentAmountInput.value) || 0;
            const total = cart.reduce((sum, item) => sum + item.subtotal, 0);

            if (paymentAmount < total) {
                alert('Nominal pembayaran kurang dari total belanja.');
                return;
            }

            // Simulasi proses transaksi
            const change = paymentAmount - total;
            alert(`Transaksi berhasil!\nTotal: Rp ${total.toLocaleString('id-ID')}\nBayar: Rp ${paymentAmount.toLocaleString('id-ID')}\nKembali: Rp ${change.toLocaleString('id-ID')}`);

            cart = [];
            updateCartDisplay();
            paymentAmountInput.value = '';
        });

        // Event listener untuk pencarian produk
        document.getElementById('productSearch').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const productCards = document.querySelectorAll('.product-card');

            productCards.forEach(card => {
                const productName = card.dataset.productName.toLowerCase();
                if (productName.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush
