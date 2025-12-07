@extends('layouts.admin-base')

@section('title', 'Detail Member')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="section-title mb-0">
                                <i class="fas fa-user me-2"></i>Detail Member
                            </h2>
                            <p class="text-muted mb-0">Kode: <strong>{{ $member->kode_member }}</strong></p>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('member.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Informasi Member -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-info-circle me-2"></i>Informasi Member
                    </h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-section">
                                <h6 class="info-title">Data Pribadi</h6>
                                <div class="info-item">
                                    <span class="info-label">Kode Member</span>
                                    <span class="info-value text-primary fw-bold">{{ $member->kode_member }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Nama Lengkap</span>
                                    <span class="info-value">{{ $member->nama_lengkap }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Nomor Telepon</span>
                                    <span class="info-value">{{ $member->nomor_telepon }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-section">
                                <h6 class="info-title">Statistik</h6>
                                <div class="info-item">
                                    <span class="info-label">Tanggal Daftar</span>
                                    <span class="info-value">{{ $member->tanggal_daftar->format('d/m/Y') }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Total Poin</span>
                                    <span class="info-value">
                                        <span class="badge badge-poin rounded-pill">
                                            <i class="fas fa-star me-1"></i>{{ $member->poin_formatted }}
                                        </span>
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Total Transaksi</span>
                                    <span class="info-value">
                                        <span class="badge badge-transaction rounded-pill">
                                            <i class="fas fa-shopping-cart me-1"></i>{{ $member->orders->count() }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aksi -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-cogs me-2"></i>Aksi
                    </h5>

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
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Statistik Ringkas -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-chart-bar me-2"></i>Statistik Member
                    </h5>

                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="stat-card bg-light p-3 rounded">
                                <div class="stat-icon text-primary mb-2">
                                    <i class="fas fa-star fa-2x"></i>
                                </div>
                                <h3 class="text-primary">{{ $member->poin }}</h3>
                                <small class="text-muted">Total Poin</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="stat-card bg-light p-3 rounded">
                                <div class="stat-icon text-success mb-2">
                                    <i class="fas fa-shopping-cart fa-2x"></i>
                                </div>
                                <h3 class="text-success">{{ $member->orders->count() }}</h3>
                                <small class="text-muted">Total Transaksi</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Poin -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-history me-2"></i>Riwayat Poin
                    </h5>

                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker">
                                <i class="fas fa-calendar-plus"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Poin Awal</h6>
                                <small class="text-muted">{{ $member->tanggal_daftar->format('d/m/Y') }}</small>
                                <p class="mb-0">0 poin</p>
                            </div>
                        </div>
                        <div class="timeline-item active">
                            <div class="timeline-marker">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Poin Saat Ini</h6>
                                <small class="text-muted">{{ now()->format('d/m/Y') }}</small>
                                <p class="mb-0 text-success">{{ $member->poin }} poin</p>
                            </div>
                        </div>
                    </div>
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
    --border-radius-lg: 15px;
    --border-radius-sm: 8px;
}

body {
    background: linear-gradient(135deg, #F0E6EF 0%, #D891EF 100%);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    min-height: 100vh;
}

/* Card Styling */
.card {
    border-radius: var(--border-radius-lg);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    border: none;
    background: var(--color-white);
    margin-bottom: 1.5rem;
}

.card-body {
    padding: 1.5rem;
}

/* Section Title */
.section-title {
    color: var(--color-primary);
    font-weight: 700;
    margin-bottom: 0.5rem;
    border-left: 4px solid var(--color-accent);
    padding-left: 15px;
}

/* Card Title */
.card-title {
    color: var(--color-primary);
    font-weight: 600;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
}

/* Button Styling */
.btn-primary, .btn-success, .btn-danger, .btn-warning, .btn-outline-primary {
    border-radius: var(--border-radius-sm);
    padding: 10px 20px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: var(--color-primary);
    border-color: var(--color-primary);
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

.btn-warning:hover {
    background-color: #FFA133;
    border-color: #FFA133;
    transform: translateY(-2px);
}

.btn-danger {
    background-color: var(--color-danger);
    border-color: var(--color-danger);
}

.btn-danger:hover {
    background-color: #D7694E;
    border-color: #D7694E;
    transform: translateY(-2px);
}

.btn-outline-primary {
    border: 2px solid var(--color-primary);
    color: var(--color-primary);
}

.btn-outline-primary:hover {
    background: var(--color-primary);
    color: white;
    transform: translateY(-2px);
}

/* Badge Styling */
.badge {
    font-weight: 500;
    letter-spacing: 0.3px;
    padding: 6px 12px !important;
    font-size: 0.85rem !important;
}

.rounded-pill {
    border-radius: 50px !important;
}

.badge-poin {
    background-color: var(--color-success) !important;
    color: white !important;
}

.badge-transaction {
    background-color: var(--color-info) !important;
    color: white !important;
}

/* Info Section Styling */
.info-section {
    background: #f8f9fa;
    border-radius: var(--border-radius-sm);
    padding: 1.25rem;
    margin-bottom: 1rem;
}

.info-title {
    color: var(--color-primary);
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--color-accent);
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    color: #6c757d;
    font-weight: 500;
    font-size: 0.9rem;
}

.info-value {
    color: var(--color-primary);
    font-weight: 600;
    text-align: right;
    max-width: 60%;
}

/* Stat Card */
.stat-card {
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.stat-icon {
    transition: all 0.3s ease;
}

/* Timeline Styling */
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline:before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--color-accent);
}

.timeline-item {
    position: relative;
    margin-bottom: 1.5rem;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: var(--color-accent);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    z-index: 1;
}

.timeline-item.active .timeline-marker {
    background: var(--color-success);
    box-shadow: 0 0 0 3px rgba(112, 193, 179, 0.2);
}

.timeline-content {
    background: #f8f9fa;
    border-radius: var(--border-radius-sm);
    padding: 1rem;
    border-left: 3px solid var(--color-accent);
}

.timeline-item.active .timeline-content {
    background: rgba(112, 193, 179, 0.05);
    border-left-color: var(--color-success);
}

.timeline-content h6 {
    color: var(--color-primary);
    font-weight: 600;
    margin-bottom: 0.25rem;
}

/* Grid Gap */
.d-grid.gap-2 {
    gap: 10px !important;
}

/* Responsive */
@media (max-width: 768px) {
    .btn-outline-primary {
        width: 100%;
        margin-bottom: 0.5rem;
    }

    .info-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .info-value {
        text-align: left;
        max-width: 100%;
        margin-top: 5px;
    }

    .stat-card {
        margin-bottom: 1rem;
    }
}
</style>
@endsection
