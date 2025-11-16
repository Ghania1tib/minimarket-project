<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Member - Minimarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ffdde1, #a1c4fd);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background-color: #004f7c;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            margin-bottom: 20px;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .member-card {
            border-left: 4px solid #004f7c;
        }
        .points-badge {
            font-size: 1.1em;
            padding: 8px 12px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard.staff') }}">
                <i class="fas fa-cash-register"></i> Kasir Minimarket
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('dashboard.staff') }}">Dashboard</a>
                <a class="nav-link" href="{{ route('produk.index') }}">Produk</a>
                <a class="nav-link" href="{{ route('kategori.index') }}">Kategori</a>
                <a class="nav-link active" href="{{ route('member.index') }}">Member</a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-users me-2"></i> Manajemen Member</h1>
            <a href="{{ route('member.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Member
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Search Form -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('member.search') }}" method="GET" class="row g-3">
                    <div class="col-md-8">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari member berdasarkan nama, kode, atau telepon..." value="{{ request('keyword') }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            @foreach($members as $member)
                <div class="col-md-4">
                    <div class="card member-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title">{{ $member->nama_lengkap }}</h5>
                                <span class="badge bg-success points-badge">
                                    <i class="fas fa-star me-1"></i>{{ $member->poin_formatted }}
                                </span>
                            </div>

                            <p class="card-text">
                                <strong><i class="fas fa-id-card me-2"></i>Kode:</strong>
                                <span class="text-primary">{{ $member->kode_member }}</span><br>

                                <strong><i class="fas fa-phone me-2"></i>Telepon:</strong>
                                {{ $member->nomor_telepon }}<br>

                                <strong><i class="fas fa-calendar me-2"></i>Tanggal Daftar:</strong>
                                {{ $member->tanggal_daftar->format('d M Y') }}<br>

                                <strong><i class="fas fa-shopping-cart me-2"></i>Total Transaksi:</strong>
                                {{ $member->orders->count() }}
                            </p>

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
                <h4>Belum ada member</h4>
                <p class="text-muted">Mulai dengan menambahkan member pertama Anda.</p>
                <a href="{{ route('member.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Member Pertama
                </a>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
