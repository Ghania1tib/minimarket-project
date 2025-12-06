<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Member - Toko Saudara 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 280px;
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
            margin: 0;
            padding: 0;
            background: var(--gradient-bg);
            font-family: var(--font-family);
            min-height: 100vh;
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .content-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: margin-left 0.3s ease;
            background: var(--gradient-bg);
            min-height: 100vh;
        }

        .navbar-custom {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-custom .navbar-brand {
            color: white !important;
            font-weight: bold;
        }

        .navbar-custom .nav-link {
            color: rgba(255,255,255,0.9) !important;
        }

        .navbar-custom .nav-link:hover {
            color: white !important;
        }

        .content-container {
            background: white;
            border-radius: var(--border-radius-lg);
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            margin-top: 20px;
        }

        .text-theme-primary { color: var(--color-primary) !important; }
        .bg-theme-accent { background-color: var(--color-accent) !important; }
        .bg-theme-light { background-color: var(--color-light) !important; }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: var(--border-radius-sm);
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(94, 84, 142, 0.3);
        }

        @media (max-width: 768px) {
            .content-wrapper {
                margin-left: 0;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <!-- Sidebar -->
        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'owner')
            @include('layouts.sidebar-admin')
        @elseif(Auth::user()->role === 'kasir' || Auth::user()->role === 'staff')
            @include('layouts.sidebar-kasir')
        @endif

        <div class="content-wrapper">
            <!-- Content -->
            <div class="content-container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="text-theme-primary"><i class="fas fa-users me-2"></i>Manajemen Member</h1>
                    <a href="{{ route('member.create') }}" class="btn btn-primary-custom">
                        <i class="fas fa-plus me-2"></i>Tambah Member
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Search Form -->
                <div class="card mb-4">
                    <div class="card-header bg-theme-accent">
                        <h5 class="mb-0 text-theme-primary"><i class="fas fa-search me-2"></i>Cari Member</h5>
                    </div>
                    <div class="card-body">
                        <form action="#" method="GET" class="row g-3">
                            <div class="col-md-8">
                                <input type="text" name="keyword" class="form-control" placeholder="Cari member berdasarkan nama, kode, atau telepon..." value="{{ request('keyword') }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary-custom w-100">
                                    <i class="fas fa-search me-2"></i>Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    @foreach($members as $member)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header bg-theme-accent">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 text-theme-primary">{{ $member->nama_lengkap }}</h6>
                                        <span class="badge bg-success">
                                            <i class="fas fa-star me-1"></i>{{ $member->poin_formatted }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <small class="text-muted"><i class="fas fa-id-card me-2"></i>Kode:</small>
                                        <p class="mb-1 fw-bold text-primary">{{ $member->kode_member }}</p>

                                        <small class="text-muted"><i class="fas fa-phone me-2"></i>Telepon:</small>
                                        <p class="mb-1">{{ $member->nomor_telepon }}</p>

                                        <small class="text-muted"><i class="fas fa-calendar me-2"></i>Tanggal Daftar:</small>
                                        <p class="mb-1">{{ $member->tanggal_daftar->format('d M Y') }}</p>

                                        <small class="text-muted"><i class="fas fa-shopping-cart me-2"></i>Total Transaksi:</small>
                                        <p class="mb-0">{{ $member->orders->count() }}</p>
                                    </div>

                                    <div class="btn-group w-100">
                                        <a href="{{ route('member.show', $member->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('member.edit', $member->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('member.destroy', $member->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Hapus member {{ $member->nama_lengkap }}?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($members->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-4x text-muted mb-3"></i>
                        <h4 class="text-theme-primary">Belum ada member</h4>
                        <p class="text-muted">Mulai dengan menambahkan member pertama Anda.</p>
                        <a href="{{ route('member.create') }}" class="btn btn-primary-custom">
                            <i class="fas fa-plus me-2"></i>Tambah Member Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
