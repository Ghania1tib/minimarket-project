@extends('layouts.app')

@section('title', 'Toko Saudara - Belanja Kebutuhan Harian')

@section('navbar')
    @include('layouts.partials.header')
@endsection

@section('content')
    <div class="content-container">
        <!-- Promo Section -->
        <div class="promo-section mb-5">
            <div class="row g-4">
                <!-- Promo Utama -->
                <div class="col-lg-8">
                    <div class="promo-card p-4 h-100" style="background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%); border-radius: 15px; color: white; position: relative; overflow: hidden; min-height: 250px;">
                        <!-- Background Pattern -->
                        <div class="position-absolute w-100 h-100" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.05\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

                        <div class="row h-100 align-items-center position-relative">
                            <div class="col-md-8">
                                <div class="promo-content">
                                    <span class="badge bg-light text-dark mb-3 px-3 py-2 fw-bold">SELAMAT DATANG</span>
                                    <h2 class="display-6 fw-bold mb-3">Temukan Kebutuhan Harian Anda</h2>
                                    <p class="lead mb-4">Toko Saudara menyediakan berbagai produk berkualitas dengan harga terjangkau untuk kebutuhan sehari-hari Anda.</p>
                                    <a href="#products" class="btn btn-light fw-bold px-4">Mulai Belanja</a>
                                </div>
                            </div>
                            <div class="col-md-4 d-none d-md-block">
                                <div class="text-center">
                                    <i class="fas fa-store fa-5x" style="opacity: 0.8;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Promo Cards -->
                <div class="col-lg-4">
                    <div class="row h-100 g-3">
                        <!-- Gratis Ongkir Card -->
                        <div class="col-12">
                            <div class="promo-card p-3 h-100" style="background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); border-radius: 15px; color: white; position: relative; overflow: hidden; min-height: 120px;">
                                <!-- Background Pattern -->
                                <div class="position-absolute w-100 h-100" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.05\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

                                <div class="row h-100 align-items-center position-relative">
                                    <div class="col-8">
                                        <h5 class="fw-bold mb-1">Gratis Ongkir</h5>
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
                            <div class="promo-card p-3 h-100" style="background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%); border-radius: 15px; color: white; position: relative; overflow: hidden; min-height: 120px;">
                                <!-- Background Pattern -->
                                <div class="position-absolute w-100 h-100" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.05\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

                                <div class="row h-100 align-items-center position-relative">
                                    <div class="col-8">
                                        <h5 class="fw-bold mb-1">Potongan Member</h5>
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

        <!-- Search & Filter Section -->
        <div class="row mb-4" id="products">
            <div class="col-md-6">
                <h3 class="mb-0 text-primary"><i class="fas fa-shopping-bag me-2"></i> Semua Produk</h3>
                <p class="text-muted mb-0">Total {{ $products->total() }} produk tersedia</p>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end gap-2 flex-wrap">
                    <!-- Search Form -->
                    <form action="{{ route('home') }}" method="GET" class="d-flex me-2">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}" style="border-radius: 10px 0 0 10px;">
                            <button class="btn btn-primary" type="submit" style="border-radius: 0 10px 10px 0;">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>

                    <!-- Category Filter -->
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 10px;">
                            <i class="fas fa-filter me-2"></i>
                            @if(request('category_id'))
                                {{ $kategories->where('id', request('category_id'))->first()->nama_kategori ?? 'Filter Kategori' }}
                            @else
                                Semua Kategori
                            @endif
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="categoryDropdown" style="border-radius: 10px;">
                            <li>
                                <a class="dropdown-item {{ !request('category_id') ? 'active' : '' }}"
                                   href="{{ request()->fullUrlWithQuery(['category_id' => null, 'page' => null]) }}">
                                    Semua Kategori
                                </a>
                            </li>
                            @foreach($kategories as $kategori)
                                <li>
                                    <a class="dropdown-item {{ request('category_id') == $kategori->id ? 'active' : '' }}"
                                       href="{{ request()->fullUrlWithQuery(['category_id' => $kategori->id, 'page' => null]) }}">
                                        {{ $kategori->nama_kategori }}
                                        <span class="badge bg-primary float-end">{{ $kategori->products_count ?? 0 }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Clear Filters -->
                    @if(request('search') || request('category_id'))
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary" style="border-radius: 10px;">
                            <i class="fas fa-times me-2"></i> Hapus Filter
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Search Results Info -->
        @if(request('search') || request('category_id'))
            <div class="alert alert-info mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-info-circle me-2"></i>
                        Menampilkan hasil
                        @if(request('search'))
                            pencarian "<strong>{{ request('search') }}</strong>"
                        @endif
                        @if(request('search') && request('category_id'))
                            dan
                        @endif
                        @if(request('category_id'))
                            kategori "<strong>{{ $kategories->where('id', request('category_id'))->first()->nama_kategori ?? '' }}</strong>"
                        @endif
                        - Ditemukan {{ $products->total() }} produk
                    </div>
                </div>
            </div>
        @endif

        <!-- Products Grid -->
        <div class="row g-4 mb-5">
            @if($products->isEmpty())
                <div class="col-12 text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Tidak ada produk yang ditemukan.</h4>
                    @if(request('search') || request('category_id'))
                        <p class="text-muted">Coba ubah pencarian atau filter kategori Anda.</p>
                        <a href="{{ route('home') }}" class="btn btn-primary">Tampilkan Semua Produk</a>
                    @else
                        <p class="text-muted">Belum ada produk yang tersedia.</p>
                    @endif
                </div>
            @else
                @foreach($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card product-card h-100 {{ $product->stok <= 0 ? 'out-of-stock' : '' }}"
                            data-product-id="{{ $product->id }}"
                            style="border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 1px solid #e9ecef;">

                            @if($product->stok <= 0)
                                <div class="out-of-stock-overlay"></div>
                            @endif

                            <!-- Product Image -->
                            <div class="product-image-container position-relative" style="height: 200px; display: flex; align-items: center; justify-content: center; padding: 20px; background: #f8f9fa; border-radius: 12px 12px 0 0;">
                                <img src="{{ $product->full_gambar_url }}" alt="{{ $product->nama_produk }}"
                                    class="img-fluid" style="max-height: 100%; object-fit: contain;">

                                <!-- Stock Badge -->
                                <div class="position-absolute top-0 start-0 m-2">
                                    @if($product->stok <= 0)
                                        <span class="badge bg-danger">Stok Habis</span>
                                    @elseif($product->stok < 10)
                                        <span class="badge bg-warning text-dark">Stok Terbatas</span>
                                    @else
                                        <span class="badge bg-success">Tersedia</span>
                                    @endif
                                </div>

                                <!-- Critical Stock Warning -->
                                @if($product->is_stok_kritis && $product->stok > 0)
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-exclamation-triangle me-1"></i> Stok Kritis
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Body -->
                            <div class="card-body p-3 d-flex flex-column">
                                <!-- Category and Name -->
                                <div class="mb-2">
                                    <small class="text-muted d-block mb-1">
                                        {{ $product->kategori->nama_kategori ?? 'Umum' }}
                                    </small>
                                    <h6 class="card-title fw-bold mb-2" style="line-height: 1.3; min-height: 2.6em;">
                                        {{ $product->nama_produk }}
                                    </h6>
                                </div>

                                <!-- Description (truncated) -->
                                @if($product->deskripsi)
                                    <p class="text-muted small mb-2" style="font-size: 0.85rem; line-height: 1.3;">
                                        {{ \Illuminate\Support\Str::limit($product->deskripsi, 80) }}
                                    </p>
                                @endif

                                <!-- Barcode -->
                                @if($product->barcode)
                                    <small class="text-muted mb-2">
                                        <i class="fas fa-barcode me-1"></i> {{ $product->barcode }}
                                    </small>
                                @endif

                                <!-- Price and Add to Cart -->
                                <div class="mt-auto">
                                    <p class="card-text text-primary fw-bold fs-5 mb-3">
                                        Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                    </p>

                                    @if($product->stok > 0)
                                        <button class="btn btn-success w-100 add-to-cart-btn"
                                                data-product-id="{{ $product->id }}"
                                                style="border-radius: 8px; padding: 10px;">
                                            <i class="fas fa-cart-plus me-2"></i> Tambah ke Keranjang
                                        </button>
                                    @else
                                        <button class="btn btn-secondary w-100" disabled
                                                style="border-radius: 8px; padding: 10px;">
                                            <i class="fas fa-times me-2"></i> Stok Habis
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="row mb-5">
                <div class="col-12">
                    <nav aria-label="Product pagination">
                        <ul class="pagination justify-content-center">
                            {{-- Previous Page Link --}}
                            @if ($products->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">Previous</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                @if ($page == $products->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($products->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next">Next</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">Next</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        @endif
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
                    this.style.transform = 'translateY(-5px)';
                    this.style.boxShadow = '0 8px 20px rgba(0, 0, 0, 0.12)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.08)';
                });
            });

            // Hover effect untuk promo cards
            const promoCards = document.querySelectorAll('.promo-card');
            promoCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px)';
                    this.style.boxShadow = '0 10px 20px rgba(0,0,0,0.15)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'none';
                });
            });
        });

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
                        return { success: false, message: data.message || `Terjadi kesalahan jaringan: ${response.status}` };
                    }).catch(() => {
                        return { success: false, message: `Terjadi kesalahan server (${response.status})` };
                    });
                }

                return response.json();
            })
            .then(data => {
                if (!data) return; // Already handled 401 redirect

                // Reset button state
                buttons.forEach(button => {
                    if (data && data.success) {
                        button.innerHTML = '<i class="fas fa-check me-2"></i> Ditambahkan!';
                        button.classList.remove('btn-success');
                        button.classList.add('btn-success', 'added');
                        button.disabled = true;

                        // Reset setelah 2 detik
                        setTimeout(() => {
                            button.innerHTML = '<i class="fas fa-cart-plus me-2"></i> Tambah ke Keranjang';
                            button.classList.remove('added');
                            button.classList.add('btn-success');
                            button.disabled = false;
                        }, 2000);
                    } else {
                        // Reset jika gagal
                        button.innerHTML = '<i class="fas fa-cart-plus me-2"></i> Tambah ke Keranjang';
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
                    button.innerHTML = '<i class="fas fa-cart-plus me-2"></i> Tambah ke Keranjang';
                    button.disabled = false;
                });
            });
        }

        // Fungsi untuk memperbarui jumlah keranjang di navbar
        function updateCartCount() {
            fetch('{{ route("cart.count") }}', {
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

    <!-- CSS tambahan untuk welcome.blade.php -->
    <style>
        /* Cart badge */
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Stok habis overlay */
        .out-of-stock.card {
            position: relative;
        }
        .out-of-stock.card::after {
            content: "STOK HABIS";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #dc3545;
            font-size: 1.2rem;
            border-radius: 12px;
            z-index: 20;
        }

        /* Loading spinner */
        .loading-spinner {
            display: inline-block;
            width: 15px;
            height: 15px;
            border: 2px solid rgba(255, 255, 255, .3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            margin-right: 5px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Promo card improvements */
        .promo-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .promo-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }

        /* Dropdown improvements */
        .dropdown-item.active {
            background-color: #3498db;
            color: white;
        }

        /* Product card improvements */
        .product-card {
            transition: all 0.3s ease;
        }

        .btn.added {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }

        .text-primary {
            color: #3498db !important;
        }

        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }

        .btn-outline-primary {
            color: #3498db;
            border-color: #3498db;
        }

        .btn-outline-primary:hover {
            background-color: #3498db;
            border-color: #3498db;
        }
    </style>
@endpush
