@extends('layouts.admin-base')

@section('title', 'Manajemen Member - Toko Saudara 2')

@section('content')
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h2 class="section-title mb-0">
                                    <i class="fas fa-users me-2"></i>Manajemen Member
                                </h2>
                                <p class="text-muted mb-0">Kelola data member toko</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="{{ route('member.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i>Tambah Member Baru
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Search Form -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('member.index') }}" method="GET">
                            <div class="input-group">
                                <span class="input-group-text border-end-0"
                                    style="
                            background-color: transparent;
                            border: 2px solid #E0B1CB;
                            border-right: none;
                            border-radius: var(--border-radius-sm) 0 0 var(--border-radius-sm);
                        ">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="keyword" class="form-control search-box border-start-0"
                                    placeholder="Cari member berdasarkan nama, kode, atau telepon..."
                                    value="{{ request('keyword') }}">
                                <button class="btn btn-primary" type="submit"
                                    style="
                            border-radius: 0 var(--border-radius-sm) var(--border-radius-sm) 0;
                        ">
                                    <i class="fas fa-search me-2"></i>Cari
                                </button>
                            </div>

                            <!-- Reset button jika ada keyword -->
                            @if (request('keyword'))
                                <div class="mt-2">
                                    <small class="text-muted">
                                        Hasil pencarian untuk: "{{ request('keyword') }}"
                                        <a href="{{ route('member.index') }}" class="text-danger ms-2">
                                            <i class="fas fa-times me-1"></i>Reset pencarian
                                        </a>
                                    </small>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Members Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($members->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kode Member</th>
                                            <th>Nama Lengkap</th>
                                            <th>Telepon</th>
                                            <th>Poin</th>
                                            <th>Total Transaksi</th>
                                            <th>Tanggal Daftar</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($members as $member)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="member-avatar me-3">
                                                            {{ strtoupper(substr($member->nama_lengkap, 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <strong class="text-primary">{{ $member->kode_member }}</strong>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <strong>{{ $member->nama_lengkap }}</strong>
                                                </td>
                                                <td>{{ $member->nomor_telepon }}</td>
                                                <td>
                                                    <span class="badge badge-poin rounded-pill p-2">
                                                        <i class="fas fa-star me-1"></i>{{ $member->poin_formatted }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-transaction rounded-pill p-2">
                                                        <i
                                                            class="fas fa-shopping-cart me-1"></i>{{ $member->orders->count() }}
                                                    </span>
                                                </td>
                                                <td>{{ $member->tanggal_daftar->format('d/m/Y') }}</td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ route('member.show', $member->id) }}"
                                                            class="btn btn-info btn-sm" data-bs-toggle="tooltip"
                                                            title="Detail Member">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('member.edit', $member->id) }}"
                                                            class="btn btn-warning btn-sm" data-bs-toggle="tooltip"
                                                            title="Edit Member">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('member.destroy', $member->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus member {{ $member->nama_lengkap }}?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                data-bs-toggle="tooltip" title="Hapus Member">
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

                            <!-- Info Jumlah Member -->
                            <div class="pagination-container mt-3">
                                <div class="pagination-info">
                                    Total: {{ $members->count() }} member
                                </div>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-users-slash fa-4x"></i>
                                <h4>Belum Ada Member</h4>
                                <p class="text-muted">Tidak ada data member yang ditemukan.</p>
                                <a href="{{ route('member.create') }}" class="btn btn-primary mt-3">
                                    <i class="fas fa-plus-circle me-2"></i>Tambah Member Pertama
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Variabel CSS konsisten */
        :root {
            --color-primary: #5E548E;
            --color-secondary: #9F86C0;
            --color-accent: #E0B1CB;
            --color-danger: #E07A5F;
            --color-success: #70C1B3;
            --color-warning: #FFB347;
            --color-info: #5BC0DE;
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

        .btn-warning {
            background-color: var(--color-warning);
            border-color: var(--color-warning);
            color: #000;
        }

        .btn-info {
            background-color: var(--color-info);
            border-color: var(--color-info);
        }

        .btn-danger {
            background-color: var(--color-danger);
            border-color: var(--color-danger);
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

        /* Badge Styles */
        .badge-poin {
            background-color: var(--color-success);
            color: white;
        }

        .badge-transaction {
            background-color: var(--color-info);
            color: white;
        }

        .badge {
            font-weight: 500;
            letter-spacing: 0.3px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Search Box */
        .search-box {
            border-radius: var(--border-radius-sm);
            border: 2px solid var(--color-accent);
            padding: 8px 15px;
            transition: all 0.3s ease;
        }

        .search-box:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 0.2rem rgba(224, 177, 203, 0.25);
        }

        .input-group .search-box {
            border-left: none;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .input-group-text {
            background-color: transparent;
            border-right: none;
            border: 2px solid var(--color-accent);
            border-right: none;
            border-radius: var(--border-radius-sm) 0 0 var(--border-radius-sm);
        }

        /* Section Title */
        .section-title {
            color: var(--color-primary);
            font-weight: 700;
            margin-bottom: 0.5rem;
            border-left: 4px solid var(--color-accent);
            padding-left: 15px;
        }

        /* Member Avatar */
        .member-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-accent) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .action-buttons .btn {
            border-radius: 6px;
            transition: all 0.3s ease;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        /* Empty State */
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

        .empty-state h4 {
            color: var(--color-primary);
            margin-bottom: 0.5rem;
        }

        /* Alert Styles */
        .alert {
            border-radius: var(--border-radius-sm);
            border: none;
        }

        .alert-success {
            background-color: rgba(112, 193, 179, 0.1);
            border-left: 4px solid var(--color-success);
            color: #0f5132;
        }

        .alert-danger {
            background-color: rgba(224, 122, 95, 0.1);
            border-left: 4px solid var(--color-danger);
            color: #721c24;
        }

        /* Pagination Info */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .pagination-info {
            color: #6c757d;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .pagination-container {
                flex-direction: column;
                gap: 15px;
            }

            .action-buttons {
                flex-wrap: wrap;
            }

            .table-responsive {
                font-size: 0.9rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
@endsection
