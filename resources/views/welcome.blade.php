@extends('layouts.app')

@section('title', 'Toko Saudara - Belanja Kebutuhan Harian')

@section('navbar')
    @include('layouts.partials.header')
@endsection

@section('content')
    <style>
        /* OVERRIDE untuk menghapus container putih dari app.blade.php */
        .content-container {
            background-color: transparent !important;
            padding: 0 !important;
            margin: 0 !important;
            max-width: 100% !important;
            box-shadow: none !important;
            border-radius: 0 !important;
        }

        /* Pastikan body menggunakan gradient */
        body {
            background: var(--gradient-bg) !important;
        }

        /* Container khusus untuk welcome page */
        .welcome-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 0.5rem !important;
            /* DIPERSEMPIT */
        }

        /* Promo section lebih kompak */
        .promo-section-compact {
            margin: 1rem auto 1.5rem auto !important;
        }

        /* Products section lebih kompak */
        .products-section-compact {
            margin: 1.5rem auto !important;
        }

        /* Button Lihat Selengkapnya */
        .load-more-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            cursor: pointer;
        }

        .load-more-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .load-more-btn:active {
            transform: translateY(0);
        }

        .load-more-btn i {
            margin-left: 8px;
            transition: transform 0.3s ease;
        }

        .load-more-btn:hover i {
            transform: translateX(3px);
        }

        .load-more-btn.loading {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Button Lihat Lebih Sedikit */
        .show-less-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            cursor: pointer;
        }

        .show-less-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .show-less-btn:active {
            transform: translateY(0);
        }

        .show-less-btn i {
            margin-left: 8px;
            transition: transform 0.3s ease;
        }

        .show-less-btn:hover i {
            transform: translateX(-3px);
        }

        .show-less-btn.loading {
            opacity: 0.7;
            cursor: not-allowed;
        }


        .button-container {
            display: flex;
            justify-content: center !important;
            align-items: cente !important;
            margin-top: 20px;
            width: 100%;
        }

        /* Loading spinner */
        .loading-spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 3px solid rgba(255, 255, 255, .3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Product Count Info */
        .product-count-info {
            text-align: center;
            margin-top: 10px;
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
    <br>
    <!-- Promo Section -->
    <div class="welcome-container">
        <div class="promo-section-compact">
            <div class="row g-3">
                <!-- Promo Utama -->
                <div class="col-lg-8">
                    <div class="promo-card p-4 h-100"
                        style="background: linear-gradient(135deg, #693d72 0%, #80678b 100%); border-radius: 15px; color: white; position: relative; overflow: hidden; min-height: 260px;">
                        <!-- Background Pattern -->
                        <div class="position-absolute w-100 h-100"
                            style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.05\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                        </div>

                        <div class="row h-100 align-items-center position-relative">
                            <div class="col-md-8">
                                <div class="promo-content">
                                    <span class="badge bg-light text-dark mb-3 px-3 py-2 fw-bold">SELAMAT DATANG</span>
                                    <h2 class="display-6 fw-bold mb-3">Temukan Kebutuhan Harian Anda</h2>
                                    <p class="lead mb-4">Toko Saudara menyediakan berbagai produk berkualitas dengan harga
                                        terjangkau untuk kebutuhan sehari-hari Anda.</p>
                                    <a href="#products" class="btn btn-light fw-bold px-4 py-2"
                                        style="border-radius: 8px;">Mulai Belanja</a>
                                </div>
                            </div>
                            <div class="col-lg-4 text-center d-none d-lg-block">
                                <div class="p-3">
                                    <div class="logo-container"
                                        style="display: inline-flex; align-items: center; margin-right: 10px;">
                                        <div class="logo"
                                            style="width: 200px; height: 200px; border-radius: 50%; background: linear-gradient(135deg, #5E548E 0%, #9F86C0 100%); display: flex; align-items: center; justify-content: center; color: white; border: 3px solid #9F86C0; box-shadow: 0 5px 15px rgba(94, 84, 142, 0.3);">
                                            <img src="{{ asset('storage/logo-toko.png') }}" alt="Toko Saudara Logo"
                                                height="200" style="border-radius: 50%;"
                                                onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiByeD0iOCIgZmlsbD0iIzVFMzQ4RSIvPgo8cGF0aCBkPSJNMTggMTVIMjJWMjVIMThWMTVaTTI1IDE1SDI5VjI1SDI1VjE1Wk0xMSAxNUgxNVYyNUgxMVYxNVoiIGZpbGw9IndoaXRlIi8+Cjwvc3ZnPg=='">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Promo Cards -->
                <div class="col-lg-4">
                    <div class="row h-100 g-2">
                        <!-- Gratis Ongkir Card -->
                        <div class="col-12">
                            <div class="promo-card p-3 h-100"
                                style="background: linear-gradient(135deg, #3fae6f 1%, #338357 80%); border-radius: 15px; color: white; position: relative; overflow: hidden; min-height: 125px;">
                                <!-- Background Pattern -->
                                <div class="position-absolute w-100 h-100"
                                    style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.05\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                                </div>

                                <div class="row h-100 align-items-center position-relative">
                                    <div class="col-8">
                                        <h5 class="fw-bold mb-1 fs-5">Gratis Ongkir</h5>
                                        <p class="small mb-0">Wilayah sekitar Rumbai</p>
                                    </div>
                                    <div class="col-4 text-center">
                                        <i class="fas fa-shipping-fast fa-2x" style="opacity: 0.8;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Potongan Grosir Card -->
                        <div class="col-12">
                            <div class="promo-card p-3 h-100"
                                style="background: linear-gradient(135deg, #5980b6 0%, #4457ad 100%); border-radius: 15px; color: white; position: relative; overflow: hidden; min-height: 125px;">
                                <!-- Background Pattern -->
                                <div class="position-absolute w-100 h-100"
                                    style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.05\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                                </div>

                                <div class="row h-100 align-items-center position-relative">
                                    <div class="col-8">
                                        <h5 class="fw-bold mb-1 fs-5">Potongan Member</h5>
                                        <p class="small mb-0">Daftarkan nomor telepon anda!</p>
                                        <p class="small mb-0">Dapatkan diskon spesial</p>
                                    </div>
                                    <div class="col-4 text-center">
                                        <i class="fas fa-tags fa-2x" style="opacity: 0.8;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <!-- Products Section -->
        <div class="products-section-compact">
            <!-- Search & Filter Section -->
            <div class="row mb-3" id="products">
                <div class="col-md-6">
                    <h3 class="mb-0" style="color: var(--color-primary) !important;"><i
                            class="fas fa-shopping-bag me-2"></i> Semua Produk</h3>
                    <p class="text-muted mb-0">
                        Total
                        @if (method_exists($products, 'total'))
                            {{ $products->total() }}
                        @else
                            {{ $products->count() }}
                        @endif
                        produk tersedia
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end gap-2 flex-wrap">
                        <!-- Search Form -->
                        <form action="{{ route('home') }}" method="GET" class="d-flex me-2">
                            <div class="input-group" style="width: 220px;">
                                <input type="text" name="search" class="form-control" placeholder="Cari produk..."
                                    value="{{ request('search') }}"
                                    style="border-radius: 8px 0 0 8px; border: 1px solid #ddd;">
                                <button class="btn btn-primary" type="submit" style="border-radius: 0 8px 8px 0;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>

                        <!-- Category Filter -->
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="categoryDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false"
                                style="border-radius: 8px; border-color: var(--color-primary); color: var(--color-primary); padding: 8px 12px;">
                                <i class="fas fa-filter me-2"></i>
                                @if (request('category_id'))
                                    {{ $kategories->where('id', request('category_id'))->first()->nama_kategori ?? 'Filter Kategori' }}
                                @else
                                    Semua Kategori
                                @endif
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="categoryDropdown" style="border-radius: 8px;">
                                <li>
                                    <a class="dropdown-item {{ !request('category_id') ? 'active' : '' }}"
                                        href="{{ request()->fullUrlWithQuery(['category_id' => null, 'page' => null]) }}">
                                        Semua Kategori
                                    </a>
                                </li>
                                @foreach ($kategories as $kategori)
                                    <li>
                                        <a class="dropdown-item {{ request('category_id') == $kategori->id ? 'active' : '' }}"
                                            href="{{ request()->fullUrlWithQuery(['category_id' => $kategori->id, 'page' => null]) }}">
                                            {{ $kategori->nama_kategori }}
                                            <span
                                                class="badge bg-primary float-end">{{ $kategori->products_count ?? 0 }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Clear Filters -->
                        @if (request('search') || request('category_id'))
                            <a href="{{ route('home') }}" class="btn btn-outline-danger"
                                style="border-radius: 8px; border-color: var(--color-danger); color: var(--color-danger); padding: 8px 12px;">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Search Results Info -->
            @if (request('search') || request('category_id'))
                <div class="alert alert-info mb-3"
                    style="border-radius: 8px;border: 1px solid #ff0000; padding: 10px 14px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-info-circle me-2"></i>
                            Menampilkan hasil
                            @if (request('search'))
                                pencarian "<strong>{{ request('search') }}</strong>"
                            @endif
                            @if (request('search') && request('category_id'))
                                dan
                            @endif
                            @if (request('category_id'))
                                kategori
                                "<strong>{{ $kategories->where('id', request('category_id'))->first()->nama_kategori ?? '' }}</strong>"
                            @endif
                            - Ditemukan {{ $products->count() }} produk
                        </div>
                    </div>
                </div>
            @endif

            <!-- Products Grid -->
            <div class="row g-3 mb-4" id="products-grid">
                @if ($products->isEmpty())
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Tidak ada produk yang ditemukan.</h4>
                        @if (request('search') || request('category_id'))
                            <p class="text-muted">Coba ubah pencarian atau filter kategori Anda.</p>
                            <a href="{{ route('home') }}" class="btn btn-primary">Tampilkan Semua Produk</a>
                        @else
                            <p class="text-muted">Belum ada produk yang tersedia.</p>
                        @endif
                    </div>
                @else
                    @foreach ($products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 product-item">
                            <div class="card product-card h-100 {{ $product->stok <= 0 ? 'out-of-stock' : '' }}"
                                data-product-id="{{ $product->id }}"
                                style="border-radius: 10px; box-shadow: 0 3px 8px rgba(0, 0, 0, 0.06); transition: all 0.3s ease; border: 1px solid #e9ecef; background: white;">

                                @if ($product->stok <= 0)
                                    <div class="out-of-stock-overlay"></div>
                                @endif

                                <!-- Product Image -->
                                <div class="product-image-container position-relative"
                                    style="height: 180px; display: flex; align-items: center; justify-content: center; padding: 16px; background: #f8f9fa; border-radius: 10px 10px 0 0;">
                                    <img src="{{ $product->full_gambar_url }}" alt="{{ $product->nama_produk }}"
                                        class="img-fluid" style="max-height: 100%; object-fit: contain;">

                                    <!-- Stock Badge -->
                                    <div class="position-absolute top-0 start-0 m-2">
                                        @if ($product->stok <= 0)
                                            <span class="badge bg-danger">Stok Habis</span>
                                        @elseif($product->stok < 10)
                                            <span class="badge bg-warning text-dark">Stok Terbatas</span>
                                        @else
                                            <span class="badge bg-success">Tersedia</span>
                                        @endif
                                    </div>

                                    <!-- Critical Stock Warning -->
                                    @if ($product->is_stok_kritis && $product->stok > 0)
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-exclamation-triangle me-1"></i> Stok Kritis
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Body -->
                                <div class="card-body p-2 d-flex flex-column">
                                    <!-- Category and Name -->
                                    <div class="mb-2">
                                        <small class="text-muted d-block mb-1">
                                            {{ $product->kategori->nama_kategori ?? 'Umum' }}
                                        </small>
                                        <h6 class="card-title fw-bold mb-2"
                                            style="line-height: 1.3; min-height: 2.4em; font-size: 0.95rem;">
                                            {{ $product->nama_produk }}
                                        </h6>
                                    </div>

                                    <!-- Description (truncated) -->
                                    @if ($product->deskripsi)
                                        <p class="text-muted small mb-2" style="font-size: 0.8rem; line-height: 1.2;">
                                            {{ \Illuminate\Support\Str::limit($product->deskripsi, 70) }}
                                        </p>
                                    @endif

                                    <!-- Barcode -->
                                    @if ($product->barcode)
                                        <small class="text-muted mb-2" style="font-size: 0.75rem;">
                                            <i class="fas fa-barcode me-1"></i> {{ $product->barcode }}
                                        </small>
                                    @endif

                                    <!-- Price and Add to Cart -->
                                    <div class="mt-auto">
                                        <p class="card-text text-primary fw-bold fs-5 mb-2">
                                            Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                        </p>

                                        @if ($product->stok > 0)
                                            <button class="btn btn-success w-100 add-to-cart-btn"
                                                data-product-id="{{ $product->id }}"
                                                style="border-radius: 6px; padding: 8px;">
                                                <i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang
                                            </button>
                                        @else
                                            <button class="btn btn-secondary w-100" disabled
                                                style="border-radius: 6px; padding: 8px;">
                                                <i class="fas fa-times me-1"></i> Stok Habis
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Button Container untuk berbagai aksi -->
            <div class="row mb-4" id="button-container">
                <div class="col-12">
                    <div class="button-container">
                        @if (method_exists($products, 'hasMorePages') && $products->hasMorePages())
                            <button class="btn load-more-btn" id="load-more-btn" data-next-page="2"
                                data-search="{{ request('search') }}" data-category-id="{{ request('category_id') }}">
                                <i class="fas fa-arrow-down"></i> Lihat Selengkapnya
                            </button>
                        @elseif($products->count() > 0 && $products->total() > 12)
                            <button class="btn show-less-btn" id="show-less-btn">
                                <i class="fas fa-arrow-up"></i> Lihat Lebih Sedikit
                            </button>
                        @elseif($products->count() > 0)
                            <div class="product-count-info">
                                <p class="text-muted mb-0">Semua produk telah ditampilkan ({{ $products->count() }}
                                    produk)</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Inisialisasi interaksi hover untuk card
        document.addEventListener('DOMContentLoaded', function() {
            // Hover effect untuk product cards
            const productCards = document.querySelectorAll('.product-card');
            productCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px)';
                    this.style.boxShadow = '0 6px 15px rgba(0, 0, 0, 0.1)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 3px 8px rgba(0, 0, 0, 0.06)';
                });
            });

            // Hover effect untuk promo cards
            const promoCards = document.querySelectorAll('.promo-card');
            promoCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px)';
                    this.style.boxShadow = '0 8px 15px rgba(0,0,0,0.12)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'none';
                });
            });

            // Load More Button functionality
            const loadMoreBtn = document.getElementById('load-more-btn');
            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    loadMoreProducts(this);
                });
            }

            // Show All Button functionality
            const showAllBtn = document.getElementById('show-all-btn');
            if (showAllBtn) {
                showAllBtn.addEventListener('click', function() {
                    loadAllProducts(this);
                });
            }

            // Show Less Button functionality
            const showLessBtn = document.getElementById('show-less-btn');
            if (showLessBtn) {
                showLessBtn.addEventListener('click', function() {
                    showLessProducts();
                });
            }
        });

        // Fungsi untuk load more products dengan AJAX
        function loadMoreProducts(button) {
            const nextPage = button.getAttribute('data-next-page');
            const search = button.getAttribute('data-search');
            const categoryId = button.getAttribute('data-category-id');

            // Show loading state
            const originalText = button.innerHTML;
            button.innerHTML = '<span class="loading-spinner"></span> Memuat...';
            button.classList.add('loading');
            button.disabled = true;

            // Prepare request parameters
            const params = new URLSearchParams();
            params.append('page', nextPage);
            params.append('ajax', '1'); // Important for AJAX detection
            if (search && search !== 'null') params.append('search', search);
            if (categoryId && categoryId !== 'null') params.append('category_id', categoryId);

            // Debug: log URL
            console.log('Loading products from:', `{{ route('home') }}?${params.toString()}`);

            // Send AJAX request
            fetch(`{{ route('home') }}?${params.toString()}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        // Append new products to grid
                        if (data.html && data.html.trim() !== '') {
                            const productsGrid = document.getElementById('products-grid');
                            productsGrid.insertAdjacentHTML('beforeend', data.html);
                        }

                        // Update next page or hide button
                        if (data.hasMorePages) {
                            button.setAttribute('data-next-page', data.nextPage);
                            button.innerHTML = originalText;
                            button.classList.remove('loading');
                            button.disabled = false;

                            // Update product count info
                            updateProductCountInfo(data.totalProducts, false);
                        } else {
                            // Update to show "Show All" and "Show Less" buttons
                            updateButtonContainerAfterLoadMore(search, categoryId, data.totalProducts);
                        }

                        // Reinitialize hover effects for new cards
                        const newProductCards = document.querySelectorAll('.product-card');
                        newProductCards.forEach(card => {
                            card.addEventListener('mouseenter', function() {
                                this.style.transform = 'translateY(-4px)';
                                this.style.boxShadow = '0 6px 15px rgba(0, 0, 0, 0.1)';
                            });
                            card.addEventListener('mouseleave', function() {
                                this.style.transform = 'translateY(0)';
                                this.style.boxShadow = '0 3px 8px rgba(0, 0, 0, 0.06)';
                            });
                        });

                        // Reinitialize add to cart functionality for new cards
                        initializeCartFunctionality();

                    } else {
                        showAlert('Terjadi kesalahan: ' + (data.message || 'Unknown error'), 'error');
                        button.innerHTML = originalText;
                        button.classList.remove('loading');
                        button.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error loading more products:', error);
                    showAlert('Terjadi kesalahan saat memuat produk: ' + error.message, 'error');
                    button.innerHTML = originalText;
                    button.classList.remove('loading');
                    button.disabled = false;
                });
        }

        // Fungsi untuk reset ke tampilan awal (Lihat Lebih Sedikit)
        function showLessProducts() {
            // Reload page to show only initial products
            window.location.reload();
        }

        // Fungsi untuk update button container setelah load more
        function updateButtonContainerAfterLoadMore(search, categoryId, totalProducts) {
            const buttonContainer = document.getElementById('button-container');

            buttonContainer.innerHTML = `
                <div class="col-12">
                        <button class="btn show-less-btn" id="show-less-btn">
                            <i class="fas fa-arrow-up"></i> Lihat Lebih Sedikit
                        </button>
                    </div>
                    <div class="product-count-info">
                        <p class="text-muted mb-0">Menampilkan ${totalProducts} produk dari total ${totalProducts}</p>
                    </div>
                </div>
            `;

            // Add event listeners to new buttons
            const newShowAllBtn = document.getElementById('show-all-btn');
            const newShowLessBtn = document.getElementById('show-less-btn');

            if (newShowAllBtn) {
                newShowAllBtn.addEventListener('click', function() {
                    loadAllProducts(this);
                });
            }

            if (newShowLessBtn) {
                newShowLessBtn.addEventListener('click', function() {
                    showLessProducts();
                });
            }
        }

        // Fungsi untuk update button container setelah load more
        function updateButtonContainerAfterLoadMore(search, categoryId, totalProducts) {
            const buttonContainer = document.getElementById('button-container');

            // PERBAIKI: Pastikan struktur HTML benar dengan div.button-container
            buttonContainer.innerHTML = `
        <div class="col-12">
            <div class="button-container">
                <button class="btn show-less-btn" id="show-less-btn">
                    <i class="fas fa-arrow-up"></i> Lihat Lebih Sedikit
                </button>
            </div>
            <div class="product-count-info text-center">
                <p class="text-muted mb-0">Menampilkan ${totalProducts} produk dari total ${totalProducts}</p>
            </div>
        </div>
    `;

            // Add event listener to show less button
            const showLessBtn = document.getElementById('show-less-btn');
            if (showLessBtn) {
                showLessBtn.addEventListener('click', function() {
                    showLessProducts();
                });
            }
        }
        // Fungsi untuk update product count info
        function updateProductCountInfo(totalProducts, isAllProducts = false) {
            const productCountInfo = document.querySelector('.product-count-info');
            if (!productCountInfo) {
                const buttonContainer = document.getElementById('button-container');
                const infoDiv = document.createElement('div');
                infoDiv.className = 'product-count-info';
                infoDiv.innerHTML =
                    `<p class="text-muted mb-0">${isAllProducts ? 'Menampilkan semua' : 'Menampilkan'} ${totalProducts} produk</p>`;
                buttonContainer.appendChild(infoDiv);
            } else {
                productCountInfo.innerHTML =
                    `<p class="text-muted mb-0">${isAllProducts ? 'Menampilkan semua' : 'Menampilkan'} ${totalProducts} produk</p>`;
            }
        }

        // Fungsi untuk update search info dengan jumlah produk yang benar
        function updateSearchInfo(totalProducts) {
            const searchInfo = document.querySelector('.alert-info .d-flex div');
            if (searchInfo) {
                const text = searchInfo.textContent;
                // Update jumlah produk dalam info
                const newText = text.replace(/Ditemukan \d+ produk/, `Ditemukan ${totalProducts} produk`);
                searchInfo.textContent = newText;
            }
        }

        // Fungsi untuk menambahkan produk ke keranjang
        function addToCart(productId) {
            if (!productId) {
                showAlert('Error: Product ID tidak valid', 'error');
                return;
            }

            // Tampilkan loading state
            const buttons = document.querySelectorAll(`.add-to-cart-btn[data-product-id="${productId}"]`);
            if (buttons.length === 0) {
                return;
            }

            buttons.forEach(button => {
                const originalText = button.innerHTML;
                button.innerHTML = '<span class="loading-spinner"></span> Menambahkan...';
                button.disabled = true;

                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                }, 5000);
            });

            const url = `/cart/add/${productId}`;

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({}),
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (response.status === 401) {
                        showAlert('Silakan login terlebih dahulu', 'warning');
                        setTimeout(() => {
                            window.location.href = '{{ route('login') }}';
                        }, 1500);
                        return null;
                    }

                    if (!response.ok) {
                        return response.json().then(data => {
                            return {
                                success: false,
                                message: data.message || `Terjadi kesalahan jaringan: ${response.status}`
                            };
                        }).catch(() => {
                            return {
                                success: false,
                                message: `Terjadi kesalahan server (${response.status})`
                            };
                        });
                    }

                    return response.json();
                })
                .then(data => {
                    if (!data) return; // Already handled 401 redirect

                    // Reset button state
                    buttons.forEach(button => {
                        if (data && data.success) {
                            button.innerHTML = '<i class="fas fa-check me-1"></i> Ditambahkan!';
                            button.classList.remove('btn-success');
                            button.classList.add('btn-success', 'added');
                            button.disabled = true;

                            // Reset setelah 2 detik
                            setTimeout(() => {
                                button.innerHTML =
                                    '<i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang';
                                button.classList.remove('added');
                                button.classList.add('btn-success');
                                button.disabled = false;
                            }, 2000);
                        } else {
                            // Reset jika gagal
                            button.innerHTML = '<i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang';
                            button.disabled = false;
                        }
                    });

                    if (data && data.success) {
                        showAlert(data.message, 'success');
                        updateCartCount();
                    } else if (data && data.message) {
                        showAlert(data.message, 'error');
                    }
                })
                .catch(error => {
                    showAlert('Terjadi kesalahan saat menambahkan produk: ' + error.message, 'error');

                    // Reset button state on error
                    buttons.forEach(button => {
                        button.innerHTML = '<i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang';
                        button.disabled = false;
                    });
                });
        }

        // Fungsi untuk memperbarui jumlah keranjang di navbar
        function updateCartCount() {
            fetch('{{ route('cart.count') }}', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const cartBadge = document.getElementById('cart-count-badge');
                    if (cartBadge) {
                        cartBadge.textContent = data.count;
                        if (data.count > 0) {
                            cartBadge.style.display = 'flex';
                        } else {
                            cartBadge.style.display = 'none';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error updating cart count:', error);
                });
        }

        // Fungsi untuk menampilkan alert
        function showAlert(message, type) {
            const existingAlerts = document.querySelectorAll('.alert-fixed');
            existingAlerts.forEach(alert => {
                if (alert.style.opacity !== '0') {
                    alert.remove();
                }
            });

            const alertClass = type === 'success' ? 'alert-success' :
                type === 'error' ? 'alert-danger' :
                type === 'warning' ? 'alert-warning' : 'alert-info';
            const icon = type === 'success' ? 'fa-check-circle' :
                type === 'error' ? 'fa-exclamation-circle' :
                type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle';

            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show alert-fixed" role="alert" style="z-index: 9999;">
                    <i class="fas ${icon} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            document.body.insertAdjacentHTML('afterbegin', alertHtml);

            setTimeout(() => {
                const alert = document.querySelector('.alert-fixed');
                if (alert) {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s';
                    setTimeout(() => alert.remove(), 500);
                }
            }, 5000);
        }

        function initializeCartFunctionality() {
            updateCartCount();

            document.addEventListener('click', function(e) {
                const addToCartBtn = e.target.closest('.add-to-cart-btn');
                if (addToCartBtn) {
                    e.preventDefault();
                    e.stopPropagation();

                    const productId = addToCartBtn.getAttribute('data-product-id');

                    if (productId) {
                        addToCart(productId);
                    }
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeCartFunctionality);
        } else {
            initializeCartFunctionality();
        }

        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                updateCartCount();
            }
        });
    </script>

    <!-- CSS tambahan -->
    <style>
        /* OVERRIDE LENGKAP untuk menghapus semua container putih */
        .main-content .content-container {
            all: unset !important;
            background: transparent !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            box-shadow: none !important;
        }

        /* Pastikan tidak ada background putih di manapun */
        .main-content {
            background: transparent !important;
        }

        /* Container khusus dengan padding sangat sempit */
        .welcome-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 0.5rem !important;
            /* SANGAT SEMPIT */
        }

        /* Promo section yang sangat kompak */
        .promo-section-compact {
            margin: 0.75rem auto 1rem auto !important;
        }

        /* Products section yang sangat kompak */
        .products-section-compact {
            margin: 1rem auto !important;
        }

        /* Promo card */
        .promo-card {
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .promo-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.12);
        }

        /* Product card */
        .product-card {
            transition: all 0.3s ease;
            background: white;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        /* Mobile: lebih sempit lagi */
        @media (max-width: 768px) {
            .welcome-container {
                padding: 0 0.25rem !important;
                /* EXTRA SEMPIT untuk mobile */
            }

            .promo-section-compact {
                margin: 0.5rem auto 0.75rem auto !important;
            }

            .products-section-compact {
                margin: 0.75rem auto !important;
            }

            .button-container {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }

            .button-container button {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
@endpush
