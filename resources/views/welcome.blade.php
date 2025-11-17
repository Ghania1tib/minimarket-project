@extends('layouts.app')

@section('title', 'Minimarket - Belanja Kebutuhan Harian')

@section('navbar')
    @include('layouts.partials.header')
@endsection

@section('content')

    <div class="content-container">

        <div id="heroCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
            <div class="carousel-indicators">
                {{-- Cek ketersediaan $heroBanners sebelum loop --}}
                @if (!empty($heroBanners))
                    @foreach ($heroBanners as $key => $banner)
                        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $key }}"
                            class="{{ $key === 0 ? 'active' : '' }}" aria-current="{{ $key === 0 ? 'true' : 'false' }}"
                            aria-label="Slide {{ $key + 1 }}"></button>
                    @endforeach
                @endif
            </div>
            <div class="carousel-inner" style="border-radius: 15px; overflow: hidden; height: 350px;">
                @if (!empty($heroBanners))
                    @foreach ($heroBanners as $key => $banner)
                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}"
                            style="height: 350px; background-color: {{ $banner['color'] ?? 'var(--color-secondary)' }}; display: flex; align-items: center; justify-content: center;">
                            <div class="carousel-caption d-none d-md-block" style="position: static; text-align: left; padding: 20px;">
                                <h2 class="display-5 fw-bold text-white">{{ $banner['title'] }}</h2>
                                <p class="lead text-white">{{ $banner['subtitle'] }}</p>
                                <a href="{{ $banner['link'] }}" class="btn btn-accent mt-3 fw-bold">Lihat Promo <i
                                        class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="carousel-item active" style="height: 350px; background-color: var(--color-accent); display: flex; align-items: center; justify-content: center;">
                        <h3 class="text-white">Tidak Ada Promo Saat Ini</h3>
                    </div>
                @endif
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="flash-sale-section mb-5 shadow-sm" style="background: linear-gradient(to right, var(--color-light), var(--color-accent)); border: 2px solid var(--color-danger); border-radius: 15px; padding: 20px;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0 text-danger" style="color: var(--color-danger) !important;"><i class="fas fa-bolt me-2"></i> FLASH SALE MENDADAK</h3>
                <div class="d-flex align-items-center">
                    <span class="text-dark me-2 fw-bold">Berakhir dalam:</span>
                    <span class="countdown-box" id="flash-sale-countdown" style="background-color: var(--color-danger); color: white; padding: 5px 12px; border-radius: 5px; font-weight: bold;">{{ $countdownString ?? '23:59:59' }}</span>
                </div>
            </div>

            <div class="row g-3">
                @if (!empty($flashSaleProducts))
                    @foreach ($flashSaleProducts as $product)
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card product-card text-center" data-product-id="{{ $product['id'] }}" style="border-radius: 10px; box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);">
                                <span class="badge text-white" style="position: absolute; top: 10px; right: 10px; background-color: var(--color-danger); z-index: 10;">
                                    -{{ $product['discount_rate'] }}%
                                </span>

                                <div class="product-image-container" style="height: 180px; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ $product['img_url'] }}" alt="{{ $product['name'] }}"
                                        class="img-fluid" style="max-height: 100%; object-fit: contain;">
                                </div>

                                <div class="card-body p-3 d-flex flex-column justify-content-between">
                                    <div>
                                        <small class="text-muted d-block mb-1">{{ $product['category_name'] }}</small>
                                        <h6 class="card-title fw-bold mb-1">{{ $product['name'] }}</h6>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-0" style="text-decoration: line-through;">Rp {{ number_format($product['price'], 0, ',', '.') }}
                                        </p>
                                        <p class="card-text fw-bold fs-5" style="color: var(--color-danger);">Rp
                                            {{ number_format($product['discount_price'], 0, ',', '.') }}</p>
                                        <button class="btn btn-accent btn-sm w-100 fw-bold add-to-cart-btn"
                                            data-product-id="{{ $product['id'] }}">
                                            <i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-bolt fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Tidak ada Flash Sale saat ini.</h4>
                    </div>
                @endif
            </div>
        </div>
        <h3 class="mb-4 text-theme-primary"><i class="fas fa-layer-group me-2"></i> Kategori Populer</h3>
        <div class="row g-4 mb-5 text-center">
            @if (empty($popularCategories) || $popularCategories->isEmpty())
                <div class="col-12 text-center py-5">
                    <i class="fas fa-tags fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Belum ada kategori dengan produk.</h4>
                    <p class="text-muted">Silakan tambahkan kategori dan produk terlebih dahulu.</p>
                </div>
            @else
                @foreach ($popularCategories as $category)
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <a href="{{ route('kategori.show', $category->id) }}"
                            class="text-decoration-none d-block p-4 category-card shadow-sm" style="border-radius: 10px; border: 1px solid var(--color-accent); transition: all 0.2s;">
                            <div style="font-size: 2.5rem;" class="mb-2">
                                {{-- Gunakan logic image yang sudah ada --}}
                                @if ($category->icon_url && filter_var($category->icon_url, FILTER_VALIDATE_URL))
                                    <img src="{{ $category->icon_url }}" alt="{{ $category->nama_kategori }}"
                                        style="width: 50px; height: 50px; object-fit: contain;">
                                @elseif($category->icon_url)
                                    <img src="{{ asset('storage/' . $category->icon_url) }}"
                                        alt="{{ $category->nama_kategori }}"
                                        style="width: 50px; height: 50px; object-fit: contain;">
                                @else
                                    <i class="fas fa-box text-theme-primary"></i>
                                @endif
                            </div>
                            <p class="fw-bold mb-0 text-dark">{{ $category->nama_kategori }}</p>
                            <small class="text-muted">
                                {{ $category->products_count ?? 0 }} produk
                            </small>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
        <h3 class="mb-4 text-theme-primary"><i class="fas fa-star me-2"></i> Produk Unggulan Minggu Ini</h3>
        <div class="row g-4 mb-5">
            @if (empty($produkUnggulan) || $produkUnggulan->isEmpty())
                <div class="col-12 text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Belum ada produk yang tersedia.</h4>
                </div>
            @else
                @foreach ($produkUnggulan as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card product-card {{ $product->stok <= 0 ? 'out-of-stock' : '' }}"
                            data-product-id="{{ $product->id }}" style="border-radius: 10px; box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);">

                            @if ($product->stok <= 0)
                                <div class="out-of-stock-overlay"></div>
                            @endif

                            <div class="product-image-container" style="height: 180px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ $product->full_gambar_url }}" alt="{{ $product->nama_produk }}"
                                    class="img-fluid" style="max-height: 100%; object-fit: contain;">
                            </div>

                            <div class="card-body p-3 d-flex flex-column justify-content-between">
                                <div>
                                    <small class="text-muted d-block mb-1">
                                        {{ $product->category->nama_kategori ?? 'Umum' }}
                                    </small>
                                    <h6 class="card-title fw-bold">{{ $product->nama_produk }}</h6>
                                    @if ($product->stok <= 0)
                                        <span class="badge bg-danger">Stok Habis</span>
                                    @elseif($product->stok < 10)
                                        <span class="badge bg-warning text-dark">Stok Terbatas</span>
                                    @else
                                        <span class="badge bg-success-custom">Tersedia</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="card-text text-theme-primary fw-bold fs-5 mb-2">
                                        {{ $product->harga_jual_formatted }}
                                    </p>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('produk.show', $product->id) }}"
                                            class="btn btn-primary-custom btn-sm">
                                            <i class="fas fa-eye me-1"></i> Lihat Detail
                                        </a>
                                        @if ($product->stok > 0)
                                            <button class="btn btn-success-custom btn-sm add-to-cart-btn"
                                                data-product-id="{{ $product->id }}">
                                                <i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang
                                            </button>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>
                                                <i class="fas fa-times me-1"></i> Stok Habis
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card text-center h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-theme-primary mb-3">
                            <i class="fas fa-shipping-fast fa-3x"></i>
                        </div>
                        <h5 class="card-title">Gratis Ongkir</h5>
                        <p class="card-text">Minimal pembelian Rp 100.000 untuk area tertentu</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-theme-primary mb-3">
                            <i class="fas fa-shield-alt fa-3x"></i>
                        </div>
                        <h5 class="card-title">Jaminan Kualitas</h5>
                        <p class="card-text">Produk segar dan berkualitas terjamin</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-theme-primary mb-3">
                            <i class="fas fa-headset fa-3x"></i>
                        </div>
                        <h5 class="card-title">Bantuan 24/7</h5>
                        <p class="card-text">Customer service siap membantu kapan saja</p>
                    </div>
                </div>
            </div>
        </div>
        </div>

