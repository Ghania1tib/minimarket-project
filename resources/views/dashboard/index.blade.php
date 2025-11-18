@extends('layouts.app')

@section('content')
    <!-- Welcome Section -->
    <div class="section">
        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="font-family: 'Poppins', sans-serif; font-size: 2.5rem; color: var(--purple-dark); margin-bottom: 0.5rem;">
                MINIMARKET-4
            </h1>
            <p style="font-size: 1.2rem; color: var(--text-medium);">
                Belanja Online Praktis & Terpercaya
            </p>
        </div>

        <!-- Popular Searches -->
        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; justify-content: center; margin-bottom: 2rem;">
            <span style="color: var(--text-medium); font-weight: 600;">Pencarian popular:</span>
            @foreach(['Apel', 'Beras', 'Susu', 'Minyak', 'Telur', 'Gula'] as $tag)
            <a href="?search={{ $tag }}" class="suggestion-tag" style="background: var(--yellow-pastel); padding: 0.5rem 1rem; border-radius: 20px; text-decoration: none; color: var(--text-dark); font-weight: 500; transition: all 0.3s ease;">
                {{ $tag }}
            </a>
            @endforeach
        </div>
    </div>

    <!-- Categories Section -->
    <div class="section">
        <h2 class="section-title">
            <i class="fas fa-star floating"></i>
            Jelajahi Kategori Favorit Anda
        </h2>
        <div class="category-grid">
            @foreach($categories as $category)
            <a href="?category={{ $category }}" class="category-card">
                <i class="fas fa-shopping-basket"></i>
                {{ $category }}
            </a>
            @endforeach
        </div>
    </div>

    <!-- Flash Sale Section -->
    @if($flashSaleProducts->count() > 0)
    <div class="section">
        <h2 class="section-title">
            <i class="fas fa-bolt floating"></i>
            Flash Sale Products
        </h2>
        
        <div class="flash-sale-timer">
            <h3 style="margin-bottom: 1rem;">Limited time offers! Hurry before they're gone!</h3>
            <div class="timer-grid">
                <div class="timer-unit">
                    <div class="timer-number">02</div>
                    <div class="timer-label">Hours</div>
                </div>
                <div class="timer-unit">
                    <div class="timer-number">15</div>
                    <div class="timer-label">Minutes</div>
                </div>
                <div class="timer-unit">
                    <div class="timer-number">30</div>
                    <div class="timer-label">Seconds</div>
                </div>
            </div>
        </div>

        <div class="product-grid">
            @foreach($flashSaleProducts as $product)
            <div class="product-card">
                <div class="product-badge">Flash Sale</div>
                <div class="product-image">
                    @if($product->image_url)
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}">
                    @else
                    <i class="fas fa-shopping-bag" style="font-size: 3rem; color: var(--purple-dark);"></i>
                    @endif
                </div>
                <h3 class="product-name">{{ $product->name }}</h3>
                <p class="product-description">{{ Str::limit($product->description, 80) }}</p>
                <div class="price-section">
                    @if($product->original_price)
                    <span class="old-price">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span>
                    @endif
                    <span class="new-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
                <button class="add-to-cart" 
                        data-product-id="{{ $product->id }}"
                        data-product-name="{{ $product->name }}">
                    <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                </button>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Popular Products -->
    <div class="section">
        <h2 class="section-title">
            <i class="fas fa-fire floating"></i>
            Produk Paling Dicari
        </h2>
        <div class="product-grid">
            @foreach($popularProducts as $product)
            <div class="product-card">
                @if($product->is_special)
                <div class="product-badge" style="background: linear-gradient(135deg, var(--yellow-dark), var(--pink-dark));">Special</div>
                @endif
                <div class="product-image">
                    @if($product->image_url)
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}">
                    @else
                    <i class="fas fa-lemon" style="font-size: 3rem; color: var(--yellow-dark);"></i>
                    @endif
                </div>
                <h3 class="product-name">{{ $product->name }}</h3>
                <p class="product-description">{{ Str::limit($product->description, 80) }}</p>
                <div class="price-section">
                    <span class="new-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
                <button class="add-to-cart" 
                        data-product-id="{{ $product->id }}"
                        data-product-name="{{ $product->name }}">
                    <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                </button>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Special Products -->
    @if($specialProducts->count() > 0)
    <div class="section">
        <h2 class="section-title">
            <i class="fas fa-crown floating"></i>
            Produk Spesial dan Penawaran Menarik!
        </h2>
        <div class="product-grid">
            @foreach($specialProducts as $product)
            <div class="product-card">
                <div class="product-badge" style="background: linear-gradient(135deg, #FFA726, #FF9800);">Spesial</div>
                <div class="product-image">
                    @if($product->image_url)
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}">
                    @else
                    <i class="fas fa-gem" style="font-size: 3rem; color: #FFA726;"></i>
                    @endif
                </div>
                <h3 class="product-name">{{ $product->name }}</h3>
                <p class="product-description">{{ Str::limit($product->description, 80) }}</p>
                <div class="price-section">
                    @if($product->original_price)
                    <span class="old-price">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span>
                    @endif
                    <span class="new-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
                <button class="add-to-cart" 
                        data-product-id="{{ $product->id }}"
                        data-product-name="{{ $product->name }}">
                    <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                </button>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- All Products -->
    @if($products->count() > 0)
    <div class="section">
        <h2 class="section-title">
            <i class="fas fa-boxes floating"></i>
            Semua Produk
        </h2>
        <div class="product-grid">
            @foreach($products as $product)
            <div class="product-card">
                @if($product->is_flash_sale)
                <div class="product-badge">Flash Sale</div>
                @elseif($product->is_special)
                <div class="product-badge" style="background: linear-gradient(135deg, var(--yellow-dark), var(--pink-dark));">Special</div>
                @endif
                <div class="product-image">
                    @if($product->image_url)
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}">
                    @else
                    <i class="fas fa-package" style="font-size: 3rem; color: var(--blue-dark);"></i>
                    @endif
                </div>
                <h3 class="product-name">{{ $product->name }}</h3>
                <p class="product-description">{{ Str::limit($product->description, 80) }}</p>
                <div class="price-section">
                    @if($product->original_price && $product->original_price > $product->price)
                    <span class="old-price">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span>
                    @endif
                    <span class="new-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
                <button class="add-to-cart" 
                        data-product-id="{{ $product->id }}"
                        data-product-name="{{ $product->name }}">
                    <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                </button>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="section" style="text-align: center; padding: 4rem 2rem;">
        <i class="fas fa-search" style="font-size: 4rem; color: var(--text-light); margin-bottom: 1rem;"></i>
        <h3 style="color: var(--text-medium); margin-bottom: 1rem;">Produk tidak ditemukan</h3>
        <p style="color: var(--text-light);">Coba gunakan kata kunci pencarian yang berbeda</p>
    </div>
    @endif
@endsection