@extends('layouts.pelanggan')

@section('title', 'Dashboard')

@section('content')
    <h3>Selamat Datang, {{ $user->nama_lengkap }}!</h3>
    <p>Ini adalah halaman akun Anda. Di sini Anda dapat melihat aktivitas terbaru dan mengelola informasi akun Anda.</p>

    <hr>

    <h4>Riwayat Transaksi Terbaru</h4>
    @if($recentOrders->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            <span class="badge
                                @if($order->status_pesanan == 'selesai') bg-success
                                @elseif($order->status_pesanan == 'pending') bg-warning
                                @else bg-primary @endif">
                                {{ $order->status_pesanan }}
                            </span>
                        </td>
                        {{-- FIX: Menggunakan total_bayar --}}
                        <td>{{ $order->total_bayar_formatted }}</td>
                        <td>
                            <a href="{{ route('pelanggan.transaksi.detail', $order->id) }}" class="btn btn-sm btn-info">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Anda belum memiliki riwayat transaksi.</p>
    @endif

    <div class="mt-4">
        <a href="{{ route('pelanggan.profil') }}" class="btn btn-primary">Edit Profil</a>
        <a href="{{ route('pelanggan.riwayat') }}" class="btn btn-secondary">Lihat Riwayat Transaksi</a>
    </div>
@endsection