@endsection

@push('scripts')
    {{-- Memastikan skrip keranjang/AJAX berjalan dengan benar --}}
    <script>
        // PERBAIKAN: Fungsi alert dan cart logic dipindahkan ke layout/app.blade.php jika memungkinkan
        // Namun, karena ada logic JS yang kompleks dan menggunakan Blade, saya letakkan di sini
        // dan memastikan semua variabel CSS dan route konsisten.

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
                        button.innerHTML = '<i class="fas fa-check me-1"></i> Ditambahkan!';
                        button.classList.remove('btn-accent', 'btn-success-custom');
                        button.classList.add('btn-success');
                        button.disabled = true;

                        // Reset setelah 2 detik
                        setTimeout(() => {
                            button.innerHTML = '<i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang';
                            button.classList.remove('btn-success');
                            if (button.closest('.flash-sale-section')) {
                                button.classList.add('btn-accent');
                            } else {
                                button.classList.add('btn-success-custom');
                            }
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
                console.error('❌ Error updating cart count:', error);
            });
        }

        // Fungsi untuk menampilkan alert (Duplikasi dari layout/app.blade.php, tapi dibutuhkan untuk JS asinkron)
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

        // Fungsi untuk countdown flash sale
        function startFlashSaleCountdown() {
            const countdownElement = document.getElementById('flash-sale-countdown');
            if (!countdownElement) return;

            // Logika waktu countdown tetap (asumsi 24 jam)
            let time = 23 * 60 * 60 + 59 * 60 + 59;

            function updateCountdown() {
                const hours = Math.floor(time / 3600);
                const minutes = Math.floor((time % 3600) / 60);
                const seconds = time % 60;

                countdownElement.textContent =
                    `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                if (time <= 0) {
                    clearInterval(countdownInterval);
                    countdownElement.textContent = "00:00:00";
                    showAlert('Flash sale telah berakhir!', 'warning');
                } else {
                    time--;
                }
            }

            updateCountdown();
            const countdownInterval = setInterval(updateCountdown, 1000);
        }

        function initializeCartFunctionality() {
            updateCartCount();
            startFlashSaleCountdown();

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

        // CSS tambahan untuk welcome.blade.php
        document.head.insertAdjacentHTML('beforeend', `
            <style>
                /* Cart badge */
                .cart-badge {
                    position: absolute;
                    top: -8px;
                    right: -8px;
                    background-color: var(--color-danger);
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
                    background: rgba(255, 255, 255, 0.8);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-weight: bold;
                    color: var(--color-danger);
                    font-size: 1.2rem;
                    border-radius: 10px;
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

            </style>
        `);
    </script>
@endpush
