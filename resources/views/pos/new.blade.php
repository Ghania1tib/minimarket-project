@extends('layouts.app')

@section('title', 'POS - Transaksi Baru')

@push('styles')
    <style>
        /* CSS Khusus POS (Minimal, menggunakan variabel global) */
        body { padding-top: 0 !important; background: var(--color-light) !important; }
        .pos-container { margin: 0 auto; max-width: 1400px; padding: 10px; }

        .pos-header {
            background-color: var(--color-primary);
            color: white;
            padding: 15px 25px;
            border-radius: var(--border-radius-sm);
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .total-box {
            background-color: var(--color-primary);
            color: white;
            padding: 25px 20px;
            border-radius: var(--border-radius-sm);
            text-align: right;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .total-box h1 {
            font-size: 3.5rem;
            font-weight: 900;
            margin: 0;
            color: var(--color-accent); /* Aksen warna pink nude pada total */
        }
        .total-box small {
            font-size: 0.9rem;
            opacity: 0.9;
            letter-spacing: 1px;
            display: block;
        }

        .action-button-group .btn {
            background-color: white;
            color: var(--color-primary);
            border: 1px solid var(--color-accent);
            font-weight: 500;
            margin-bottom: 10px;
            border-radius: 8px;
            padding: 12px;
            text-align: left;
        }
        .action-button-group .btn:hover {
            background-color: var(--color-light);
            border-color: var(--color-secondary);
            color: var(--color-primary);
        }
    </style>
@endpush

@section('navbar')
    {{-- Tidak ada navbar untuk mode POS --}}
@endsection

@section('content')
    <div class="pos-container">

        <div class="pos-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-barcode me-3"></i> POINT OF SALE (POS) - Toko Saudara 2</h4>
            {{-- Kembali ke dashboard staff --}}
            <a href="{{ route('dashboard.staff') }}" class="btn btn-sm btn-outline-light shadow-sm"><i class="fas fa-arrow-left me-2"></i> Kembali</a>
        </div>

        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-theme-accent p-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search text-theme-primary"></i></span>
                            <input type="text" class="form-control form-control-lg" placeholder="Scan Barcode atau Cari Produk..." autofocus>
                            <button class="btn btn-primary-custom"><i class="fas fa-plus"></i> Cari</button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="bg-theme-light">
                                    <tr>
                                        <th style="width: 50px;" class="text-theme-primary">#</th>
                                        <th class="text-theme-primary">Nama Produk</th>
                                        <th class="text-end text-theme-primary">Harga</th>
                                        <th style="width: 100px;" class="text-theme-primary">Qty</th>
                                        <th class="text-end text-theme-primary">Subtotal</th>
                                        <th style="width: 80px;" class="text-theme-primary">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Placeholder Item --}}
                                    <tr>
                                        <td>1</td>
                                        <td>Minyak Goreng Sawit 2L</td>
                                        <td class="text-end">Rp 30.000</td>
                                        <td><input type="number" value="1" min="1" class="form-control form-control-sm text-center"></td>
                                        <td class="text-end fw-bold" style="color: var(--color-danger);">Rp 30.000</td>
                                        <td><button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></td>
                                    </tr>
                                    {{-- End Placeholder --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">

                <div class="d-grid action-button-group mb-3">
                    <a href="{{ route('member.index') }}" class="btn shadow-sm d-block">
                        <i class="fas fa-user-plus me-2"></i> Tambah Member
                    </a>
                    <a href="{{ route('promo.index') }}" class="btn shadow-sm d-block">
                        <i class="fas fa-tags me-2"></i> Tambah Diskon
                    </a>
                </div>

                <div class="total-box">
                    <small>TOTAL BELANJA</small>
                    <h1>Rp 157.000</h1>
                </div>

                <div class="card shadow-sm p-3">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-theme-primary">Pembayaran</label>
                        <select class="form-select">
                            <option>Tunai</option>
                            <option>QRIS/E-Wallet</option>
                            <option>Debit/Kredit</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-theme-primary">Nominal Bayar</label>
                        <input type="number" class="form-control form-control-lg" placeholder="Rp ...">
                    </div>
                    <button class="btn btn-success-custom btn-lg d-block w-100"><i class="fas fa-check-circle me-2"></i> SELESAI TRANSAKSI</button>
                </div>
            </div>
        </div>
    </div>
@endsection
