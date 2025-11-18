@extends('layouts.pelanggan')

@section('content')

<style>
    .product-page-container {
        max-width: 1100px;
        margin: 30px auto;
        padding: 0 15px;
    }

    .product-page-title {
        font-size: 28px;
        font-weight: 600;
        color: #333;
        margin-bottom: 25px;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 10px;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* 4 produk per baris */
        gap: 20px;
    }

    .product-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: box-shadow 0.3s ease;
    }

    .product-card:hover {
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    .product-card img {
        width: 100%;
        height: 200px; /* Tinggi gambar seragam */
        object-fit: cover;
    }

    .product-info {
        padding: 15px;
    }
    
    .product-info .nama-produk {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        /* Batasi 2 baris */
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 48px; /* Tinggi minimum untuk 2 baris */
    }

    .product-info .harga-produk {
        font-size: 18px;
        font-weight: bold;
        color: #e53935; /* Warna merah */
        margin-bottom: 15px;
    }

    .btn-keranjang {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: white;
        text-align: center;
        text-decoration: none;
        border: none;
        border-radius: 5px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-keranjang:hover {
        background-color: #0056b3;
    }

    .no-produk {
        padding: 40px;
        text-align: center;
        font-size: 18px;
        color: #888;
        /* Pastikan pesan ini mencakup semua 4 kolom */
        grid-column: 1 / -1; 
    }

    /* Responsive untuk HP (2 kolom) */
    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<div class="product-page-container">
    {{-- Ini adalah judul untuk halaman "Semua Produk" --}}
    <h1 class="product-page-title">
        Menampilkan Semua Produk
    </h1>

    <div class="product-grid">
        
        {{-- Loop semua produk yang dikirim oleh ProductController@index --}}
        @forelse ($products as $product)
            <div class="product-card">
                {{-- Pastikan nama kolom 'gambar_url' sudah benar --}}
                <img src="{{ $product->gambar_url }}" alt="{{ $product->nama_produk }}">
                <div class="product-info">
                    
                    {{-- Pastikan nama kolom 'nama_produk' sudah benar --}}
                    <div class="nama-produk">{{ $product->nama_produk }}</div>
                    
                    {{-- Pastikan nama kolom 'harga_jual' sudah benar --}}
                    <div class="harga-produk">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</div>
                    
                    <form action="#" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn-keranjang">+ Tambah Keranjang</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="no-produk">
                <p>Belum ada produk yang dijual.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection