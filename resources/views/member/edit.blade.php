<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Member - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ffdde1, #a1c4fd);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #004f7c;">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard.staff') }}">
                <i class="fas fa-cash-register"></i> Kasir Minimarket
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Member</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('member.update', $member->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="kode_member" class="form-label">Kode Member</label>
                                <input type="text" class="form-control @error('kode_member') is-invalid @enderror"
                                       id="kode_member" name="kode_member"
                                       value="{{ old('kode_member', $member->kode_member) }}"
                                       required>
                                @error('kode_member')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                       id="nama_lengkap" name="nama_lengkap"
                                       value="{{ old('nama_lengkap', $member->nama_lengkap) }}"
                                       placeholder="Masukkan nama lengkap member" required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror"
                                       id="nomor_telepon" name="nomor_telepon"
                                       value="{{ old('nomor_telepon', $member->nomor_telepon) }}"
                                       placeholder="Contoh: 081234567890" required>
                                @error('nomor_telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_daftar" class="form-label">Tanggal Daftar</label>
                                <input type="date" class="form-control @error('tanggal_daftar') is-invalid @enderror"
                                       id="tanggal_daftar" name="tanggal_daftar"
                                       value="{{ old('tanggal_daftar', $member->tanggal_daftar->format('Y-m-d')) }}" required>
                                @error('tanggal_daftar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="alert alert-info">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Poin Saat Ini:</strong>
                                        <span class="badge bg-success fs-6">{{ $member->poin_formatted }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Total Transaksi:</strong>
                                        <span class="badge bg-primary fs-6">{{ $member->orders->count() }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('member.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Member
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
