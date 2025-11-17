@extends('layouts.pelanggan')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja
                    </h4>
                    <span class="badge bg-primary">{{ $cartCount ?? 0 }} Items</span>
                </div>
                <div class="card-body">
                    @if($cartItems && $cartItems->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50"></th>
                                        <th>Produk</th>
                                        <th width="120" class="text-center">Harga</th>
                                        <th width="150" class="text-center">Kuantitas</th>
                                        <th width="120" class="text-end">Subtotal</th>
                                        <th width="80" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach($cartItems as $item)
                                    @php
                                        $subtotal = $item->harga * $item->qty;
                                        $total += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>
                                            @if($item->product->gambar ?? false)
                                                <img src="{{ asset('storage/' . $item->product->gambar) }}"
                                                     alt="{{ $item->product->nama_produk }}"
                                                     class="rounded" width="40" height="40" style="object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ $item->product->nama_produk ?? $item->nama_produk }}</h6>
                                            <small class="text-muted">Stok: {{ $item->product->stok ?? 0 }}</small>
                                        </td>
                                        <td class="text-center">
                                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <div class="input-group input-group-sm" style="width: 120px;">
                                                <button class="btn btn-outline-secondary" type="button"
                                                        onclick="updateQty({{ $item->id }}, -1)">-</button>
                                                <input type="number" class="form-control text-center"
                                                       value="{{ $item->qty }}" min="1" max="{{ $item->product->stok ?? 99 }}"
                                                       id="qty-{{ $item->id }}">
                                                <button class="btn btn-outline-secondary" type="button"
                                                        onclick="updateQty({{ $item->id }}, 1)">+</button>
                                            </div>
                                        </td>
                                        <td class="text-end fw-bold">
                                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('pelanggan.keranjang.hapus', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                                        onclick="return confirm('Hapus item dari keranjang?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="4" class="text-end fw-bold">Total</td>
                                        <td class="text-end fw-bold text-success">
                                            Rp {{ number_format($total, 0, ',', '.') }}
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('home') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Lanjutkan Belanja
                            </a>
                            <div class="d-flex gap-2">
                                <form action="{{ route('pelanggan.keranjang.kosongkan') }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger"
                                            onclick="return confirm('Kosongkan seluruh keranjang?')">
                                        <i class="fas fa-trash me-2"></i>Kosongkan Keranjang
                                    </button>
                                </form>
                                <a href="{{ route('pelanggan.checkout') }}" class="btn btn-primary">
                                    <i class="fas fa-credit-card me-2"></i>Checkout
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="empty-state text-center py-5">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">Keranjang Kosong</h4>
                            <p class="text-muted mb-4">Belum ada produk dalam keranjang belanja Anda.</p>
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateQty(itemId, change) {
    const input = document.getElementById('qty-' + itemId);
    let newQty = parseInt(input.value) + change;
    const maxStock = parseInt(input.max);

    if (newQty < 1) newQty = 1;
    if (newQty > maxStock) newQty = maxStock;

    input.value = newQty;

    // Kirim update ke server
    fetch(`/pelanggan/keranjang/${itemId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ qty: newQty })
    }).then(response => {
        if (response.ok) {
            location.reload(); // Refresh untuk update total
        }
    });
}
</script>
@endsection
