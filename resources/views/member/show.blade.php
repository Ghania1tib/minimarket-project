<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Member - Minimarket</title>
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
        .member-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .info-card {
            border-left: 4px solid #004f7c;
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
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header member-header">
                        <h4 class="mb-0"><i class="fas fa-user me-2"></i>Detail Member</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Kode Member</th>
                                <td class="text-primary fw-bold">{{ $member->kode_member }}</td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>{{ $member->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <th>Nomor Telepon</th>
                                <td>{{ $member->nomor_telepon }}</td>
                            </tr>
                            <tr>
                                <th>Poin</th>
                                <td>
                                    <span class="badge bg-success fs-6">
                                        <i class="fas fa-star me-1"></i>{{ $member->poin_formatted }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal Daftar</th>
                                <td>{{ $member->tanggal_daftar->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <th>Total Transaksi</th>
                                <td>
                                    <span class="badge bg-primary fs-6">{{ $member->orders->count() }}</span>
                                </td>
                            </tr>
                        </table>

                        <div class="d-grid gap-2">
                            <a href="{{ route('member.edit', $member->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit Member
                            </a>
                            <form action="{{ route('member.destroy', $member->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100"
                                        onclick="return confirm('Hapus member {{ $member->nama_lengkap }}?')">
                                    <i class="fas fa-trash me-2"></i>Hapus Member
                                </button>
                            </form>
                            <a href="{{ route('member.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card info-card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik Member</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h3 class="text-primary">{{ $member->poin }}</h3>
                                        <small class="text-muted">Total Poin</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h3 class="text-success">{{ $member->orders->count() }}</h3>
                                        <small class="text-muted">Total Transaksi</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h6><i class="fas fa-history me-2"></i>Riwayat Poin</h6>
                            <div class="list-group">
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <small>Poin Awal</small>
                                        <small>{{ $member->tanggal_daftar->format('d M Y') }}</small>
                                    </div>
                                    <p class="mb-1">0 poin</p>
                                </div>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <small>Poin Saat Ini</small>
                                        <small>Hari ini</small>
                                    </div>
                                    <p class="mb-1 text-success">{{ $member->poin }} poin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
