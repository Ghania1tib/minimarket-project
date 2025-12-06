<header class="dashboard-header">
    <div class="header-content">
        <!-- Logo dan judul dengan link langsung -->
        <a href="{{ url('/') }}" class="logo-link" style="text-decoration: none; color: inherit;">
            <h1>MINIMARKET-4</h1>
        </a>
        
        <!-- Search Bar -->
        <div class="search-container">
            <form class="search-form" action="#" method="GET">
                <div class="search-input-container">
                    <input type="text" class="search-input" placeholder="Cari produk... (contoh: Apel, Beras, Susu)">
                    <button type="submit" class="search-btn">
                        <span class="search-icon">🔍</span>
                    </button>
                </div>
            </form>
            
            <!-- Popular Search Tags -->
            <div class="search-suggestions">
                <span class="suggestion-label">Pencarian popular:</span>
                <div class="suggestion-tags">
                    <a href="#" class="suggestion-tag">Apel</a>
                    <a href="#" class="suggestion-tag">Beras</a>
                    <a href="#" class="suggestion-tag">Susu</a>
                    <a href="#" class="suggestion-tag">Minyak</a>
                </div>
            </div>
        </div>
        
        <!-- Navigation Icons -->
        <div class="header-actions">
            <!-- Cart Icon -->
            <a href="{{ url('/cart') }}" class="action-btn cart-btn">
                <span class="action-icon">🛒</span>
                <span class="action-text">Keranjang</span>
                <span class="cart-count">0</span>
            </a>
            
            <!-- Account Icon -->
            <a href="#" class="action-btn account-btn">
                <span class="action-icon">👤</span>
                <span class="action-text">Akun</span>
            </a>
            
            <!-- About Icon -->
            <a href="#" class="action-btn about-btn">
                <span class="action-icon">ℹ️</span>
                <span class="action-text">Tentang</span>
            </a>
        </div>
    </div>
</header>