@extends('layouts.admin-base')

@section('title', 'Manajemen Produk - Toko Saudara 2')

@section('content')
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h2 class="section-title mb-0">
                                    <i class="fas fa-boxes me-2"></i>Manajemen Produk
                                </h2>
                                <p class="text-muted mb-0">Kelola data produk toko</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="{{ route('produk.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i>Tambah Produk Baru
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter dan Pencarian -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Filter Kategori -->
                        <div class="mb-3">
                            <label class="form-label text-theme-primary fw-semibold">
                                <i class="fas fa-filter me-1"></i>Filter Kategori
                            </label>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('produk.index') }}"
                                    class="btn btn-sm {{ !request('kategori') ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Semua Kategori
                                </a>
                                @foreach ($categories as $category)
                                    <a href="{{ route('produk.index', ['kategori' => $category->id]) }}"
                                        class="btn btn-sm {{ request('kategori') == $category->id ? 'btn-primary' : 'btn-outline-primary' }}">
                                        {{ $category->nama_kategori }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <form action="{{ route('produk.search') }}" method="GET" class="mb-0">
                            @if (request('kategori'))
                                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                            @endif
                            <div class="input-group mb-2">
                                <span class="input-group-text"
                                    style="
            background-color: transparent;
            border: 2px solid var(--color-accent);
            border-right: none;
            border-radius: var(--border-radius-sm) 0 0 var(--border-radius-sm);
        ">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="keyword" class="form-control search-box border-start-0"
                                    placeholder="Cari produk berdasarkan nama, barcode, atau kategori..."
                                    value="{{ request('keyword') }}">
                                <button class="btn btn-primary" type="submit"
                                    style="
            border-radius: 0 var(--border-radius-sm) var(--border-radius-sm) 0;
        ">
                                    <i class="fas fa-search me-2"></i>Cari
                                </button>
                            </div>

                            <!-- Reset button jika ada keyword -->
                            @if (request('keyword'))
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <small class="text-muted">
                                        <i class="fas fa-search me-1"></i>
                                        Hasil pencarian untuk: "<strong>{{ request('keyword') }}</strong>"
                                    </small>
                                    <a href="{{ route('produk.index') }}{{ request('kategori') ? '?kategori=' . request('kategori') : '' }}"
                                        class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-times me-1"></i>Reset pencarian
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Filter Aktif -->
        @if (request('kategori') && request('kategori') != '')
            @php
                $kategoriAktif = $categories->where('id', request('kategori'))->first();
            @endphp
            <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-filter me-2"></i>
                        Menampilkan produk dengan kategori:
                        <strong>{{ $kategoriAktif->nama_kategori ?? 'Tidak Diketahui' }}</strong>
                        @if (request('keyword'))
                            dan pencarian: "<strong>{{ request('keyword') }}</strong>"
                        @endif
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if (request('keyword') && !request('kategori'))
            <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-search me-2"></i>
                        Menampilkan hasil pencarian: "<strong>{{ request('keyword') }}</strong>"
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        <!-- Products Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($products->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Produk</th>
                                            <th>Kategori</th>
                                            <th>Barcode</th>
                                            <th>Harga Beli</th>
                                            <th>Harga Jual</th>
                                            <th>Stok</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            @php
                                                $isLowStock = $product->stok <= $product->stok_kritis;
                                                $stockClass =
                                                    $product->stok > 0
                                                        ? ($isLowStock
                                                            ? 'bg-warning'
                                                            : 'bg-success')
                                                        : 'bg-danger';
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if ($product->gambar_url)
                                                            <img src="{{ $product->full_gambar_url }}"
                                                                class="product-avatar me-3"
                                                                alt="{{ $product->nama_produk }}">
                                                        @else
                                                            <div class="product-avatar me-3">
                                                                <i class="fas fa-box"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <strong
                                                                class="text-primary d-block">{{ $product->nama_produk }}</strong>
                                                            <small
                                                                class="text-muted">{{ Str::limit($product->deskripsi ?? '-', 30) }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-category rounded-pill">
                                                        {{ $product->kategori->nama_kategori ?? '-' }}
                                                    </span>
                                                </td>
                                                <td>{{ $product->barcode ?? '-' }}</td>
                                                <td class="text-danger fw-semibold">
                                                    {{ 'Rp ' . number_format($product->harga_beli, 0, ',', '.') }}
                                                </td>
                                                <td class="text-success fw-semibold">
                                                    {{ 'Rp ' . number_format($product->harga_jual, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    <span class="badge {{ $stockClass }} rounded-pill p-2">
                                                        {{ $product->stok }}
                                                        @if ($isLowStock && $product->stok > 0)
                                                            <i class="fas fa-exclamation-triangle ms-1"></i>
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ route('produk.show', $product->id) }}"
                                                            class="btn btn-info btn-sm" data-bs-toggle="tooltip"
                                                            title="Detail Produk">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('produk.edit', $product->id) }}"
                                                            class="btn btn-warning btn-sm" data-bs-toggle="tooltip"
                                                            title="Edit Produk">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('produk.destroy', $product->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk {{ $product->nama_produk }}?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                data-bs-toggle="tooltip" title="Hapus Produk">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Info Jumlah Produk -->
                            <div class="pagination-container mt-3">
                                <div class="pagination-info">
                                    Total: {{ $products->total() }} produk
                                    @if (request('kategori'))
                                        (Kategori: {{ $kategoriAktif->nama_kategori ?? '' }})
                                    @endif
                                </div>

                                @if ($products->hasPages())
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination mb-0">
                                            {{-- Previous Page Link --}}
                                            @if ($products->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link">Sebelumnya</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link"
                                                        href="{{ $products->previousPageUrl() }}{{ request('kategori') ? '&kategori=' . request('kategori') : '' }}{{ request('keyword') ? '&keyword=' . request('keyword') : '' }}"
                                                        rel="prev">Sebelumnya</a>
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
                                                        <a class="page-link"
                                                            href="{{ $url }}{{ request('kategori') ? '&kategori=' . request('kategori') : '' }}{{ request('keyword') ? '&keyword=' . request('keyword') : '' }}">{{ $page }}</a>
                                                    </li>
                                                @endif
                                            @endforeach

                                            {{-- Next Page Link --}}
                                            @if ($products->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link"
                                                        href="{{ $products->nextPageUrl() }}{{ request('kategori') ? '&kategori=' . request('kategori') : '' }}{{ request('keyword') ? '&keyword=' . request('keyword') : '' }}"
                                                        rel="next">Selanjutnya</a>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <span class="page-link">Selanjutnya</span>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                @endif
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-box-open fa-4x"></i>
                                <h4>Belum Ada Produk</h4>
                                <p class="text-muted">Tidak ada data produk yang ditemukan.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Variabel CSS konsisten */
        :root {
            --color-primary: #5E548E;
            --color-secondary: #9F86C0;
            --color-accent: #E0B1CB;
            --color-danger: #E07A5F;
            --color-success: #70C1B3;
            --color-warning: #FFB347;
            --color-info: #5BC0DE;
            --color-light: #F0E6EF;
            --color-white: #ffffff;
            --gradient-bg: linear-gradient(135deg, #F0E6EF 0%, #D891EF 100%);
            --font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            --border-radius-lg: 15px;
            --border-radius-sm: 8px;
        }

        body {
            background: var(--gradient-bg);
            font-family: var(--font-family);
            min-height: 100vh;
        }

        .card {
            border-radius: var(--border-radius-lg);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: none;
            background: var(--color-white);
        }

        .btn-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            border-radius: var(--border-radius-sm);
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(94, 84, 142, 0.3);
        }

        .btn-outline-primary {
            border: 2px solid var(--color-primary);
            color: var(--color-primary);
        }

        .btn-outline-primary:hover {
            background-color: var(--color-primary);
            color: white;
        }

        .btn-warning {
            background-color: var(--color-warning);
            border-color: var(--color-warning);
            color: #000;
        }

        .btn-info {
            background-color: var(--color-info);
            border-color: var(--color-info);
        }

        .btn-danger {
            background-color: var(--color-danger);
            border-color: var(--color-danger);
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 0.875rem;
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .table thead th {
            background-color: var(--color-primary);
            color: white;
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(224, 177, 203, 0.1);
            transform: translateX(5px);
        }

        .table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            border-color: #e9ecef;
        }

        /* Badge Styles */
        .badge-category {
            background-color: var(--color-accent);
            color: #5E548E;
        }

        .badge {
            font-weight: 500;
            letter-spacing: 0.3px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .rounded-pill {
            border-radius: 50px !important;
        }

        /* Section Title */
        .section-title {
            color: var(--color-primary);
            font-weight: 700;
            margin-bottom: 0.5rem;
            border-left: 4px solid var(--color-accent);
            padding-left: 15px;
        }

        /* Product Avatar */
        .product-avatar {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-secondary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .product-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 8px;
            object-fit: cover;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .action-buttons .btn {
            border-radius: 6px;
            transition: all 0.3s ease;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: var(--color-accent);
        }

        .empty-state h4 {
            color: var(--color-primary);
            margin-bottom: 0.5rem;
        }

        /* Alert Styles */
        .alert {
            border-radius: var(--border-radius-sm);
            border: none;
        }

        .alert-success {
            background-color: rgba(112, 193, 179, 0.1);
            border-left: 4px solid var(--color-success);
            color: #0f5132;
        }

        .alert-danger {
            background-color: rgba(224, 122, 95, 0.1);
            border-left: 4px solid var(--color-danger);
            color: #721c24;
        }

        .alert-info {
            background-color: rgba(91, 192, 222, 0.1);
            border-left: 4px solid var(--color-info);
            color: #0c5460;
        }

        /* Search Box */
        .search-box {
            border-radius: var(--border-radius-sm);
            border: 2px solid var(--color-accent);
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .search-box:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 0.2rem rgba(224, 177, 203, 0.25);
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .pagination-info {
            color: #6c757d;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }

        .pagination .page-link {
            color: var(--color-primary);
            border: 1px solid #dee2e6;
            padding: 0.5rem 0.75rem;
            margin: 0 2px;
            border-radius: var(--border-radius-sm);
        }

        .pagination .page-link:hover {
            background-color: var(--color-light);
        }

        /* Filter Buttons */
        .d-flex.flex-wrap.gap-2 .btn {
            margin-bottom: 5px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .pagination-container {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .action-buttons {
                flex-wrap: wrap;
            }

            .table-responsive {
                font-size: 0.9rem;
            }

            .product-avatar {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .d-flex.flex-wrap.gap-2 {
                justify-content: center;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
@endsection
