@extends('layouts.app')

@section('title', 'Manajemen Diskon - Minimarket')

@push('styles')
    <style>
        /* CSS Khusus Manajemen Diskon */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        .card-diskon {
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }
        .form-header {
            background-color: var(--color-primary);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 15px;
        }
        .btn-create-diskon {
            background-color: var(--color-danger); /* Soft Coral/Aksen */
            border-color: var(--color-danger);
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-create-diskon:hover {
            background-color: #c46452;
            border-color: #c46452;
        }
        .diskon-status-active {
            border-left: 4px solid var(--color-success);
        }
        .diskon-status-soon {
            border-left: 4px solid var(--color-secondary);
        }
        .diskon-status-expired {
            border-left: 4px solid #aaa;
        }
        .table thead th {
            background-color: var(--color-light);
            color: var(--color-primary);
        }
        .badge-success-theme {
            background-color: var(--color-success);
            color: white;
        }
        .badge-warning-theme {
            background-color: var(--color-secondary);
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="main-container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-tags me-3" style="color: var(--color-danger);"></i> Manajemen Diskon & Promo</h1>
            {{-- Menggunakan route yang sudah dikonfirmasi --}}
            <a href="{{ route('dashboard.staff') }}" class="btn btn-primary-custom"><i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard</a>
        </div>

        <div class="row g-4">

            <div class="col-lg-5">
                <div class="card card-diskon shadow-lg">
                    <div class="form-header text-center">
                        <h5 class="mb-0"><i class="fas fa-magic me-2"></i> Buat Promo Baru</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('promo.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-bold text-theme-primary">Nama Promo</label>
                                <input type="text" class="form-control" name="nama_promo" placeholder="Contoh: Flash Sale Minyak Goreng">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-theme-primary">Jenis Diskon</label>
                                <select class="form-select" name="jenis_diskon">
                                    <option>Diskon Persen (%)</option>
                                    <option>Diskon Nominal (Rp)</option>
                                    <option>Beli X Gratis Y</option>
                                </select>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-theme-primary">Nilai Diskon</label>
                                    <input type="text" class="form-control" name="nilai_diskon" placeholder="Contoh: 15% atau 5000">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-theme-primary">Target Produk</label>
                                    <select class="form-select" name="target_produk">
                                        <option>Semua Produk</option>
                                        <option>Kategori Tertentu (Makanan)</option>
                                        <option>Produk Spesifik (Susu UHT)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-theme-primary">Tanggal Mulai</label>
                                    <input type="datetime-local" class="form-control" name="tanggal_mulai">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-theme-primary">Tanggal Berakhir</label>
                                    <input type="datetime-local" class="form-control" name="tanggal_berakhir">
                                </div>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="flashSaleCheck" name="is_flash_sale">
                                <label class="form-check-label" for="flashSaleCheck">Aktifkan sebagai Flash Sale (Tampil di Beranda)</label>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-create-diskon btn-lg"><i class="fas fa-paper-plane me-2"></i> Simpan & Aktifkan Promo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card card-diskon shadow-lg">
                    <div class="card-header bg-theme-light">
                        <h5 class="mb-0 text-theme-primary">Status Promo Saat Ini</h5>
                    </div>
                    <div class="card-body p-3">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Promo</th>
                                    <th>Tipe</th>
                                    <th>Berlaku Hingga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="diskon-status-active">
                                    <td>Diskon Member Baru</td>
                                    <td>10%</td>
                                    <td>31 Des 2025</td>
                                    <td><span class="badge badge-success-theme">AKTIF</span></td>
                                    <td><button class="btn btn-sm btn-outline-primary-custom" style="border-color: var(--color-primary); color: var(--color-primary);"><i class="fas fa-edit"></i></button></td>
                                </tr>
                                <tr class="diskon-status-soon">
                                    <td>Flash Sale Daging</td>
                                    <td>Rp 10.000</td>
                                    <td>Besok, 10:00 WIB</td>
                                    <td><span class="badge badge-warning-theme">MENDATANG</span></td>
                                    <td><button class="btn btn-sm btn-outline-primary-custom" style="border-color: var(--color-primary); color: var(--color-primary);"><i class="fas fa-edit"></i></button></td>
                                </tr>
                                <tr class="diskon-status-expired">
                                    <td>Promo Natal</td>
                                    <td>20%</td>
                                    <td>25 Des 2024</td>
                                    <td><span class="badge bg-secondary">EXPIRED</span></td>
                                    <td><button class="btn btn-sm btn-outline-secondary" disabled><i class="fas fa-history"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
