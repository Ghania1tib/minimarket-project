@extends('layouts.app')

@section('title', 'Tambah Promo Baru')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Promo Baru</h3>
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

                    <form action="{{ route('promo.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kode_promo">Kode Promo <span class="text-danger">*</span></label>
                                    <input type="text" name="kode_promo" id="kode_promo" class="form-control @error('kode_promo') is-invalid @enderror"
                                           value="{{ old('kode_promo') }}" required maxlength="50" placeholder="CONTOH123">
                                    @error('kode_promo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Kode unik untuk promo (akan diubah menjadi huruf besar)</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_promo">Nama Promo <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_promo" id="nama_promo" class="form-control @error('nama_promo') is-invalid @enderror"
                                           value="{{ old('nama_promo') }}" required maxlength="255" placeholder="Nama promo">
                                    @error('nama_promo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Promo</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                      rows="3" placeholder="Deskripsi detail tentang promo...">{{ old('deskripsi') }}</textarea>
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
                                        <option value="diskon_persentase" {{ old('jenis_promo') == 'diskon_persentase' ? 'selected' : '' }}>Diskon Persentase (%)</option>
                                        <option value="diskon_nominal" {{ old('jenis_promo') == 'diskon_nominal' ? 'selected' : '' }}>Diskon Nominal (Rp)</option>
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
                                               value="{{ old('nilai_promo') }}" required min="0" step="0.01" placeholder="0">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="nilai_satuan">Rp</span>
                                        </div>
                                        @error('nilai_promo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="form-text text-muted" id="nilai_info">Masukkan nilai diskon dalam Rupiah</small>
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
                                               value="{{ old('minimal_pembelian', 0) }}" min="0" placeholder="0">
                                        @error('minimal_pembelian')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="form-text text-muted">Minimal total pembelian untuk menggunakan promo</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="maksimal_diskon">Maksimal Diskon</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" name="maksimal_diskon" id="maksimal_diskon" class="form-control @error('maksimal_diskon') is-invalid @enderror"
                                               value="{{ old('maksimal_diskon') }}" min="0" placeholder="0">
                                        @error('maksimal_diskon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="form-text text-muted">Maksimal nilai diskon yang diberikan (isi 0 jika tidak ada batas)</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                           value="{{ old('tanggal_mulai') }}" required>
                                    @error('tanggal_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_berakhir">Tanggal Berakhir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_berakhir" id="tanggal_berakhir" class="form-control @error('tanggal_berakhir') is-invalid @enderror"
                                           value="{{ old('tanggal_berakhir') }}" required>
                                    @error('tanggal_berakhir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kuota">Kuota Promo</label>
                                    <input type="number" name="kuota" id="kuota" class="form-control @error('kuota') is-invalid @enderror"
                                           value="{{ old('kuota') }}" min="1" placeholder="Kosongkan untuk unlimited">
                                    @error('kuota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Jumlah maksimal penggunaan promo (kosongkan untuk unlimited)</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="">Pilih Status</option>
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Simpan Promo
                            </button>
                            <a href="{{ route('promo.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenisPromoSelect = document.getElementById('jenis_promo');
        const nilaiSatuanSpan = document.getElementById('nilai_satuan');
        const nilaiInfoSmall = document.getElementById('nilai_info');
        const kodePromoInput = document.getElementById('kode_promo');

        // Auto uppercase untuk kode promo
        kodePromoInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });

        // Update tampilan berdasarkan jenis promo
        function updateJenisPromoDisplay() {
            const jenisPromo = jenisPromoSelect.value;

            if (jenisPromo === 'diskon_persentase') {
                nilaiSatuanSpan.textContent = '%';
                nilaiInfoSmall.textContent = 'Masukkan nilai diskon dalam persentase (contoh: 50 untuk 50%)';
            } else if (jenisPromo === 'diskon_nominal') {
                nilaiSatuanSpan.textContent = 'Rp';
                nilaiInfoSmall.textContent = 'Masukkan nilai diskon dalam Rupiah';
            } else {
                nilaiSatuanSpan.textContent = 'Rp';
                nilaiInfoSmall.textContent = 'Pilih jenis promo terlebih dahulu';
            }
        }

        // Event listener untuk perubahan jenis promo
        jenisPromoSelect.addEventListener('change', updateJenisPromoDisplay);

        // Inisialisasi tampilan awal
        updateJenisPromoDisplay();

        // Set tanggal minimal ke hari ini
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('tanggal_mulai').min = today;
        document.getElementById('tanggal_berakhir').min = today;
    });
</script>
@endpush
