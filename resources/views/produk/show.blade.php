@extends('layouts.app')

@section('title', 'Detail Produk - Minimarket')
@section('content')
    <div class="content-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="text-theme-primary">
                <i class="fas fa-eye me-2"></i>Detail Produk
            </h1>
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
        <hr class="mt-0 mb-4">

        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0"><i class="fas fa-eye me-2"></i>Detail Produk</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @if($product->gambar_url)
                            <img src="{{ asset('storage/' . $product->gambar_url) }}"
                                 class="img-fluid rounded"
                                 alt="{{ $product->nama_produk }}"
                                 style="max-height: 300px; object-fit: cover;">
                        @else
                            <div class="bg-theme-light d-flex align-items-center justify-content-center rounded"
                                 style="height: 300px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h3>{{ $product->nama_produk }}</h3>
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Kategori</th>
                                <td>{{ $product->category->nama_kategori ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Barcode</th>
                                <td>{{ $product->barcode ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Harga Beli</th>
                                <td class="text-danger">{{ 'Rp ' . number_format($product->harga_beli, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Harga Jual</th>
                                <td class="text-success">{{ 'Rp ' . number_format($product->harga_jual, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td>
                                    <span class="badge {{ $product->stok > 0 ? 'bg-success-custom' : 'bg-danger' }}">
                                        {{ $product->stok }}
                                    </span>
                                    @if($product->stok <= $product->stok_kritis)
                                        <span class="badge bg-warning text-dark">Stok Kritis!</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Stok Kritis</th>
                                <td>{{ $product->stok_kritis }}</td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $product->deskripsi ?? '-' }}</td>
                            </tr>
                        </table>

                        <div class="d-flex gap-2">
                            <a href="{{ route('produk.edit', $product->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <form action="{{ route('produk.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus produk ini?')">
                                    <i class="fas fa-trash me-2"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
