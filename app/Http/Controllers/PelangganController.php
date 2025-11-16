<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PelangganController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Cek role
        if (!$user->isCustomer()) {
            return redirect('/')->with('error', 'Akses ditolak! Hanya untuk pelanggan.');
        }

        // Untuk sementara, kita berikan data kosong untuk orders
        $recentOrders = collect([]);

        return view('pelanggan.dashboard', compact('user', 'recentOrders'));
    }

    public function profil()
    {
        $user = Auth::user();
        if (!$user->isCustomer()) {
            return redirect('/')->with('error', 'Akses ditolak! Hanya untuk pelanggan.');
        }

        return view('pelanggan.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        if (!$user->isCustomer()) {
            return redirect('/')->with('error', 'Akses ditolak! Hanya untuk pelanggan.');
        }

        $validated = $request->validate([
            'nama_lengkap' => 'required|min:3|max:50',
            'no_telepon' => 'required|string|max:20',
            'alamat' => 'required|string'
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'Profil berhasil diupdate.');
    }

    public function riwayatTransaksi()
    {
        $user = Auth::user();
        if (!$user->isCustomer()) {
            return redirect('/')->with('error', 'Akses ditolak! Hanya untuk pelanggan.');
        }

        $orders = collect([]); // Data kosong untuk sementara

        return view('pelanggan.riwayat', compact('orders'));
    }

    public function detailTransaksi($order)
    {
        $user = Auth::user();
        if (!$user->isCustomer()) {
            return redirect('/')->with('error', 'Akses ditolak! Hanya untuk pelanggan.');
        }

        return view('pelanggan.transaksi-detail', compact('order'));
    }
}
