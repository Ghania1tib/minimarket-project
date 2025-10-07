@extends('layouts.pelanggan')

@section('title', 'Dashboard')

@section('content')
    <h3>Selamat Datang, {{ $user->name }}!</h3>
    <p>Ini adalah halaman akun Anda. Di sini Anda dapat melihat aktivitas terbaru dan mengelola informasi akun Anda.</p>

    <hr>

    <h4>Riwayat Transaksi Terbaru</h4>
    @if($recentOrders->count() > 0)
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
                    <td><span class="badge bg-primary">{{ $order->status }}</span></td>
                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('pelanggan.transaksi.detail', $order->id) }}" class="btn btn-sm btn-info">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Anda belum memiliki riwayat transaksi.</p>
    @endif
@endsection
