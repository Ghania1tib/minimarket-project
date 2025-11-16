<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ffdde1, #a1c4fd);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .pos-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        .product-card {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            transition: all 0.3s;
            cursor: pointer;
            margin-bottom: 15px;
        }
        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-color: #004f7c;
        }
        .cart-item {
            border-bottom: 1px dashed #dee2e6;
            padding: 10px 0;
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .summary-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
        }
        .btn-checkout {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            font-weight: bold;
            font-size: 1.1em;
        }
        .quantity-btn {
            width: 30px;
            height: 30px;
            border: 1px solid #dee2e6;
            background: white;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .quantity-input {
            width: 50px;
            text-align: center;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #004f7c;">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard.staff') }}">
                <i class="fas fa-cash-register"></i> Point of Sale
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('dashboard.staff') }}">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid pos-container mt-4">
        <div class="row">
            <!-- Kolom Produk -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-boxes me-2"></i> Daftar Produk</h4>
                    </div>
                    <div class="card-body">
                        <!-- Search Bar -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input type="text" id="searchProduct" class="form-control" placeholder="Cari produk...">
                            </div>
                            <div class="col-md-6">
                                <select id="filterCategory" class="form-select">
                                    <option value="">Semua Kategori</option>
                                    @php
                                        $categories = \App\Models\Category::withCount('products')->get();
                                    @endphp
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->nama_kategori }} ({{ $category->products_count }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Daftar Produk -->
                        <div class="row" id="productList">
                            @foreach($products as $product)
                                <div class="col-md-3 mb-3 product-item" data-category="{{ $product->category_id }}">
                                    <div class="card product-card" onclick="addToCart({{ $product->id }})">
                                        <div class="card-body text-center">
                                            @if($product->gambar_url)
                                                <img src="{{ asset('storage/' . $product->gambar_url) }}"
                                                     class="rounded mb-2"
                                                     style="width: 80px; height: 80px; object-fit: cover;"
                                                     alt="{{ $product->nama_produk }}">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center mx-auto mb-2"
                                                     style="width: 80px; height: 80px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <h6 class="card-title mb-1">{{ $product->nama_produk }}</h6>
                                            <p class="card-text text-success mb-1">
                                                <strong>{{ 'Rp ' . number_format($product->harga_jual, 0, ',', '.') }}</strong>
                                            </p>
                                            <small class="text-muted">
                                                Stok: <span class="{{ $product->stok <= $product->stok_kritis ? 'text-danger fw-bold' : 'text-success' }}">
                                                    {{ $product->stok }}
                                                </span>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Keranjang -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0"><i class="fas fa-shopping-cart me-2"></i> Keranjang Belanja</h4>
                    </div>
                    <div class="card-body">
                        <!-- Form Transaksi -->
                        <form id="transactionForm">
                            @csrf

                            <!-- Pilih Member -->
                            <div class="mb-3">
                                <label class="form-label">Pilih Member (Opsional)</label>
                                <select name="member_id" id="memberSelect" class="form-select">
                                    <option value="">Non-Member</option>
                                    @foreach($members as $member)
                                        <option value="{{ $member->id }}">
                                            {{ $member->kode_member }} - {{ $member->nama_lengkap }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Daftar Item di Keranjang -->
                            <div id="cartItems" class="mb-3">
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                                    <p>Keranjang kosong</p>
                                </div>
                            </div>

                            <!-- Summary -->
                            <div class="summary-card p-3 mb-3">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <h5 id="totalItems">0</h5>
                                        <small>Total Item</small>
                                    </div>
                                    <div class="col-4">
                                        <h5 id="totalQuantity">0</h5>
                                        <small>Total Qty</small>
                                    </div>
                                    <div class="col-4">
                                        <h5 id="subtotal">Rp 0</h5>
                                        <small>Subtotal</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Pembayaran -->
                            <div class="mb-3">
                                <label class="form-label">Metode Pembayaran</label>
                                <select name="metode_pembayaran" class="form-select" required>
                                    <option value="tunai">Tunai</option>
                                    <option value="debit_kredit">Debit/Kredit</option>
                                    <option value="qris_ewallet">QRIS/E-Wallet</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Total Bayar</label>
                                <input type="text" id="totalBayar" class="form-control" readonly>
                                <input type="hidden" name="total_bayar" id="totalBayarHidden">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Uang Dibayar</label>
                                <input type="number" name="uang_dibayar" id="uangDibayar" class="form-control" min="0" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kembalian</label>
                                <input type="text" id="kembalian" class="form-control" readonly>
                            </div>

                            <button type="submit" class="btn btn-checkout w-100 py-3" id="checkoutBtn" disabled>
                                <i class="fas fa-check-circle me-2"></i>PROSES TRANSAKSI
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Success -->
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-check-circle me-2"></i>Transaksi Berhasil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-receipt fa-4x text-success mb-3"></i>
                    <h4>Transaksi Selesai!</h4>
                    <p id="successMessage"></p>
                    <div class="row text-start">
                        <div class="col-6"><strong>Order ID:</strong></div>
                        <div class="col-6" id="modalOrderId"></div>
                        <div class="col-6"><strong>Total Bayar:</strong></div>
                        <div class="col-6" id="modalTotalBayar"></div>
                        <div class="col-6"><strong>Uang Dibayar:</strong></div>
                        <div class="col-6" id="modalUangDibayar"></div>
                        <div class="col-6"><strong>Kembalian:</strong></div>
                        <div class="col-6" id="modalKembalian"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="#" id="invoiceLink" class="btn btn-primary">
                        <i class="fas fa-print me-2"></i>Cetak Invoice
                    </a>
                    <button type="button" class="btn btn-success" onclick="resetCart()">
                        <i class="fas fa-plus me-2"></i>Transaksi Baru
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let cart = [];
        let products = @json($products->keyBy('id'));

        // Filter produk
        document.getElementById('searchProduct').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            filterProducts();
        });

        document.getElementById('filterCategory').addEventListener('change', filterProducts);

        function filterProducts() {
            const searchTerm = document.getElementById('searchProduct').value.toLowerCase();
            const categoryFilter = document.getElementById('filterCategory').value;

            document.querySelectorAll('.product-item').forEach(item => {
                const productName = item.querySelector('.card-title').textContent.toLowerCase();
                const productCategory = item.dataset.category;

                const nameMatch = productName.includes(searchTerm);
                const categoryMatch = !categoryFilter || productCategory === categoryFilter;

                item.style.display = (nameMatch && categoryMatch) ? 'block' : 'none';
            });
        }

        // Fungsi keranjang
        function addToCart(productId) {
            const product = products[productId];

            if (product.stok <= 0) {
                alert('Stok produk habis!');
                return;
            }

            const existingItem = cart.find(item => item.product_id === productId);

            if (existingItem) {
                if (existingItem.quantity >= product.stok) {
                    alert('Stok tidak mencukupi!');
                    return;
                }
                existingItem.quantity++;
            } else {
                cart.push({
                    product_id: productId,
                    quantity: 1,
                    harga: product.harga_jual,
                    nama_produk: product.nama_produk,
                    stok: product.stok
                });
            }

            updateCartDisplay();
        }

        function updateQuantity(productId, change) {
            const item = cart.find(item => item.product_id === productId);
            if (!item) return;

            const newQuantity = item.quantity + change;

            if (newQuantity <= 0) {
                removeFromCart(productId);
            } else if (newQuantity > item.stok) {
                alert('Stok tidak mencukupi!');
            } else {
                item.quantity = newQuantity;
                updateCartDisplay();
            }
        }

        function removeFromCart(productId) {
            cart = cart.filter(item => item.product_id !== productId);
            updateCartDisplay();
        }

        function updateCartDisplay() {
            const cartItems = document.getElementById('cartItems');
            const totalItems = document.getElementById('totalItems');
            const totalQuantity = document.getElementById('totalQuantity');
            const subtotal = document.getElementById('subtotal');
            const totalBayar = document.getElementById('totalBayar');
            const totalBayarHidden = document.getElementById('totalBayarHidden');
            const checkoutBtn = document.getElementById('checkoutBtn');

            if (cart.length === 0) {
                cartItems.innerHTML = `
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                        <p>Keranjang kosong</p>
                    </div>
                `;
                totalItems.textContent = '0';
                totalQuantity.textContent = '0';
                subtotal.textContent = 'Rp 0';
                totalBayar.value = 'Rp 0';
                totalBayarHidden.value = '0';
                checkoutBtn.disabled = true;
                return;
            }

            let html = '';
            let totalQty = 0;
            let total = 0;

            cart.forEach(item => {
                const itemTotal = item.harga * item.quantity;
                totalQty += item.quantity;
                total += itemTotal;

                html += `
                    <div class="cart-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">${item.nama_produk}</h6>
                                <small class="text-muted">${formatRupiah(item.harga)} x ${item.quantity}</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="me-2 fw-bold">${formatRupiah(itemTotal)}</span>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="quantity-btn" onclick="updateQuantity(${item.product_id}, -1)">-</button>
                                    <input type="text" class="quantity-input" value="${item.quantity}" readonly>
                                    <button type="button" class="quantity-btn" onclick="updateQuantity(${item.product_id}, 1)">+</button>
                                </div>
                                <button type="button" class="btn btn-danger btn-sm ms-2" onclick="removeFromCart(${item.product_id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });

            cartItems.innerHTML = html;
            totalItems.textContent = cart.length;
            totalQuantity.textContent = totalQty;
            subtotal.textContent = formatRupiah(total);
            totalBayar.value = formatRupiah(total);
            totalBayarHidden.value = total;
            checkoutBtn.disabled = false;

            calculateChange();
        }

        function formatRupiah(amount) {
            return 'Rp ' + Math.round(amount).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Hitung kembalian
        document.getElementById('uangDibayar').addEventListener('input', calculateChange);

        function calculateChange() {
            const uangDibayar = parseFloat(document.getElementById('uangDibayar').value) || 0;
            const totalBayar = parseFloat(document.getElementById('totalBayarHidden').value) || 0;
            const kembalian = uangDibayar - totalBayar;

            document.getElementById('kembalian').value = formatRupiah(kembalian);
        }

        // Proses transaksi
        document.getElementById('transactionForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (cart.length === 0) {
                alert('Keranjang belanja kosong!');
                return;
            }

            const uangDibayar = parseFloat(document.getElementById('uangDibayar').value);
            const totalBayar = parseFloat(document.getElementById('totalBayarHidden').value);

            if (uangDibayar < totalBayar) {
                alert('Uang yang dibayar kurang!');
                return;
            }

            const formData = new FormData(this);
            formData.append('items', JSON.stringify(cart));

            // Show loading
            const checkoutBtn = document.getElementById('checkoutBtn');
            checkoutBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
            checkoutBtn.disabled = true;

            fetch('{{ route("pos.process") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccessModal(data);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memproses transaksi.');
            })
            .finally(() => {
                checkoutBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>PROSES TRANSAKSI';
                checkoutBtn.disabled = false;
            });
        });

        function showSuccessModal(data) {
            document.getElementById('successMessage').textContent = data.message;
            document.getElementById('modalOrderId').textContent = data.order_id;
            document.getElementById('modalTotalBayar').textContent = formatRupiah(data.total_bayar);
            document.getElementById('modalUangDibayar').textContent = formatRupiah(data.uang_dibayar);
            document.getElementById('modalKembalian').textContent = formatRupiah(data.kembalian);
            document.getElementById('invoiceLink').href = data.invoice_url;

            const modal = new bootstrap.Modal(document.getElementById('successModal'));
            modal.show();
        }

        function resetCart() {
            cart = [];
            updateCartDisplay();
            document.getElementById('transactionForm').reset();
            document.getElementById('successModal').classList.remove('show');
            document.body.classList.remove('modal-open');
            document.querySelector('.modal-backdrop').remove();
        }
    </script>
</body>
</html>
