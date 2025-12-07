@if(isset($product) && $product)
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
@endif
