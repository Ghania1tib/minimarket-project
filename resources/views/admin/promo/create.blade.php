<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Promo - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #667eea;
            --primary-pink: #764ba2;
            --lilac: #a78bfa;
            --light-lilac: #c4b5fd;
            --soft-pink: #f0abfc;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #a78bfa 0%, #f0abfc 100%);
            --gradient-light: linear-gradient(135deg, #c4b5fd 0%, #f0abfc 100%);
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px 0;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.1);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .card-header {
            background: var(--gradient-primary);
            color: white;
            border-radius: 20px 20px 0 0 !important;
            border: none;
            padding: 2rem;
        }

        .form-control, .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--lilac);
            box-shadow: 0 0 0 3px rgba(167, 139, 250, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-pink);
            margin-bottom: 8px;
        }

        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            border-radius: 15px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--gradient-secondary);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: var(--gradient-light);
            border: none;
            border-radius: 15px;
            color: var(--primary-pink);
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: var(--gradient-secondary);
            color: white;
            transform: translateY(-2px);
        }

        .input-group-text {
            background: var(--gradient-light);
            border: 2px solid #e2e8f0;
            border-right: none;
            color: var(--primary-pink);
            font-weight: 600;
        }

        .info-text {
            color: var(--primary-blue);
            font-size: 0.875rem;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="mb-2"><i class="fas fa-plus-circle me-2"></i>Tambah Promo Baru</h3>
                        <p class="mb-0 opacity-75">Buat promo menarik untuk meningkatkan penjualan</p>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('promo.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="nama_promo" class="form-label">Nama Promo *</label>
                                    <input type="text" class="form-control @error('nama_promo') is-invalid @enderror"
                                           id="nama_promo" name="nama_promo" value="{{ old('nama_promo') }}"
                                           placeholder="Masukkan nama promo" required>
                                    @error('nama_promo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="info-text">
                                        <i class="fas fa-lightbulb me-1"></i>Buat nama yang menarik dan mudah diingat
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="kode_promo" class="form-label">Kode Promo *</label>
                                    <input type="text" class="form-control @error('kode_promo') is-invalid @enderror"
                                           id="kode_promo" name="kode_promo" value="{{ old('kode_promo') }}"
                                           placeholder="Contoh: DISKON50" required>
                                    @error('kode_promo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="info-text">
                                        <i class="fas fa-tag me-1"></i>Kode unik yang akan digunakan pelanggan
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <label for="diskon" class="form-label">Diskon (%) *</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" class="form-control @error('diskon') is-invalid @enderror"
                                               id="diskon" name="diskon" value="{{ old('diskon') }}"
                                               min="0" max="100" placeholder="0.00" required>
                                        <span class="input-group-text">%</span>
                                        @error('diskon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="minimal_pembelian" class="form-label">Minimal Pembelian *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control @error('minimal_pembelian') is-invalid @enderror"
                                               id="minimal_pembelian" name="minimal_pembelian"
                                               value="{{ old('minimal_pembelian', 0) }}" min="0" required>
                                        @error('minimal_pembelian')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="maksimal_diskon" class="form-label">Maksimal Diskon</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control @error('maksimal_diskon') is-invalid @enderror"
                                               id="maksimal_diskon" name="maksimal_diskon"
                                               value="{{ old('maksimal_diskon') }}" min="0">
                                        @error('maksimal_diskon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="info-text">
                                        <i class="fas fa-info-circle me-1"></i>Kosongkan untuk tidak ada batas
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai *</label>
                                    <input type="datetime-local" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                           id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                                    @error('tanggal_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir *</label>
                                    <input type="datetime-local" class="form-control @error('tanggal_berakhir') is-invalid @enderror"
                                           id="tanggal_berakhir" name="tanggal_berakhir" value="{{ old('tanggal_berakhir') }}" required>
                                    @error('tanggal_berakhir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="kuota" class="form-label">Kuota *</label>
                                    <input type="number" class="form-control @error('kuota') is-invalid @enderror"
                                           id="kuota" name="kuota" value="{{ old('kuota') }}"
                                           min="1" placeholder="Jumlah kuota promo" required>
                                    @error('kuota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="info-text">
                                        <i class="fas fa-users me-1"></i>Jumlah maksimal penggunaan promo
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>🎯 Aktif</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>⏸️ Nonaktif</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="deskripsi" class="form-label">Deskripsi Promo</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                          id="deskripsi" name="deskripsi" rows="4"
                                          placeholder="Jelaskan detail promo kepada pelanggan...">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center pt-3">
                                <a href="{{ route('promo.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Promo
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set minimal datetime untuk tanggal berakhir
        document.getElementById('tanggal_mulai').addEventListener('change', function() {
            document.getElementById('tanggal_berakhir').min = this.value;
        });
    </script>
</body>
</html>
