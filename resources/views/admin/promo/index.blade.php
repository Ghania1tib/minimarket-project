<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Promo - Minimarket</title>
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
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.1);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            margin-bottom: 25px;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.2);
        }

        .card-header {
            background: var(--gradient-primary);
            color: white;
            border-radius: 20px 20px 0 0 !important;
            border: none;
            padding: 1.5rem;
        }

        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            border-radius: 15px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--gradient-secondary);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-light {
            background: var(--gradient-light);
            border: none;
            border-radius: 15px;
            color: var(--primary-pink);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-light:hover {
            background: var(--gradient-secondary);
            color: white;
            transform: translateY(-2px);
        }

        .table th {
            background: var(--gradient-light);
            color: var(--primary-pink);
            border: none;
            font-weight: 600;
            padding: 1rem;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #e9ecef;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-active {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            color: white;
        }

        .status-inactive {
            background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
            color: white;
        }

        .promo-card {
            transition: all 0.3s ease;
            border-left: 4px solid var(--primary-blue);
            background: white;
        }

        .promo-card:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            transform: translateX(5px);
        }

        .progress {
            height: 10px;
            border-radius: 10px;
            background: #e2e8f0;
        }

        .progress-bar {
            border-radius: 10px;
            transition: width 0.6s ease;
        }

        .empty-state {
            background: var(--gradient-light);
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
        }

        .badge-diskon {
            background: var(--gradient-primary);
            font-size: 0.9rem;
            padding: 8px 12px;
            border-radius: 15px;
        }

        .btn-group .btn {
            border-radius: 12px;
            margin: 0 2px;
            transition: all 0.3s ease;
        }

        .btn-group .btn:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0"><i class="fas fa-tags me-2"></i>Management Promo</h4>
                            <p class="mb-0 mt-1 opacity-75">Kelola promo dan diskon untuk meningkatkan penjualan</p>
                        </div>
                        <a href="{{ route('promo.create') }}" class="btn btn-light">
                            <i class="fas fa-plus me-2"></i>Tambah Promo Baru
                        </a>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 15px;">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($promos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Kode Promo</th>
                                        <th>Nama Promo</th>
                                        <th>Diskon</th>
                                        <th>Periode</th>
                                        <th>Kuota</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($promos as $promo)
                                        <tr class="promo-card">
                                            <td>
                                                <strong class="text-primary" style="color: var(--primary-blue) !important;">{{ $promo->kode_promo }}</strong>
                                            </td>
                                            <td>
                                                <strong>{{ $promo->nama_promo }}</strong>
                                                @if($promo->deskripsi)
                                                    <br><small class="text-muted">{{ Str::limit($promo->deskripsi, 30) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge-diskon text-white">{{ $promo->diskon }}%</span>
                                                @if($promo->maksimal_diskon)
                                                    <br><small class="text-muted">Max: Rp {{ number_format($promo->maksimal_diskon, 0, ',', '.') }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <small>
                                                    <i class="fas fa-calendar me-1" style="color: var(--primary-pink);"></i>
                                                    {{ $promo->tanggal_mulai->format('d M Y') }}<br>
                                                    <i class="fas fa-arrow-down me-1" style="color: var(--primary-pink);"></i>
                                                    {{ $promo->tanggal_berakhir->format('d M Y') }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-grow-1 me-2">
                                                        @php
                                                            $percentage = ($promo->kuota_terpakai / $promo->kuota) * 100;
                                                            $progressClass = $percentage > 80 ? 'bg-danger' : ($percentage > 50 ? 'bg-warning' : 'bg-success');
                                                        @endphp
                                                        <div class="progress-bar {{ $progressClass }}" style="width: {{ $percentage }}%"></div>
                                                    </div>
                                                    <small style="color: var(--primary-pink); font-weight: 600;">{{ $promo->sisa_kuota }}</small>
                                                </div>
                                                <small class="text-muted">{{ $promo->kuota_terpakai }}/{{ $promo->kuota }} terpakai</small>
                                            </td>
                                            <td>
                                                @if($promo->is_active)
                                                    <span class="status-badge status-active">
                                                        <i class="fas fa-bolt me-1"></i>Aktif
                                                    </span>
                                                @else
                                                    <span class="status-badge status-inactive">
                                                        <i class="fas fa-clock me-1"></i>Nonaktif
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('promo.show', $promo->id) }}" class="btn btn-info btn-sm" title="Detail" style="background: var(--lilac); border: none;">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('promo.edit', $promo->id) }}" class="btn btn-warning btn-sm" title="Edit" style="background: var(--soft-pink); border: none; color: white;">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('promo.destroy', $promo->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus promo ini?')"
                                                                style="border-radius: 12px;">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="empty-state">
                            <i class="fas fa-tags fa-4x mb-3" style="color: var(--primary-pink);"></i>
                            <h4 style="color: var(--primary-pink);">Belum Ada Promo</h4>
                            <p class="text-muted mb-4">Mulai buat promo pertama Anda untuk menarik lebih banyak pelanggan</p>
                            <a href="{{ route('promo.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Tambah Promo Pertama
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-hide alert setelah 5 detik
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                new bootstrap.Alert(alert).close();
            });
        }, 5000);
    </script>
</body>
</html>
