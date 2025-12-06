<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Promo - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --color-primary: #5E548E;
            --color-secondary: #9F86C0;
            --color-accent: #E0B1CB;
            --color-danger: #E07A5F;
            --color-success: #70C1B3;
            --color-light: #F0E6EF;
            --color-white: #ffffff;
            --gradient-bg: linear-gradient(135deg, #F0E6EF 0%, #D891EF 100%);
            --font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            --border-radius-lg: 15px;
            --border-radius-sm: 8px;
        }

        body {
            background: var(--gradient-bg);
            min-height: 100vh;
            font-family: var(--font-family);
            padding: 20px 0;
        }

        .card {
            border: none;
            border-radius: var(--border-radius-lg);
            box-shadow: 0 15px 35px rgba(94, 84, 142, 0.1);
            background: var(--color-white);
        }

        .card-header {
            background-color: var(--color-primary);
            color: white;
            border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0 !important;
            border: none;
            padding: 2rem;
        }

        .detail-card {
            background-color: var(--color-light);
            border: none;
            border-radius: var(--border-radius-sm);
            color: var(--color-primary);
        }

        .btn-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            border-radius: var(--border-radius-sm);
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(94, 84, 142, 0.3);
        }

        .btn-warning {
            background-color: var(--color-danger);
            border: none;
            border-radius: var(--border-radius-sm);
            color: white;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            background-color: var(--color-secondary);
            transform: translateY(-2px);
        }

        .btn-danger {
            border-radius: var(--border-radius-sm);
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: var(--color-light);
            border: none;
            border-radius: var(--border-radius-sm);
            color: var(--color-primary);
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: var(--color-secondary);
            color: white;
            transform: translateY(-2px);
        }

        .badge-diskon {
            background-color: var(--color-primary);
            font-size: 1.1rem;
            padding: 10px 20px;
            border-radius: 20px;
            color: white;
        }

        .progress {
            height: 12px;
            border-radius: 10px;
            background: #e2e8f0;
        }

        .progress-bar {
            border-radius: 10px;
            background-color: var(--color-primary);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-2"><i class="fas fa-info-circle me-2"></i>Detail Promo</h3>
                            <p class="mb-0 opacity-75">Informasi lengkap tentang promo</p>
                        </div>
                        <div>
                            <span class="badge-diskon">{{ $promo->diskon }}% OFF</span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card detail-card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">
                                            <i class="fas fa-tag me-2"></i>Informasi Promo
                                        </h5>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="40%"><strong>Kode Promo</strong></td>
                                                <td><span class="badge bg-primary fs-6">{{ $promo->kode_promo }}</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Nama Promo</strong></td>
                                                <td>{{ $promo->nama_promo }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Diskon</strong></td>
                                                <td>
                                                    <span class="badge-diskon">{{ $promo->diskon }}%</span>
                                                    @if($promo->maksimal_diskon)
                                                        <br><small class="text-muted">Maksimal: Rp {{ number_format($promo->maksimal_diskon, 0, ',', '.') }}</small>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Minimal Pembelian</strong></td>
                                                <td>Rp {{ number_format($promo->minimal_pembelian, 0, ',', '.') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card detail-card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">
                                            <i class="fas fa-calendar-alt me-2"></i>Periode & Status
                                        </h5>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="40%"><strong>Tanggal Mulai</strong></td>
                                                <td>
                                                    <i class="fas fa-play-circle me-1" style="color: var(--color-primary);"></i>
                                                    {{ $promo->tanggal_mulai->format('d M Y H:i') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tanggal Berakhir</strong></td>
                                                <td>
                                                    <i class="fas fa-stop-circle me-1" style="color: var(--color-primary);"></i>
                                                    {{ $promo->tanggal_berakhir->format('d M Y H:i') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status</strong></td>
                                                <td>
                                                    @if($promo->is_active)
                                                        <span class="badge bg-success fs-6">
                                                            <i class="fas fa-bolt me-1"></i>Aktif
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger fs-6">
                                                            <i class="fas fa-clock me-1"></i>Nonaktif
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Sisa Hari</strong></td>
                                                <td>
                                                    @php
                                                        $daysLeft = now()->diffInDays($promo->tanggal_berakhir, false);
                                                    @endphp
                                                    @if($daysLeft > 0)
                                                        <span class="badge bg-info">{{ $daysLeft }} hari lagi</span>
                                                    @else
                                                        <span class="badge bg-warning">Kadaluarsa</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card detail-card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">
                                            <i class="fas fa-chart-pie me-2"></i>Penggunaan Kuota
                                        </h5>
                                        <div class="text-center mb-3">
                                            <h2 style="color: var(--color-primary);">{{ $promo->sisa_kuota }}</h2>
                                            <p class="text-muted">Sisa Kuota Tersedia</p>
                                        </div>
                                        <div class="progress mb-2">
                                            @php
                                                $percentage = ($promo->kuota_terpakai / $promo->kuota) * 100;
                                            @endphp
                                            <div class="progress-bar" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <small>Terpakai: {{ $promo->kuota_terpakai }}</small>
                                            <small>Total: {{ $promo->kuota }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card detail-card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">
                                            <i class="fas fa-file-alt me-2"></i>Deskripsi
                                        </h5>
                                        @if($promo->deskripsi)
                                            <p class="card-text">{{ $promo->deskripsi }}</p>
                                        @else
                                            <p class="card-text text-muted fst-italic">Tidak ada deskripsi tambahan</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <div class="btn-group" role="group">
                                <a href="{{ route('promo.edit', $promo->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>Edit Promo
                                </a>
                                <form action="{{ route('promo.destroy', $promo->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus promo ini?')">
                                        <i class="fas fa-trash me-2"></i>Hapus Promo
                                    </button>
                                </form>
                                <a href="{{ route('promo.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-list me-2"></i>Daftar Promo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
