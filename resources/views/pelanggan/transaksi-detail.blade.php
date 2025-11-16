@extends('layouts.pelanggan')

@section('title', 'Riwayat Transaksi')

@section('content')
    <h3>Riwayat Transaksi</h3>

    @if($orders->count() > 0)
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
                    @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <span class="badge
                                @if($order->status_pesanan == 'selesai') bg-success
                                @elseif($order->status_pesanan == 'pending') bg-warning
                                @elseif($order->status_pesanan == 'dibatalkan') bg-danger
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
        <div class="alert alert-info">
            <p class="mb-0">Anda belum memiliki riwayat transaksi.</p>
        </div>
    @endif

    <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
@endsection
