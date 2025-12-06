@extends('layouts.app')

@section('title', 'Manajemen Promo')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Promo</h3>
                    <div class="card-tools">
                        <a href="{{ route('promo.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Promo Baru
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="promoTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Promo</th>
                                    <th>Nama Promo</th>
                                    <th>Jenis</th>
                                    <th>Nilai</th>
                                    <th>Periode</th>
                                    <th>Status</th>
                                    <th>Kuota</th>
                                    <th>Min. Pembelian</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($promos as $index => $promo)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <strong>{{ $promo->kode_promo }}</strong>
                                        </td>
                                        <td>{{ $promo->nama_promo }}</td>
                                        <td>
                                            @if($promo->jenis_promo == 'diskon_persentase')
                                                <span class="badge badge-info">Persentase</span>
                                            @else
                                                <span class="badge badge-success">Nominal</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $promo->formatted_nilai }}</strong>
                                            @if($promo->maksimal_diskon)
                                                <br><small class="text-muted">Maks: Rp {{ number_format($promo->maksimal_diskon, 0, ',', '.') }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <small>
                                                {{ $promo->tanggal_mulai->format('d/m/Y') }}<br>
                                                s/d<br>
                                                {{ $promo->tanggal_berakhir->format('d/m/Y') }}
                                            </small>
                                        </td>
                                        <td>
                                            @php
                                                $isActive = $promo->status &&
                                                           now()->between($promo->tanggal_mulai, $promo->tanggal_berakhir) &&
                                                           (!$promo->kuota || $promo->digunakan < $promo->kuota);
                                            @endphp
                                            <span class="badge badge-{{ $isActive ? 'success' : 'secondary' }}">
                                                {{ $isActive ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                            <br>
                                            <small class="text-muted">
                                                {{ $promo->status ? 'Aktif' : 'Nonaktif' }}
                                            </small>
                                        </td>
                                        <td>
                                            @if($promo->kuota)
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                        @php
                                                            // PERBAIKAN: Hindari division by zero
                                                            $terpakai = $promo->digunakan ?? 0;
                                                            $kuota = $promo->kuota ?? 1; // Default 1 untuk menghindari division by zero
                                                            $percentage = $kuota > 0 ? ($terpakai / $kuota) * 100 : 0;
                                                            $progressClass = $percentage > 80 ? 'bg-danger' : ($percentage > 50 ? 'bg-warning' : 'bg-success');
                                                        @endphp
                                                        <div class="progress-bar {{ $progressClass }}"
                                                             style="width: {{ $percentage }}%"
                                                             title="{{ $terpakai }}/{{ $kuota }}">
                                                        </div>
                                                    </div>
                                                    <small style="font-weight: 600;">
                                                        {{ $kuota - $terpakai }}
                                                    </small>
                                                </div>
                                                <small class="text-muted">
                                                    {{ $terpakai }}/{{ $kuota }} terpakai
                                                </small>
                                            @else
                                                <span class="badge badge-info">Unlimited</span>
                                                <br>
                                                <small class="text-muted">
                                                    Terpakai: {{ $promo->digunakan ?? 0 }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($promo->minimal_pembelian > 0)
                                                Rp {{ number_format($promo->minimal_pembelian, 0, ',', '.') }}
                                            @else
                                                <span class="text-muted">Tidak ada</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('promo.show', $promo->id) }}"
                                                   class="btn btn-info"
                                                   title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('promo.edit', $promo->id) }}"
                                                   class="btn btn-warning"
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if(Auth::user()->isOwner() || Auth::user()->isAdmin())
                                                    <form action="{{ route('promo.destroy', $promo->id) }}"
                                                          method="POST"
                                                          class="d-inline"
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus promo ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-tags fa-3x mb-3"></i>
                                                <br>
                                                Belum ada promo yang dibuat.
                                                <br>
                                                <a href="{{ route('promo.create') }}" class="btn btn-primary mt-2">
                                                    <i class="fas fa-plus"></i> Buat Promo Pertama
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($promos->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $promos->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .progress {
        background-color: #e9ecef;
        border-radius: 0.25rem;
    }
    .progress-bar {
        border-radius: 0.25rem;
        transition: width 0.6s ease;
    }
    .table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }
    .btn-group-sm > .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide alert setelah 5 detik
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Konfirmasi sebelum menghapus
        $('form[onsubmit]').on('submit', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus promo ini?')) {
                e.preventDefault();
                return false;
            }
        });

        // Tambakan tooltip
        $('[title]').tooltip();
    });
</script>
@endpush
