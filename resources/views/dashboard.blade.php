<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MINIMARKET - Dashboard</title>
    
    <!-- CSS Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <div class="header-container">
            <!-- Logo Section -->
            <div class="logo-section">
                <a href="/" class="logo">
                    <div class="logo-icon">🛒</div>
                    <div class="logo-text">
                        <div class="logo-main">MINIMARKET</div>
                        <div class="logo-sub">Birimde - Sivasi Prodok</div>
                    </div>
                </a>
            </div>

            <!-- Search Section -->
            <div class="search-section">
                <form class="search-form">
                    <div class="search-input-group">
                        <input type="text" class="search-input" placeholder="Cari produk...">
                        <button type="submit" class="search-button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="search-suggestions">
                        <span class="suggestion-title">Trending:</span>
                        <a href="#" class="suggestion-tag">Makanan</a>
                        <a href="#" class="suggestion-tag">Minuman</a>
                        <a href="#" class="suggestion-tag">Snack</a>
                    </div>
                </form>
            </div>

            <!-- Navigation Section -->
            <div class="nav-section">
                <!-- Cart -->
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <div class="nav-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-count">0</span>
                        </div>
                        <span class="nav-label">Keranjang</span>
                    </a>
                    <!-- Cart Dropdown -->
                    <div class="cart-dropdown">
                        <div class="cart-header">
                            <h4>Keranjang Belanja</h4>
                            <span class="cart-total-items">0 items</span>
                        </div>
                        <div class="cart-items">
                            <!-- Cart items will be populated here -->
                        </div>
                        <div class="cart-footer">
                            <div class="cart-total">
                                <span>Total:</span>
                                <span class="total-price">Rp 0</span>
                            </div>
                            <button class="checkout-btn">Checkout</button>
                        </div>
                    </div>
                </div>

                <!-- Account -->
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <div class="nav-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="nav-label">Akun</span>
                    </a>
                    <!-- Account Dropdown -->
                    <div class="account-dropdown">
                        <div class="account-header">
                            <div class="user-avatar">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div class="user-info">
                                <div class="user-name">Guest</div>
                                <div class="user-email">guest@minimarket.com</div>
                            </div>
                        </div>
                        <div class="account-menu">
                            <a href="#" class="menu-item">
                                <i class="fas fa-user"></i>
                                <span>Profil Saya</span>
                            </a>
                            <a href="#" class="menu-item">
                                <i class="fas fa-shopping-bag"></i>
                                <span>Pesanan Saya</span>
                            </a>
                            <a href="#" class="menu-item">
                                <i class="fas fa-heart"></i>
                                <span>Wishlist</span>
                            </a>
                            <div class="menu-divider"></div>
                            <a href="#" class="menu-item logout">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- About -->
                <div class="nav-item">
                    <a href="#" class="nav-link">
                        <div class="nav-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <span class="nav-label">Tentang</span>
                    </a>
                    <!-- About Dropdown -->
                    <div class="about-dropdown">
                        <div class="about-content">
                            <h4>Tentang MINIMARKET</h4>
                            <p>Platform belanja online terpercaya dengan berbagai produk berkualitas.</p>
                            <div class="about-features">
                                <div class="feature">
                                    <i class="fas fa-shipping-fast"></i>
                                    <span>Gratis Ongkir</span>
                                </div>
                                <div class="feature">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>Aman</span>
                                </div>
                                <div class="feature">
                                    <i class="fas fa-headset"></i>
                                    <span>24/7 Support</span>
                                </div>
                            </div>
                            <div class="about-contact">
                                <a href="#" class="contact-link">
                                    <i class="fas fa-phone"></i>
                                    <span>Hubungi</span>
                                </a>
                                <a href="#" class="contact-link">
                                    <i class="fas fa-question-circle"></i>
                                    <span>Bantuan</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="dashboard-container">
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <h1>Selamat Datang di MINIMARKET</h1>
                <h2>Temukan Produk Terbaik dengan Harga Terjangkau</h2>
            </div>

            <div class="dashboard-content">
                <!-- Flash Sale Section -->
                <section class="flash-sale-section">
                    <div class="section-header">
                        <h3>🔥 FLASH SALE MENDADAK</h3>
                        <p>Jangan lewatkan penawaran spesial ini!</p>
                        <div class="sale-timer">
                            <div class="timer-item">
                                <span class="timer-number" id="hours">12</span>
                                <span class="timer-label">Jam</span>
                            </div>
                            <div class="timer-item">
                                <span class="timer-number" id="minutes">30</span>
                                <span class="timer-label">Menit</span>
                            </div>
                            <div class="timer-item">
                                <span class="timer-number" id="seconds">00</span>
                                <span class="timer-label">Detik</span>
                            </div>
                        </div>
                    </div>

                    <div class="flash-sale-grid">
                        <!-- Flash Sale Product 1 -->
                        <div class="flash-sale-card">
                            <div class="sale-badge">FLASH SALE</div>
                            <div class="product-image">
                                <img src="https://via.placeholder.com/300x200/FFD1DC/5A4A6A?text=Produk+1" alt="Produk Flash Sale">
                                <div class="time-left">⏰ 12:29:59</div>
                            </div>
                            <div class="product-info">
                                <h4>Produk Unggulan 1</h4>
                                <p>Deskripsi singkat produk flash sale yang menarik perhatian customer.</p>
                                <div class="price-section">
                                    <span class="original-price">Rp 50.000</span>
                                    <span class="discount-price">Rp 28.000</span>
                                </div>
                                <div class="progress-section">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 75%"></div>
                                    </div>
                                    <div class="sold-text">Terjual: 75/100</div>
                                </div>
                                <button class="buy-now-btn">Beli Sekarang</button>
                            </div>
                        </div>

                        <!-- Flash Sale Product 2 -->
                        <div class="flash-sale-card">
                            <div class="sale-badge">FLASH SALE</div>
                            <div class="product-image">
                                <img src="https://via.placeholder.com/300x200/FFFACD/5A4A6A?text=Produk+2" alt="Produk Flash Sale">
                                <div class="time-left">⏰ 12:29:59</div>
                            </div>
                            <div class="product-info">
                                <h4>Produk Unggulan 2</h4>
                                <p>Deskripsi singkat produk flash sale yang menarik perhatian customer.</p>
                                <div class="price-section">
                                    <span class="original-price">Rp 85.000</span>
                                    <span class="discount-price">Rp 63.750</span>
                                </div>
                                <div class="progress-section">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 60%"></div>
                                    </div>
                                    <div class="sold-text">Terjual: 60/100</div>
                                </div>
                                <button class="buy-now-btn">Beli Sekarang</button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Categories Section -->
                <section class="categories-section">
                    <div class="section-header">
                        <h3>📁 Kategori Populer</h3>
                        <p>Jelajahi berbagai kategori produk kami</p>
                    </div>
                    <div class="categories-grid">
                        <div class="category-card">
                            <div class="category-icon">🥤</div>
                            <span>Minuman</span>
                        </div>
                        <div class="category-card">
                            <div class="category-icon">🍔</div>
                            <span>Makanan</span>
                        </div>
                        <div class="category-card">
                            <div class="category-icon">🍪</div>
                            <span>Snack</span>
                        </div>
                        <div class="category-card">
                            <div class="category-icon">🧼</div>
                            <span>Kebutuhan Rumah</span>
                        </div>
                        <div class="category-card">
                            <div class="category-icon">💊</div>
                            <span>Kesehatan</span>
                        </div>
                        <div class="category-card">
                            <div class="category-icon">🧴</div>
                            <span>Kecantikan</span>
                        </div>
                    </div>
                </section>

                <!-- Popular Products Section -->
                <section class="popular-section">
                    <div class="section-header">
                        <h3>⭐ Produk Unggulan Minggu Ini</h3>
                        <p>Produk terpopuler pilihan customer</p>
                    </div>
                    <div class="popular-grid">
                        <!-- Popular Product 1 -->
                        <div class="popular-card">
                            <div class="popular-image">
                                <img src="https://via.placeholder.com/200x120/D8BFD8/5A4A6A?text=Popular+1" alt="Popular Product">
                            </div>
                            <h4>Produk Populer 1</h4>
                            <p>Deskripsi produk populer</p>
                            <div class="price">Rp 22.500</div>
                            <button class="add-to-cart-btn" data-product-id="1">+ Keranjang</button>
                        </div>

                        <!-- Popular Product 2 -->
                        <div class="popular-card">
                            <div class="popular-image">
                                <img src="https://via.placeholder.com/200x120/B0E0E6/5A4A6A?text=Popular+2" alt="Popular Product">
                            </div>
                            <h4>Produk Populer 2</h4>
                            <p>Deskripsi produk populer</p>
                            <div class="price">Rp 17.500</div>
                            <button class="add-to-cart-btn" data-product-id="2">+ Keranjang</button>
                        </div>

                        <!-- Popular Product 3 -->
                        <div class="popular-card">
                            <div class="popular-image">
                                <img src="https://via.placeholder.com/200x120/FFD1DC/5A4A6A?text=Popular+3" alt="Popular Product">
                            </div>
                            <h4>Produk Populer 3</h4>
                            <p>Deskripsi produk populer</p>
                            <div class="price">Rp 11.500</div>
                            <button class="add-to-cart-btn" data-product-id="3">+ Keranjang</button>
                        </div>
                    </div>
                </section>

                <!-- Special Offers Section -->
                <section class="specials-section">
                    <div class="section-header">
                        <h3>🎉 Penawaran Spesial</h3>
                        <p>Diskon dan penawaran menarik khusus untuk Anda</p>
                    </div>
                    <div class="specials-grid">
                        <!-- Special Offer 1 -->
                        <div class="special-card">
                            <div class="special-badge">SPECIAL OFFER</div>
                            <div class="special-image">
                                <img src="https://via.placeholder.com/320x200/FFFACD/5A4A6A?text=Special+Offer+1" alt="Special Offer">
                                <div class="category-tag">Minuman</div>
                            </div>
                            <div class="special-content">
                                <h4>Paket Minuman Segar Family Size</h4>
                                <p>Nikmati kesegaran minuman berkualitas dengan harga spesial untuk keluarga</p>
                                <div class="rating-info">
                                    <span class="rating">⭐ 4.8 (250 reviews)</span>
                                    <span class="sold-count">Terjual: 1.2k</span>
                                </div>
                                <div class="price-section">
                                    <div class="price-details">
                                        <span class="old-price">Rp 45.000</span>
                                        <span class="new-price">Rp 22.500</span>
                                    </div>
                                    <button class="buy-now-btn" data-product="Paket Minuman Segar">Beli Sekarang</button>
                                </div>
                            </div>
                        </div>

                        <!-- Special Offer 2 -->
                        <div class="special-card">
                            <div class="special-badge">HOT DEAL</div>
                            <div class="special-image">
                                <img src="https://via.placeholder.com/320x200/D8BFD8/5A4A6A?text=Special+Offer+2" alt="Special Offer">
                                <div class="category-tag">Snack</div>
                            </div>
                            <div class="special-content">
                                <h4>Snack Box Premium 10 Variasi</h4>
                                <p>Kumpulan snack premium dengan 10 variasi rasa berbeda untuk teman santai Anda</p>
                                <div class="rating-info">
                                    <span class="rating">⭐ 4.9 (180 reviews)</span>
                                    <span class="sold-count">Terjual: 890</span>
                                </div>
                                <div class="price-section">
                                    <div class="price-details">
                                        <span class="old-price">Rp 35.000</span>
                                        <span class="new-price">Rp 17.500</span>
                                    </div>
                                    <button class="buy-now-btn" data-product="Snack Box Premium">Beli Sekarang</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <!-- JavaScript -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>