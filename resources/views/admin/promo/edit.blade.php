@extends('layouts.admin')

@section('title', 'Edit Promo - ' . $promo->nama_promo)

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Promo</h1>
        <a href="{{ route('promo.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Promo</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('promo.update', $promo->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kode_promo">Kode Promo *</label>
                            <input type="text" class="form-control @error('kode_promo') is-invalid @enderror"
                                   id="kode_promo" name="kode_promo" value="{{ old('kode_promo', $promo->kode_promo) }}" required>
                            @error('kode_promo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_promo">Nama Promo *</label>
                            <input type="text" class="form-control @error('nama_promo') is-invalid @enderror"
                                   id="nama_promo" name="nama_promo" value="{{ old('nama_promo', $promo->nama_promo) }}" required>
                            @error('nama_promo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi Promo</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                              id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $promo->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_promo">Jenis Promo *</label>
                            <select class="form-control @error('jenis_promo') is-invalid @enderror"
                                    id="jenis_promo" name="jenis_promo" required>
                                <option value="diskon_persentase" {{ old('jenis_promo', $promo->jenis_promo) == 'diskon_persentase' ? 'selected' : '' }}>
                                    Diskon Persentase
                                </option>
                                <option value="diskon_nominal" {{ old('jenis_promo', $promo->jenis_promo) == 'diskon_nominal' ? 'selected' : '' }}>
                                    Diskon Nominal
                                </option>
                            </select>
                            @error('jenis_promo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nilai_promo">Nilai Promo *</label>
                            <input type="number" step="0.01" class="form-control @error('nilai_promo') is-invalid @enderror"
                                   id="nilai_promo" name="nilai_promo" value="{{ old('nilai_promo', $promo->nilai_promo) }}" required>
                            @error('nilai_promo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai *</label>
                            <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                   id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $promo->tanggal_mulai->format('Y-m-d')) }}" required>
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_berakhir">Tanggal Berakhir *</label>
                            <input type="date" class="form-control @error('tanggal_berakhir') is-invalid @enderror"
                                   id="tanggal_berakhir" name="tanggal_berakhir" value="{{ old('tanggal_berakhir', $promo->tanggal_berakhir->format('Y-m-d')) }}" required>
                            @error('tanggal_berakhir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kuota">Kuota Penggunaan</label>
                            <input type="number" class="form-control @error('kuota') is-invalid @enderror"
                                   id="kuota" name="kuota" value="{{ old('kuota', $promo->kuota) }}" placeholder="Kosongkan untuk unlimited">
                            @error('kuota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="minimal_pembelian">Minimal Pembelian (Rp)</label>
                            <input type="number" class="form-control @error('minimal_pembelian') is-invalid @enderror"
                                   id="minimal_pembelian" name="minimal_pembelian" value="{{ old('minimal_pembelian', $promo->minimal_pembelian) }}">
                            @error('minimal_pembelian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="maksimal_diskon">Maksimal Diskon (Rp)</label>
                            <input type="number" class="form-control @error('maksimal_diskon') is-invalid @enderror"
                                   id="maksimal_diskon" name="maksimal_diskon" value="{{ old('maksimal_diskon', $promo->maksimal_diskon) }}">
                            @error('maksimal_diskon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1"
                               {{ old('status', $promo->status) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">
                            Aktifkan Promo
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Promo</button>
                <a href="{{ route('promo.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
