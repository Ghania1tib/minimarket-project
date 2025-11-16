@extends('layouts.admin')

@section('title', 'Management Promo')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Management Promo</h1>
        <a href="{{ route('promo.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Promo Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Promo</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode Promo</th>
                            <th>Nama Promo</th>
                            <th>Jenis</th>
                            <th>Nilai</th>
                            <th>Periode</th>
                            <th>Kuota</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($promos as $promo)
                        <tr>
                            <td>
                                <strong>{{ $promo->kode_promo }}</strong>
                            </td>
                            <td>{{ $promo->nama_promo }}</td>
                            <td>
                                @if($promo->jenis_promo == 'diskon_persentase')
                                    <span class="badge badge-info">Diskon %</span>
                                @else
                                    <span class="badge badge-success">Diskon Nominal</span>
                                @endif
                            </td>
                            <td>{{ $promo->formatted_nilai }}</td>
                            <td>
                                {{ $promo->tanggal_mulai->format('d/m/Y') }} -
                                {{ $promo->tanggal_berakhir->format('d/m/Y') }}
                            </td>
                            <td>
                                @if($promo->kuota)
                                    {{ $promo->digunakan }}/{{ $promo->kuota }}
                                @else
                                    <span class="text-muted">Unlimited</span>
                                @endif
                            </td>
                            <td>
                                @if($promo->is_aktif)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('promo.show', $promo->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('promo.edit', $promo->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('promo.destroy', $promo->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menghapus promo ini?')">
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
        </div>
    </div>
</div>
@endsection

@section('styles')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
            }
        });
    });
</script>
@endsection
