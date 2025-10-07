<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Order; // Ganti dengan model Transaksi Anda

class PelangganController extends Controller
{
    /**
     * Menampilkan halaman utama dashboard pelanggan.
     * Sesuai hak akses: Profil Akun (Read) & Laporan (Read Only Sendiri)
     */
    public function dashboard()
    {
        // Mengambil data user yang sedang login
        $user = Auth::user();

        // Mengambil beberapa transaksi terakhir milik user ini saja
        $recentOrders = Order::where('user_id', $user->id)
                             ->latest()
                             ->take(5)
                             ->get();

        return view('pelanggan.dashboard', compact('user', 'recentOrders'));
    }

    /**
     * Menampilkan halaman untuk mengedit profil.
     * Sesuai hak akses: Profil Akun (Update Sendiri)
     */
    public function profil()
    {
        $user = Auth::user();
        return view('pelanggan.profil', compact('user'));
    }

    /**
     * Memproses update data profil.
     */
    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update data user
        $user->name = $request->name;
        $user->email = $request->email;

        // Jika user mengisi password baru
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('pelanggan.profil')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Menampilkan seluruh riwayat transaksi milik pelanggan.
     * Sesuai hak akses: Transaksi / Pembelian (Read Sendiri)
     */
    public function riwayatTransaksi()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->latest()->paginate(10); // Paginate untuk data banyak

        return view('pelanggan.riwayat', compact('orders'));
    }

    /**
     * Menampilkan detail satu transaksi milik pelanggan.
     * Di sini kita perlu memastikan pelanggan hanya bisa melihat transaksinya sendiri.
     */
    public function detailTransaksi(Order $order)
    {
        return view('pelanggan.detail_transaksi', compact('order'));
    }
}


