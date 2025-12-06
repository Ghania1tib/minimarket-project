<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Stok - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 280px;
            --color-primary: #5E548E;
            --color-secondary: #9F86C0;
            --color-accent: #E0B1CB;
            --color-danger: #E07A5F;
            --color-success: #70C1B3;
            --color-light: #F0E6EF;
            --color-white: #ffffff;
            --gradient-bg: linear-gradient(135deg, #F0E6EF 0%, #D891EF 100%);
            --font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background: var(--gradient-bg);
            font-family: var(--font-family);
            min-height: 100vh;
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .content-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: margin-left 0.3s ease;
            background: var(--gradient-bg);
            min-height: 100vh;
        }

        .check-card {
            max-width: 800px;
            margin: 20px auto;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .result-box {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            border-left: 5px solid #004f7c;
            display: none;
        }

        .search-results {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: none;
            position: absolute;
            width: calc(100% - 90px);
            background: white;
            z-index: 1000;
        }

        .search-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
        }

        .search-item:hover {
            background-color: #f8f9fa;
        }

        .loading-spinner {
            display: none;
            text-align: center;
            padding: 10px;
        }

        .stok-habis {
            color: #dc3545;
        }

        .stok-tersedia {
            color: #198754;
        }

        .stok-sedikit {
            color: #ffc107;
        }

        .navbar-custom {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .navbar-custom .navbar-brand {
            color: white !important;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                margin-left: 0;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <!-- Sidebar -->
        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'owner')
            @include('layouts.sidebar-admin')
        @elseif(Auth::user()->role === 'kasir' || Auth::user()->role === 'staff')
            @include('layouts.sidebar-kasir')
        @endif

        <div class="content-wrapper">
            <!-- Content -->
            <div class="card check-card">
                <div class="card-header bg-primary text-white text-center p-3" style="background-color: #004f7c !important; border-radius: 15px 15px 0 0;">
                    <h4 class="mb-0"><i class="fas fa-cubes me-2"></i> CEK HARGA & STOK PRODUK</h4>
                </div>
                <div class="card-body p-4">
                    <div class="input-group mb-4">
                        <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                        <input type="text" id="searchInput" class="form-control form-control-lg"
                               placeholder="Masukkan Barcode / Nama Produk..." autofocus
                               autocomplete="off">
                        <button class="btn btn-primary" id="searchBtn">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>

                    <!-- Loading Spinner -->
                    <div class="loading-spinner" id="loadingSpinner">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Mencari produk...</p>
                    </div>

                    <!-- Search Results Dropdown -->
                    <div class="search-results" id="searchResults"></div>

                    <!-- Result Display -->
                    <div class="result-box mt-4" id="resultBox">
                        <!-- Hasil akan ditampilkan di sini oleh JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchBtn = document.getElementById('searchBtn');
            const searchResults = document.getElementById('searchResults');
            const resultBox = document.getElementById('resultBox');
            const loadingSpinner = document.getElementById('loadingSpinner');

            // Format angka ke Rupiah
            function formatRupiah(angka) {
                if (!angka || isNaN(angka)) {
                    return 'Rp 0';
                }
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(angka);
            }

            // Tentukan class stok berdasarkan jumlah
            function getStokClass(stok) {
                if (stok <= 0) {
                    return 'stok-habis';
                } else if (stok <= 10) {
                    return 'stok-sedikit';
                } else {
                    return 'stok-tersedia';
                }
            }

            // Tentukan status stok
            function getStokStatus(stok) {
                if (stok <= 0) {
                    return 'Stok Habis';
                } else if (stok <= 10) {
                    return 'Stok Menipis';
                } else {
                    return 'Stok Tersedia (Unit)';
                }
            }

            // Tampilkan hasil produk
            function displayProduct(product) {
                const stokClass = getStokClass(product.stok);
                const stokStatus = getStokStatus(product.stok);

                // PERBAIKAN: Gunakan harga_jual bukan harga
                const hargaJual = product.harga_jual || 0;

                resultBox.innerHTML = `
                    <h5 class="text-success"><i class="fas fa-check-circle me-2"></i> Produk Ditemukan!</h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-8">
                            <h6>Nama: ${product.nama_produk}</h6>
                            <p class="mb-1">Barcode: ${product.barcode || 'Tidak ada'}</p>
                            <p class="mb-1">Kategori: ${product.kategori ? product.kategori.nama_kategori : 'Tidak ada kategori'}</p>
                            <h4 class="text-danger mt-2">Harga Jual: ${formatRupiah(hargaJual)}</h4>
                            ${product.stok_kritis && product.stok <= product.stok_kritis ?
                                `<p class="text-warning mt-2"><i class="fas fa-exclamation-triangle"></i> <strong>Stok Kritis!</strong> Stok hampir habis (minimum: ${product.stok_kritis})</p>` :
                                ''}
                        </div>
                        <div class="col-md-4 text-center">
                            <h1 class="${stokClass} mt-2">${product.stok}</h1>
                            <p class="mb-0 text-muted">${stokStatus}</p>
                            ${product.stok <= 0 ?
                                '<p class="text-danger mt-2"><small><i class="fas fa-exclamation-triangle"></i> Stok habis!</small></p>' :
                                ''}
                            ${product.stok > 0 && product.stok <= 10 ?
                                '<p class="text-warning mt-2"><small><i class="fas fa-exclamation-circle"></i> Stok menipis!</small></p>' :
                                ''}
                        </div>
                    </div>
                    ${product.deskripsi ? `<div class="mt-3"><strong>Deskripsi:</strong><br>${product.deskripsi}</div>` : ''}
                `;
                resultBox.style.display = 'block';
            }

            // Cari produk
            function searchProducts() {
                const query = searchInput.value.trim();

                if (query.length === 0) {
                    alert('Masukkan barcode atau nama produk!');
                    return;
                }

                loadingSpinner.style.display = 'block';
                searchResults.style.display = 'none';
                resultBox.style.display = 'none';

                fetch(`/inventory/search?q=${encodeURIComponent(query)}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(products => {
                        loadingSpinner.style.display = 'none';

                        if (products.length === 0) {
                            resultBox.innerHTML = `
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i> Produk tidak ditemukan!
                                </div>
                            `;
                            resultBox.style.display = 'block';
                            return;
                        }

                        // Jika hanya ada 1 hasil, langsung tampilkan
                        if (products.length === 1) {
                            displayProduct(products[0]);
                        } else {
                            // Tampilkan dropdown pilihan
                            showSearchResults(products);
                        }
                    })
                    .catch(error => {
                        loadingSpinner.style.display = 'none';
                        console.error('Error:', error);
                        resultBox.innerHTML = `
                            <div class="alert alert-danger">
                                <i class="fas fa-times-circle me-2"></i> Terjadi kesalahan saat mencari produk.
                            </div>
                        `;
                        resultBox.style.display = 'block';
                    });
            }

            // Tampilkan hasil pencarian dalam dropdown
            function showSearchResults(products) {
                searchResults.innerHTML = '';

                products.forEach(product => {
                    const item = document.createElement('div');
                    item.className = 'search-item';

                    // PERBAIKAN: Gunakan harga_jual bukan harga
                    const hargaJual = product.harga_jual || 0;
                    const stokClass = getStokClass(product.stok);

                    item.innerHTML = `
                        <strong>${product.nama_produk}</strong>
                        <br>
                        <small class="text-muted">
                            Barcode: ${product.barcode || 'Tidak ada'} |
                            Stok: <span class="${stokClass}">${product.stok}</span> |
                            Harga: ${formatRupiah(hargaJual)}
                        </small>
                    `;
                    item.addEventListener('click', function() {
                        displayProduct(product);
                        searchResults.style.display = 'none';
                        searchInput.value = product.nama_produk;
                    });
                    searchResults.appendChild(item);
                });

                searchResults.style.display = 'block';
            }

            // Event Listeners
            searchBtn.addEventListener('click', searchProducts);

            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchProducts();
                }
            });

            // Sembunyikan hasil pencarian ketika klik di luar
            document.addEventListener('click', function(e) {
                if (!searchResults.contains(e.target) && e.target !== searchInput) {
                    searchResults.style.display = 'none';
                }
            });

            // Auto-search saat mengetik (opsional, bisa diaktifkan jika diinginkan)
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                if (this.value.length > 2) {
                    searchTimeout = setTimeout(searchProducts, 500);
                } else {
                    searchResults.style.display = 'none';
                    resultBox.style.display = 'none';
                }
            });

            // Focus pada input search saat halaman dimuat
            searchInput.focus();
        });
    </script>
</body>
</html>
