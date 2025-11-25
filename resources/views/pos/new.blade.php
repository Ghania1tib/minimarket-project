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

        /* TAMBAHKAN: Style untuk filter kategori */
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

        /* Style untuk card member info yang diperbaiki */
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
                        <!-- TAMBAHKAN: Filter Kategori -->
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
                                <div class="product-card" data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->nama_produk }}"
                                    data-product-price="{{ $product->harga_jual }}"
                                    data-product-stock="{{ $product->stok }}"
                                    data-category-id="{{ $product->kategori ? $product->kategori->id : '' }}"
                                    data-category-name="{{ $product->kategori ? $product->kategori->nama_kategori : 'Tanpa Kategori' }}">
                                    <div class="product-image mb-2">
                                        <div class="bg-theme-light d-flex align-items-center justify-content-center"
                                            style="height: 80px;">
                                            <i class="fas fa-box text-secondary"></i>
                                        </div>
                                    </div>
                                    <h6 class="mb-1">{{ $product->nama_produk }}</h6>
                                    <p class="text-success fw-bold mb-1">Rp
                                        {{ number_format($product->harga_jual, 0, ',', '.') }}</p>
                                    <small class="text-muted">Stok: {{ $product->stok }}</small>
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

               <div class="card text-white mb-3 shadow" id="memberInfo" style="display: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Info Member -->
            <div class="flex-grow-1">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-crown me-2 fs-5 text-warning"></i>
                    <h5 class="mb-0 fw-bold" id="memberName">Fika</h5>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-phone me-2"></i>
                            <span id="memberPhone">01293583445</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-star me-2 text-warning"></i>
                            <span id="memberPoints">14 Poin</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Diskon -->
            <div class="text-center mx-3 px-3">
                <div class="fs-6 fw-semibold">DISKON</div>
                <h2 class="mb-0 fw-bold text-warning" id="discountPercentage" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">10%</h2>
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
                            <option value="debit_kredit">Debit/Kredit</option>
                            <option value="qris_ewallet">QRIS/E-Wallet</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-theme-primary">Nominal Bayar</label>
                        <input type="number" class="form-control form-control-lg" id="paymentAmount"
                            placeholder="Rp ..." min="0">
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

    <!-- Modal Member yang Diperbaiki -->
    <div class="modal fade" id="memberModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cari Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- TAMBAHKAN: Tab untuk pilihan pencarian -->
                    <ul class="nav nav-tabs mb-3" id="memberSearchTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#phoneSearch">Cari by Telepon</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#codeSearch">Cari by Kode</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Tab Pencarian by Telepon -->
                        <div class="tab-pane fade show active" id="phoneSearch">
                            <div class="mb-3">
                                <label class="form-label">Nomor Telepon Member</label>
                                <input type="text" class="form-control" id="memberPhoneInput"
                                    placeholder="Contoh: 081234567890">
                                <small class="text-muted">Masukkan nomor telepon yang terdaftar</small>
                            </div>
                            <button type="button" class="btn btn-primary w-100" id="searchMemberByPhoneBtn">
                                <i class="fas fa-search me-1"></i> Cari by Telepon
                            </button>
                        </div>

                        <!-- Tab Pencarian by Kode -->
                        <div class="tab-pane fade" id="codeSearch">
                            <div class="mb-3">
                                <label class="form-label">Kode Member</label>
                                <input type="text" class="form-control" id="memberKodeInput"
                                    placeholder="Contoh: MB202411250001">
                                <small class="text-muted">Masukkan kode member</small>
                            </div>
                            <button type="button" class="btn btn-primary w-100" id="searchMemberByKodeBtn">
                                <i class="fas fa-search me-1"></i> Cari by Kode
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
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let cart = [];
            let selectedMember = null;

            const cartItems = document.getElementById('cartItems');
            const totalAmount = document.getElementById('totalAmount');
            const emptyCartMessage = document.getElementById('emptyCartMessage');
            const changeBox = document.getElementById('changeBox');
            const changeAmount = document.getElementById('changeAmount');
            const paymentAmountInput = document.getElementById('paymentAmount');

            // Element references untuk fitur member
            const memberInfo = document.getElementById('memberInfo');
            const discountInfo = document.getElementById('discountInfo');
            const totalAfterDiscount = document.getElementById('totalAfterDiscount');

            // TAMBAHKAN: Filter kategori
            let selectedCategoryId = '';
            const categoryButtons = document.querySelectorAll('.category-btn');

            // Event listener untuk filter kategori
            categoryButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Hapus active class dari semua button
                    categoryButtons.forEach(b => b.classList.remove('active'));
                    // Tambah active class ke button yang diklik
                    this.classList.add('active');

                    selectedCategoryId = this.dataset.categoryId;
                    filterProducts();
                });
            });

            // TAMBAHKAN: Fungsi untuk filter produk
            function filterProducts() {
                const searchTerm = document.getElementById('productSearch').value.toLowerCase();
                const productCards = document.querySelectorAll('.product-card');

                productCards.forEach(card => {
                    const productName = card.dataset.productName.toLowerCase();
                    const categoryId = card.dataset.categoryId;

                    const matchesSearch = productName.includes(searchTerm);
                    const matchesCategory = selectedCategoryId === '' || categoryId === selectedCategoryId;

                    if (matchesSearch && matchesCategory) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

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

            // PERBAIKAN: Event listener untuk pencarian member by telepon
            document.getElementById('searchMemberByPhoneBtn').addEventListener('click', function() {
                const phoneMember = document.getElementById('memberPhoneInput').value.trim();
                if (phoneMember) {
                    searchMemberByPhone(phoneMember);
                } else {
                    alert('Masukkan nomor telepon member terlebih dahulu');
                }
            });

            // PERBAIKAN: Event listener untuk pencarian member by kode
            document.getElementById('searchMemberByKodeBtn').addEventListener('click', function() {
                const kodeMember = document.getElementById('memberKodeInput').value.trim();
                if (kodeMember) {
                    searchMemberByKode(kodeMember);
                } else {
                    alert('Masukkan kode member terlebih dahulu');
                }
            });

            // Event listener untuk hapus member
            document.getElementById('removeMember').addEventListener('click', function() {
                removeMember();
            });

            // PERBAIKAN: Fungsi untuk mencari member by telepon
            function searchMemberByPhone(phone) {
                const resultDiv = document.getElementById('memberSearchResult');
                resultDiv.innerHTML =
                    '<div class="text-center"><div class="spinner-border text-primary" role="status"></div><p>Mencari member...</p></div>';

                // Bersihkan format telepon (hapus semua karakter non-digit)
                const cleanPhone = phone.replace(/\D/g, '');

                fetch(`{{ route('pos.member.search.phone') }}?phone=${encodeURIComponent(cleanPhone)}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            resultDiv.innerHTML = `
                            <div class="alert alert-success">
                                <h6>✅ Member Ditemukan</h6>
                                <p class="mb-1"><strong>Nama:</strong> ${data.member.nama_lengkap}</p>
                                <p class="mb-1"><strong>Telepon:</strong> ${data.member.nomor_telepon}</p>
                                <p class="mb-1"><strong>Kode:</strong> ${data.member.kode_member}</p>
                                <p class="mb-1"><strong>Poin:</strong> ${data.member.poin}</p>
                                <p class="mb-0"><strong>Diskon:</strong> ${data.member.diskon}%</p>
                                <button class="btn btn-sm btn-success mt-2 w-100" id="selectMemberBtn" data-member='${JSON.stringify(data.member)}'>
                                    <i class="fas fa-check me-1"></i> Pilih Member Ini
                                </button>
                            </div>
                        `;

                            // Tambahkan event listener setelah elemen dibuat
                            document.getElementById('selectMemberBtn').addEventListener('click', function() {
                                const memberData = JSON.parse(this.dataset.member);
                                selectMember(memberData);
                                $('#memberModal').modal('hide');
                            });
                        } else {
                            resultDiv.innerHTML = `
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                ${data.message}
                            </div>
                        `;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        resultDiv.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Terjadi kesalahan saat mencari member. Periksa koneksi internet Anda.
                        </div>
                    `;
                    });
            }

            // PERBAIKAN: Fungsi untuk mencari member by kode
            function searchMemberByKode(kode) {
                const resultDiv = document.getElementById('memberSearchResult');
                resultDiv.innerHTML =
                    '<div class="text-center"><div class="spinner-border text-primary" role="status"></div><p>Mencari member...</p></div>';

                fetch(`{{ route('pos.member.search') }}?kode=${encodeURIComponent(kode)}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            resultDiv.innerHTML = `
                            <div class="alert alert-success">
                                <h6>✅ Member Ditemukan</h6>
                                <p class="mb-1"><strong>Nama:</strong> ${data.member.nama_lengkap}</p>
                                <p class="mb-1"><strong>Kode:</strong> ${data.member.kode_member}</p>
                                <p class="mb-1"><strong>Telepon:</strong> ${data.member.nomor_telepon || '-'}</p>
                                <p class="mb-1"><strong>Poin:</strong> ${data.member.poin}</p>
                                <p class="mb-0"><strong>Diskon:</strong> ${data.member.diskon}%</p>
                                <button class="btn btn-sm btn-success mt-2 w-100" id="selectMemberByKodeBtn" data-member='${JSON.stringify(data.member)}'>
                                    <i class="fas fa-check me-1"></i> Pilih Member Ini
                                </button>
                            </div>
                        `;

                            // Tambahkan event listener setelah elemen dibuat
                            document.getElementById('selectMemberByKodeBtn').addEventListener('click',
                                function() {
                                    const memberData = JSON.parse(this.dataset.member);
                                    selectMember(memberData);
                                    $('#memberModal').modal('hide');
                                });
                        } else {
                            resultDiv.innerHTML = `
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                ${data.message}
                            </div>
                        `;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        resultDiv.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Terjadi kesalahan saat mencari member. Periksa koneksi internet Anda.
                        </div>
                    `;
                    });
            }

            // PERBAIKAN: Fungsi untuk memilih member
            function selectMember(member) {
                selectedMember = member;

                // Tampilkan info member
                document.getElementById('memberName').textContent = member.nama_lengkap;
                document.getElementById('memberPhone').textContent = `Telepon: ${member.nomor_telepon || '-'}`;
                document.getElementById('memberPoints').textContent = `Poin: ${member.poin}`;
                memberInfo.style.display = 'block';

                // Tampilkan info diskon
                document.getElementById('discountPercentage').textContent = `${member.diskon}%`;
                discountInfo.style.display = 'block';

                // Update total dengan diskon
                updateTotalAmount();

                // Tampilkan alert sukses
                alert(`Member ${member.nama_lengkap} berhasil dipilih! Mendapatkan diskon ${member.diskon}%`);
            }

            // Fungsi untuk menghapus member
            function removeMember() {
                if (selectedMember) {
                    alert(`Member ${selectedMember.nama_lengkap} dihapus`);
                }
                selectedMember = null;
                memberInfo.style.display = 'none';
                discountInfo.style.display = 'none';
                totalAfterDiscount.style.display = 'none';
                updateTotalAmount();
            }

            // Fungsi untuk menghitung uang kembalian
            function calculateChange() {
                const paymentAmount = parseInt(paymentAmountInput.value) || 0;
                const total = calculateTotal();
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

            // Fungsi untuk menghitung total dengan diskon
            function calculateTotal() {
                let total = cart.reduce((sum, item) => sum + item.subtotal, 0);

                // Terapkan diskon member jika ada
                if (selectedMember && selectedMember.diskon > 0) {
                    const discountAmount = total * (selectedMember.diskon / 100);
                    total = total - discountAmount;
                }

                return total;
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

                    cart.forEach((item, index) => {
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

            // Fungsi untuk mengupdate total amount dengan diskon
            function updateTotalAmount() {
                let subtotal = cart.reduce((sum, item) => sum + item.subtotal, 0);
                let total = subtotal;
                let discountAmount = 0;

                // Terapkan diskon member jika ada
                if (selectedMember && selectedMember.diskon > 0) {
                    discountAmount = subtotal * (selectedMember.diskon / 100);
                    total = subtotal - discountAmount;

                    // Tampilkan info diskon
                    totalAfterDiscount.innerHTML =
                        `Setelah diskon ${selectedMember.diskon}%: Rp ${total.toLocaleString('id-ID')}`;
                    totalAfterDiscount.style.display = 'block';
                    totalAmount.textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
                } else {
                    totalAfterDiscount.style.display = 'none';
                    totalAmount.textContent = `Rp ${total.toLocaleString('id-ID')}`;
                }
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

            // Event listener untuk tombol selesai transaksi dengan member
            document.getElementById('completeTransaction').addEventListener('click', function() {
                if (cart.length === 0) {
                    alert('Keranjang kosong. Tambahkan produk terlebih dahulu.');
                    return;
                }

                const paymentAmount = parseInt(paymentAmountInput.value) || 0;
                const paymentMethod = document.getElementById('paymentMethod').value;
                const total = calculateTotal();

                if (paymentAmount < total) {
                    alert('Nominal pembayaran kurang dari total belanja.');
                    return;
                }

                // Proses transaksi dengan member
                processTransaction(paymentMethod, paymentAmount);
            });

            // Fungsi untuk memproses transaksi dengan member
            function processTransaction(paymentMethod, paymentAmount) {
                const transactionData = {
                    items: cart.map(item => ({
                        product_id: item.id,
                        quantity: item.quantity
                    })),
                    member_id: selectedMember ? selectedMember.id : null,
                    metode_pembayaran: paymentMethod,
                    uang_dibayar: paymentAmount,
                    _token: '{{ csrf_token() }}'
                };

                fetch('{{ route('pos.process') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(transactionData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showTransactionResult(data);
                            resetTransaction();
                        } else {
                            alert(data.message || 'Terjadi kesalahan saat memproses transaksi.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan jaringan.');
                    });
            }

            // Fungsi untuk menampilkan hasil transaksi dengan info poin
            function showTransactionResult(data) {
                let message =
                    `Transaksi berhasil!\n\nSubtotal: Rp ${data.subtotal.toLocaleString('id-ID')}\nDiskon: Rp ${data.total_diskon.toLocaleString('id-ID')}\nTotal Bayar: Rp ${data.total_bayar.toLocaleString('id-ID')}\nBayar: Rp ${data.uang_dibayar.toLocaleString('id-ID')}\nKembali: Rp ${data.kembalian.toLocaleString('id-ID')}`;

                if (data.poin_bertambah > 0) {
                    message += `\n\nPoin member bertambah: ${data.poin_bertambah}`;
                }

                alert(message);

                // Redirect ke invoice jika diperlukan
                if (data.invoice_url) {
                    setTimeout(() => {
                        window.open(data.invoice_url, '_blank');
                    }, 1000);
                }
            }

            // Fungsi untuk reset transaksi termasuk member
            function resetTransaction() {
                cart = [];
                selectedMember = null;
                updateCartDisplay();
                paymentAmountInput.value = '';
                memberInfo.style.display = 'none';
                discountInfo.style.display = 'none';
                totalAfterDiscount.style.display = 'none';
            }

            // TAMBAHKAN: Event listener untuk pencarian produk dengan filter kategori
            document.getElementById('productSearch').addEventListener('input', function() {
                filterProducts();
            });

            // TAMBAHKAN: Event listener untuk enter di pencarian produk
            document.getElementById('productSearch').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    filterProducts();
                }
            });

            // PERBAIKAN: Event listener untuk enter di input pencarian member
            document.getElementById('memberPhoneInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const phoneMember = this.value.trim();
                    if (phoneMember) {
                        searchMemberByPhone(phoneMember);
                    }
                }
            });

            document.getElementById('memberKodeInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const kodeMember = this.value.trim();
                    if (kodeMember) {
                        searchMemberByKode(kodeMember);
                    }
                }
            });
        });
    </script>
@endpush
