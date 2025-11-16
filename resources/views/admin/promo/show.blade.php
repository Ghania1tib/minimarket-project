@extends('layouts.admin')

@section('title', 'Detail Promo - ' . $promo->nama_promo)

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Promo</h1>
        <div>
            <a href="{{ route('promo.edit', $promo->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit Promo
            </a>
            <a href="{{ route('promo.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Promo</h6>
                    @if($promo->is_aktif)
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-danger">Nonaktif</span>
                    @endif
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Kode Promo</th>
                            <td><strong>{{ $promo->kode_promo }}</strong></td>
                        </tr>
                        <tr>
                            <th>Nama Promo</th>
                            <td>{{ $promo->nama_promo }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $promo->deskripsi ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Promo</th>
                            <td>
                                @if($promo->jenis_promo == 'diskon_persentase')
                                    <span class="badge badge-info">Diskon Persentase</span>
                                @else
                                    <span class="badge badge-success">Diskon Nominal</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Nilai Promo</th>
                            <td><strong>{{ $promo->formatted_nilai }}</strong></td>
                        </tr>
                        <tr>
                            <th>Periode Promo</th>
                            <td>
                                {{ $promo->tanggal_mulai->format('d F Y') }} -
                                {{ $promo->tanggal_berakhir->format('d F Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th>Kuota Penggunaan</th>
                            <td>
                                @if($promo->kuota)
                                    {{ $promo->digunakan }} / {{ $promo->kuota }}
                                    ({{ number_format(($promo->digunakan / $promo->kuota) * 100, 1) }}%)
                                @else
                                    <span class="text-muted">Unlimited</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Minimal Pembelian</th>
                            <td>Rp {{ number_format($promo->minimal_pembelian, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Maksimal Diskon</th>
                            <td>
                                @if($promo->maksimal_diskon)
                                    Rp {{ number_format($promo->maksimal_diskon, 0, ',', '.') }}
                                @else
                                    <span class="text-muted">Tidak Terbatas</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($promo->is_aktif)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Dibuat Pada</th>
                            <td>{{ $promo->created_at->format('d F Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Diupdate Pada</th>
                            <td>{{ $promo->updated_at->format('d F Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik</h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <div class="h1 font-weight-bold text-primary">{{ $promo->digunakan }}</div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Penggunaan
                        </div>
                    </div>

                    @if($promo->kuota)
                    <div class="mb-3">
                        <div class="progress">
                            <div class="progress-bar bg-{{ $promo->digunakan < $promo->kuota ? 'success' : 'danger' }}"
                                 role="progressbar"
                                 style="width: {{ min(100, ($promo->digunakan / $promo->kuota) * 100) }}%"
                                 aria-valuenow="{{ ($promo->digunakan / $promo->kuota) * 100 }}"
                                 aria-valuemin="0"
                                 aria-valuemax="100">
                            </div>
                        </div>
                        <small class="text-muted">
                            {{ number_format(($promo->digunakan / $promo->kuota) * 100, 1) }}% kuota terpakai
                        </small>
                    </div>
                    @endif

                    <div class="mt-4">
                        @if($promo->is_aktif)
                            <span class="badge badge-success p-2">Promo Sedang Berjalan</span>
                        @else
                            <span class="badge badge-danger p-2">Promo Tidak Aktif</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('promo.edit', $promo->id) }}" class="btn btn-warning btn-block">
                            <i class="fas fa-edit"></i> Edit Promo
                        </a>
                        <form action="{{ route('promo.destroy', $promo->id) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block"
                                    onclick="return confirm('Yakin ingin menghapus promo ini?')">
                                <i class="fas fa-trash"></i> Hapus Promo
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
