@extends('layouts.pelanggan')

@section('title', 'Profil Saya')

@section('content')
    <h3>Profil Saya</h3>

    <form action="{{ route('pelanggan.profil.update') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" value="{{ $user->nama_lengkap }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                    <small class="text-muted">Email tidak dapat diubah</small>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" name="no_telepon" value="{{ $user->no_telepon }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" name="alamat" rows="3" required>{{ $user->alamat }}</textarea>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Profil</button>
        <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
