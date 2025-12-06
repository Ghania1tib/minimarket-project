@extends('layouts.admin-base')

@section('title', 'Manajemen User - Minimarket')

@section('content')
    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h2 class="section-title mb-0">
                                    <i class="fas fa-users me-2"></i>Daftar User
                                </h2>
                                <p class="text-muted mb-0">Kelola data pengguna sistem</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="{{ route('user.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i>Tambah User Baru
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('user.index') }}" method="GET">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control search-box"
                                       placeholder="Cari user berdasarkan nama, email, atau telepon..."
                                       value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search me-2"></i>Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('user.index') }}" method="GET">
                            <select name="role" class="form-select search-box" onchange="this.form.submit()">
                                <option value="">Semua Role</option>
                                <option value="owner" {{ request('role') == 'owner' ? 'selected' : '' }}>Owner</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="kasir" {{ request('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                                <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
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

                        @if($users->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Lengkap</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Telepon</th>
                                            <th>Alamat</th>
                                            <th>Tanggal Bergabung</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="user-avatar me-3">
                                                            {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <strong>{{ $user->nama_lengkap }}</strong>
                                                            @if($user->id == auth()->id())
                                                                <span class="badge bg-info ms-1">Anda</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    @if($user->role === 'owner')
                                                        <span class="badge badge-owner rounded-pill p-2">Owner</span>
                                                    @elseif($user->role === 'admin')
                                                        <span class="badge badge-admin rounded-pill p-2">Admin</span>
                                                    @elseif($user->role === 'kasir')
                                                        <span class="badge badge-kasir rounded-pill p-2">Kasir</span>
                                                    @else
                                                        <span class="badge badge-customer rounded-pill p-2">Customer</span>
                                                    @endif
                                                </td>
                                                <td>{{ $user->no_telepon ?? '-' }}</td>
                                                <td>
                                                    @if($user->alamat)
                                                        <span data-bs-toggle="tooltip" data-bs-title="{{ $user->alamat }}">
                                                            {{ \Illuminate\Support\Str::limit($user->alamat, 30) }}
                                                        </span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit User">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @if($user->id != auth()->id())
                                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user {{ $user->nama_lengkap }}?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Hapus User">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <button class="btn btn-danger btn-sm" disabled data-bs-toggle="tooltip" title="Tidak dapat menghapus akun sendiri">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @endif
                                                        <button class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Detail User" onclick="showUserDetail({{ $user }})">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="pagination-container">
                                <div class="pagination-info">
                                    Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} user
                                </div>

                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <!-- Previous Page Link -->
                                        @if ($users->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">Sebelumnya</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev">Previous</a>
                                            </li>
                                        @endif

                                        <!-- Pagination Elements -->
                                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                            @if ($page == $users->currentPage())
                                                <li class="page-item active">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endforeach

                                        <!-- Next Page Link -->
                                        @if ($users->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">Selanjutnya</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">Selanjutnya</span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-users-slash"></i>
                                <h4>Belum Ada User</h4>
                                <p class="text-muted">Tidak ada data user yang ditemukan.</p>
                                <a href="{{ route('user.create') }}" class="btn btn-primary mt-3">
                                    <i class="fas fa-plus-circle me-2"></i>Tambah User Pertama
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Detail Modal -->
    <div class="modal fade" id="userDetailModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="userDetailContent">
                    <!-- Content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });

        function showUserDetail(user) {
            const content = `
                <div class="row">
                    <div class="col-12 text-center mb-3">
                        <div class="user-avatar mx-auto" style="width: 60px; height: 60px; font-size: 1.5rem;">
                            ${user.nama_lengkap.charAt(0).toUpperCase()}
                        </div>
                        <h4 class="mt-2">${user.nama_lengkap}</h4>
                        <span class="badge ${getRoleBadgeClass(user.role)}">${user.role}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>${user.email}</td>
                            </tr>
                            <tr>
                                <td><strong>Telepon:</strong></td>
                                <td>${user.no_telepon || '-'}</td>
                            </tr>
                            <tr>
                                <td><strong>Alamat:</strong></td>
                                <td>${user.alamat || '-'}</td>
                            </tr>
                            <tr>
                                <td><strong>Bergabung:</strong></td>
                                <td>${new Date(user.created_at).toLocaleDateString('id-ID')}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            `;

            document.getElementById('userDetailContent').innerHTML = content;
            new bootstrap.Modal(document.getElementById('userDetailModal')).show();
        }

        function getRoleBadgeClass(role) {
            const classes = {
                'owner': 'badge-owner',
                'admin': 'badge-admin',
                'kasir': 'badge-kasir',
                'customer': 'badge-customer'
            };
            return classes[role] || 'badge-secondary';
        }
    </script>

    <style>
        /* Semua style CSS dari file asli ditempatkan di sini */
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
            box-shadow: 0 5px 15px rgba(94, 84, 142, 0.3);
        }

        .btn-success {
            background-color: var(--color-success);
            border-color: var(--color-success);
        }

        .btn-warning {
            background-color: var(--color-danger);
            border-color: var(--color-danger);
        }

        .btn-info {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
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

        .table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .table thead th {
            background-color: var(--color-primary);
            color: white;
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(224, 177, 203, 0.1);
            transform: translateX(5px);
        }

        .table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            border-color: #e9ecef;
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

        .search-box {
            border-radius: 25px;
            border: 2px solid var(--color-accent);
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .search-box:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 0.2rem rgba(224, 177, 203, 0.25);
        }

        .section-title {
            color: var(--color-primary);
            font-weight: 700;
            margin-bottom: 1rem;
            border-left: 4px solid var(--color-accent);
            padding-left: 15px;
        }

        .action-buttons .btn {
            margin: 2px;
            border-radius: 6px;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: var(--color-accent);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-accent) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        /* Pagination Styles */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .pagination-info {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .pagination {
            margin: 0;
        }

        .page-link {
            color: var(--color-primary);
            border: 1px solid var(--color-accent);
            padding: 8px 16px;
            margin: 0 2px;
            border-radius: var(--border-radius-sm);
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background-color: var(--color-primary);
            color: white;
            border-color: var(--color-primary);
        }

        .page-item.active .page-link {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            border-color: #dee2e6;
        }
    </style>
@endsection
