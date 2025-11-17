<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail User - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            font-family: var(--font-family);
            min-height: 100vh;
        }

        .navbar {
            background-color: var(--color-accent);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand,
        .navbar-nav .nav-link {
            font-weight: 700;
            color: var(--color-primary) !important;
        }

        .card {
            border-radius: var(--border-radius-lg);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: none;
            background: var(--color-white);
        }

        .btn-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            border-radius: var(--border-radius-sm);
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            border: 2px solid var(--color-primary);
            color: var(--color-primary);
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--color-primary);
            color: white;
            transform: translateY(-2px);
        }

        .section-title {
            color: var(--color-primary);
            font-weight: 700;
            margin-bottom: 1rem;
            border-left: 4px solid var(--color-accent);
            padding-left: 15px;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
        }

        .user-avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-accent) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 3rem;
            margin: 0 auto;
        }

        .info-card {
            border-left: 4px solid var(--color-accent);
        }

        .badge-owner {
            background-color: var(--color-primary);
            color: white;
        }

        .badge-admin {
            background-color: var(--color-secondary);
            color: white;
        }

        .badge-kasir {
            background-color: var(--color-danger);
            color: white;
        }

        .badge-customer {
            background-color: var(--color-success);
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('owner.dashboard') }}">
                <i class="fas fa-users-cog me-2"></i>Manajemen User
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link me-3" href="{{ route('owner.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                </a>
                <span class="navbar-text me-3">
                    <i class="fas fa-user me-1"></i>{{ Auth::user()->nama_lengkap }}
                </span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm logout-btn">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h2 class="section-title mb-0">
                                    <i class="fas fa-user-circle me-2"></i>Detail User
                                </h2>
                                <p class="text-muted mb-0">Informasi lengkap user</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="{{ route('user.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar User
                                </a>
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- User Profile Section -->
                        <div class="text-center mb-5">
                            <div class="user-avatar mb-3">
                                {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                            </div>
                            <h3 class="mb-2">{{ $user->nama_lengkap }}</h3>
                            <span class="badge
                                @if($user->role === 'owner') badge-owner
                                @elseif($user->role === 'admin') badge-admin
                                @elseif($user->role === 'kasir') badge-kasir
                                @else badge-customer @endif rounded-pill p-3 fs-6">
                                {{ ucfirst($user->role) }}
                            </span>
                            @if($user->id == auth()->id())
                                <span class="badge bg-info ms-2 p-2">
                                    <i class="fas fa-user me-1"></i>Anda
                                </span>
                            @endif
                        </div>

                        <!-- User Information -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card info-card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title" style="color: var(--color-primary);">
                                            <i class="fas fa-info-circle me-2"></i>Informasi Pribadi
                                        </h5>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="40%"><strong>Email:</strong></td>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Telepon:</strong></td>
                                                <td>{{ $user->no_telepon ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Bergabung:</strong></td>
                                                <td>{{ $user->created_at->format('d F Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Terakhir Update:</strong></td>
                                                <td>{{ $user->updated_at->format('d F Y H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card info-card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title" style="color: var(--color-primary);">
                                            <i class="fas fa-map-marker-alt me-2"></i>Alamat
                                        </h5>
                                        @if($user->alamat)
                                            <p class="card-text">{{ $user->alamat }}</p>
                                        @else
                                            <p class="card-text text-muted">Alamat belum diisi</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statistics -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title" style="color: var(--color-primary);">
                                            <i class="fas fa-chart-bar me-2"></i>Statistik
                                        </h5>
                                        <div class="row text-center">
                                            <div class="col-md-3">
                                                <div class="border-end">
                                                    <h4 style="color: var(--color-primary);">{{ $user->created_at->diffForHumans() }}</h4>
                                                    <small class="text-muted">Bergabung</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="border-end">
                                                    <h4 style="color: var(--color-success);">
                                                        @php
                                                            $activeStatus = $user->is_active ?? true;
                                                        @endphp
                                                        {{ $activeStatus ? 'Aktif' : 'Nonaktif' }}
                                                    </h4>
                                                    <small class="text-muted">Status</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="border-end">
                                                    <h4 style="color: var(--color-secondary);">
                                                        {{ $user->email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi' }}
                                                    </h4>
                                                    <small class="text-muted">Email</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div>
                                                    <h4 style="color: var(--color-danger);">
                                                        -
                                                    </h4>
                                                    <small class="text-muted">Aktivitas</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning me-md-2">
                                <i class="fas fa-edit me-2"></i>Edit User
                            </a>
                            @if($user->id != auth()->id())
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user {{ $user->nama_lengkap }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash me-2"></i>Hapus User
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-danger" disabled>
                                    <i class="fas fa-trash me-2"></i>Hapus User
                                </button>
                            @endif
                            <a href="{{ route('user.index') }}" class="btn btn-outline-secondary ms-md-2">
                                <i class="fas fa-list me-2"></i>Daftar User
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
