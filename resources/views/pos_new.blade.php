@extends('layouts.app')

@section('title', 'POS - Transaksi Baru')

@push('styles')
    <style>
        /* CSS Khusus POS */
        .pos-container {
            max-width: 1300px;
            margin: 20px auto;
            padding: 10px;
        }

        .pos-header {
            background-color: var(--color-primary);
            color: white;
            padding: 15px 25px;
            border-radius: 8px 8px 0 0;
            margin-bottom: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .btn-kembali {
            background-color: var(--color-accent);
            color: var(--color-primary);
            font-weight: bold;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-kembali:hover {
            background-color: var(--color-secondary);
            color: white;
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
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: background-color 0.2s, border-color 0.2s;
        }
        .action-button-group .btn:hover {
            background-color: var(--color-light);
            border-color: var(--color-secondary);
            color: var(--color-primary);
        }

        .total-box {
            background-color: var(--color-primary);
            color: white;
            padding: 25px 20px;
            border-radius: 8px;
            text-align: right;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .total-box h1 {
            font-size: 3.2rem;
            font-weight: 900;
            margin: 0;
        }
        .total-box small {
            font-size: 0.9rem;
            opacity: 0.9;
            letter-spacing: 1px;
            display: block;
        }

        .payment-card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }
        .btn-finish {
            background-color: var(--color-success);
            border-color: var(--color-success);
            font-size: 1.2rem;
            font-weight: bold;
            padding: 10px 0;
        }
        .btn-finish:hover {
            background-color: #5ea094;
            border-color: #5ea094;
        }

        /* Override body padding for full screen POS view */
        body { padding-top: 0 !important; }
        .pos-container { margin-top: 0; }
    </style>
@endpush

@section('navbar')
    {{-- POS tidak menggunakan navbar publik --}}
@endsection

@section('content')
    <div class="pos-container">

        <div class="pos-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-barcode me-3"></i> POINT OF SALE (POS)</h4>
            {{-- Menggunakan route yang sudah dikonfirmasi --}}
            <a href="{{ route('dashboard.staff') }}" class="btn btn-sm btn-kembali shadow-sm"><i class="fas fa-arrow-left me-2"></i> Kembali</a>
        </div>

        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card card-list shadow-lg">
                    <div class="card-header bg-theme-light p-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search text-theme-primary"></i></span>
                            <input type="text" class="form-control form-control-lg" placeholder="Scan Barcode atau Cari Produk..." autofocus>
                            <button class="btn btn-primary-custom"><i class="fas fa-plus"></i> Tambah</button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-list">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="bg-theme-accent">
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
                                    <tr>
                                        <td>1</td>
                                        <td>Minyak Goreng Sania 2L</td>
                                        <td class="text-end">Rp 32.000</td>
                                        <td><input type="number" value="1" min="1" class="form-control form-control-sm text-center"></td>
                                        <td class="text-end fw-bold">Rp 32.000</td>
                                        <td><button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">

                <div class="d-grid action-button-group mb-3">
                    {{-- Menggunakan route yang sudah dikonfirmasi, meskipun 'member.management' tidak ada di web.php, kami mengasumsikan ada route 'member.index' dari Route::resource('member') --}}
                    <a href="{{ route('member.index') }}" class="btn shadow-sm d-block">
                        <i class="fas fa-user-plus me-2"></i> Tambah Member
                    </a>

                    {{-- 'diskon.management' diasumsikan sebagai route manajemen promo/diskon --}}
                    <a href="{{ route('promo.index') }}" class="btn shadow-sm d-block">
                        <i class="fas fa-tags me-2"></i> Tambah Diskon
                    </a>
                </div>

                <div class="total-box">
                    <small>TOTAL BELANJA</small>
                    <h1>Rp 157.000</h1>
                </div>

                <div class="card payment-card shadow-sm">
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
                    {{-- Menggunakan route yang sudah dikonfirmasi --}}
                    <button class="btn btn-finish d-block w-100"><i class="fas fa-check-circle me-2"></i> SELESAI TRANSAKSI</button>
                </div>
            </div>
        </div>
    </div>
@endsection
