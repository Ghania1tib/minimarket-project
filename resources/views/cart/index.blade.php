@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('navbar')
    @include('layouts.partials.header')
@endsection

@section('content')
    <div class="content-container p-4">

        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h2 class="mb-0 text-theme-primary fw-bold"><i class="fas fa-shopping-cart me-2"></i> Keranjang Belanja</h2>
            @if(isset($cartItems) && !$cartItems->isEmpty())
                <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin mengosongkan keranjang?')">
                        <i class="fas fa-trash me-1"></i> Kosongkan Keranjang
                    </button>
                </form>
            @endif
        </div>

        @if(isset($cartItems) && $cartItems->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-5x text-secondary mb-3"></i>
                <h3 class="text-muted mt-3">Keranjang belanja Anda kosong</h3>
                <p class="text-muted">Yuk, cari kebutuhan harianmu sekarang juga!</p>
                <a href="{{ route('home') }}" class="btn btn-primary-custom btn-lg mt-3">
                    <i class="fas fa-shopping-bag me-2"></i> Mulai Belanja
                </a>
            </div>
        @else
            <div class="row g-4">
                <div class="col-lg-8">
                    @foreach($cartItems as $item)
                        <div class="row cart-item align-items-center mb-3 p-3 bg-white rounded-3 shadow-sm" style="border: 1px solid var(--color-light);">
                            <div class="col-md-2">
                                {{-- PERBAIKAN: Gunakan asset('storage/') seperti di halaman CRUD --}}
                                @if($item->product->gambar_url)
                                    <img src="{{ asset('storage/' . $item->product->gambar_url) }}"
                                         alt="{{ $item->product->nama_produk }}"
                                         class="img-fluid rounded-3"
                                         style="width: 80px; height: 80px; object-fit: cover; border: 2px solid var(--color-accent);"
                                         onerror="this.src='data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'80\' height=\'80\' viewBox=\'0 0 80 80\'%3E%3Crect width=\'80\' height=\'80\' fill=\'%23f8f9fa\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'Arial, sans-serif\' font-size=\'10\' fill=\'%236c757d\'%3E{{ urlencode($item->product->nama_produk) }}%3C/text%3E%3C/svg%3E'">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded-3"
                                         style="width: 80px; height: 80px; border: 2px solid var(--color-accent);">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <h6 class="fw-bold mb-1 text-theme-primary">{{ $item->product->nama_produk }}</h6>
                                <small class="text-muted">
                                    {{ $item->product->category->nama_kategori ?? 'Umum' }}
                                </small>
                            </div>
                            <div class="col-md-2">
                                <p class="fw-bold text-success mb-0">Rp {{ number_format($item->product->harga_jual, 0, ',', '.') }}</p>
                            </div>
                            <div class="col-md-2">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex align-items-center">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="jumlah" value="{{ $item->quantity }}"
                                           min="1" max="{{ $item->product->stok ?? 100 }}"
                                           class="form-control form-control-sm text-center quantity-input">
                                    <button type="submit" class="btn btn-sm btn-outline-primary-custom ms-2" title="Update" style="border-color: var(--color-secondary); color: var(--color-secondary);">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </form>
                                <small class="text-muted d-block mt-1">Stok: {{ $item->product->stok ?? '?' }}</small>
                            </div>
                            <div class="col-md-2 text-end">
                                <p class="fw-bold fs-6 mb-1" style="color: var(--color-danger);">Rp {{ number_format($item->quantity * $item->product->harga_jual, 0, ',', '.') }}</p>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus produk dari keranjang?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-lg" style="background: var(--color-primary); color: white;">
                        <div class="card-body">
                            <h5 class="card-title mb-4 border-bottom pb-2"><i class="fas fa-receipt me-2"></i> Ringkasan Belanja</h5>

                            <div class="d-flex justify-content-between mb-3">
                                <span>Subtotal Item:</span>
                                <span class="fw-bold">Rp {{ number_format($total ?? 0, 0, ',', '.') }}</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span>Biaya Pengiriman:</span>
                                <span class="fw-bold">Rp 15.000</span>
                            </div>

                            <hr style="border-color: rgba(255,255,255,0.3);">

                            <div class="d-flex justify-content-between mb-4">
                                <span class="fw-bold fs-5">Total Bayar:</span>
                                <span class="fw-bold fs-5" style="color: var(--color-danger); background-color: white; padding: 3px 8px; border-radius: 5px;">Rp {{ number_format(($total ?? 0) + 15000, 0, ',', '.') }}</span>
                            </div>

                            <a href="{{ route('checkout.index') }}" class="btn btn-accent w-100 btn-lg fw-bold">
                                <i class="fas fa-lock me-2"></i> Lanjut ke Pembayaran
                            </a>

                            <a href="{{ route('home') }}" class="btn btn-outline-light w-100 mt-2">
                                <i class="fas fa-arrow-left me-2"></i> Lanjutkan Belanja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        function updateCartCount() {
             fetch('{{ route("cart.count") }}')
                .then(response => response.json())
                .then(data => {
                    const cartBadge = document.getElementById('cart-count-badge');
                    if (cartBadge) {
                        cartBadge.textContent = data.count;
                        cartBadge.style.display = data.count > 0 ? 'flex' : 'none';
                    }
                });
        }
        document.addEventListener('DOMContentLoaded', updateCartCount);
    </script>
@endpush
