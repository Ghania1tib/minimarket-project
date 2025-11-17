@extends('layouts.app')

@section('title', 'Edit Promo - ' . $promo->nama_promo)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Promo - {{ $promo->nama_promo }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('promo.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> Terjadi kesalahan input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('promo.update', $promo->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kode_promo">Kode Promo <span class="text-danger">*</span></label>
                                    <input type="text" name="kode_promo" id="kode_promo" class="form-control @error('kode_promo') is-invalid @enderror"
                                           value="{{ old('kode_promo', $promo->kode_promo) }}" required maxlength="50">
                                    @error('kode_promo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_promo">Nama Promo <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_promo" id="nama_promo" class="form-control @error('nama_promo') is-invalid @enderror"
                                           value="{{ old('nama_promo', $promo->nama_promo) }}" required maxlength="255">
                                    @error('nama_promo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Promo</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                      rows="3">{{ old('deskripsi', $promo->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_promo">Jenis Promo <span class="text-danger">*</span></label>
                                    <select name="jenis_promo" id="jenis_promo" class="form-control @error('jenis_promo') is-invalid @enderror" required>
                                        <option value="">Pilih Jenis Promo</option>
                                        <option value="diskon_persentase" {{ old('jenis_promo', $promo->jenis_promo) == 'diskon_persentase' ? 'selected' : '' }}>Diskon Persentase (%)</option>
                                        <option value="diskon_nominal" {{ old('jenis_promo', $promo->jenis_promo) == 'diskon_nominal' ? 'selected' : '' }}>Diskon Nominal (Rp)</option>
                                    </select>
                                    @error('jenis_promo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nilai_promo">Nilai Promo <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" name="nilai_promo" id="nilai_promo" class="form-control @error('nilai_promo') is-invalid @enderror"
                                               value="{{ old('nilai_promo', $promo->nilai_promo) }}" required min="0" step="0.01">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="nilai_satuan">
                                                {{ $promo->jenis_promo == 'diskon_persentase' ? '%' : 'Rp' }}
                                            </span>
                                        </div>
                                        @error('nilai_promo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="minimal_pembelian">Minimal Pembelian</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" name="minimal_pembelian" id="minimal_pembelian" class="form-control @error('minimal_pembelian') is-invalid @enderror"
                                               value="{{ old('minimal_pembelian', $promo->minimal_pembelian) }}" min="0">
                                        @error('minimal_pembelian')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="maksimal_diskon">Maksimal Diskon</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                           