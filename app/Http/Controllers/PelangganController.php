<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    public function __construct()
    {
        // Middleware auth untuk proteksi halaman pelanggan
        $this->middleware('auth');
    }

    public function dashboard()
    {
        // Auth::user() untuk mendapatkan data user yang login
        $user = Auth::user();
        $totalOrders = Order::where('user_id', $user->id)->count();
        $pendingOrders = Order::where('user_id', $user->id)
                            ->whereIn('status_pesanan', ['menunggu_pembayaran', 'diproses'])
                            ->count();
        $cartCount = Cart::where('user_id', $user->id)->count();

        $orders = Order::where('user_id', $user->id)
                      ->orderBy('created_at', 'desc')
                      ->take(5)
                      ->get();

        return view('pelanggan.dashboard', compact(
            'user',
            'totalOrders',
            'pendingOrders',
            'cartCount',
            'orders'
        ));
    }

    public function profil()
    {
        $user = Auth::user();
        $totalOrders = Order::where('user_id', $user->id)->count();

        return view('pelanggan.profil', compact('user', 'totalOrders'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        // Validasi data
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'alamat' => 'required|string|max:1000',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'nama_lengkap.max' => 'Nama lengkap maksimal 255 karakter',
            'no_telepon.required' => 'Nomor telepon wajib diisi',
            'no_telepon.max' => 'Nomor telepon maksimal 20 karakter',
            'no_telepon.regex' => 'Format nomor telepon tidak valid',
            'alamat.required' => 'Alamat wajib diisi',
            'alamat.max' => 'Alamat maksimal 1000 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            // Update data user
            $updateData = [
                'nama_lengkap' => $request->nama_lengkap,
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
            ];

            if (empty($user->nama_lengkap) && !empty($user->name)) {
                $updateData['name'] = $request->nama_lengkap;
            }

            $user->update($updateData);

            return redirect()->route('pelanggan.profil')
                           ->with('success', 'Profil berhasil diperbarui');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat mengupdate profil: ' . $e->getMessage())
                           ->withInput();
        }
    }

    // Method untuk mengubah password
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        // Hash::check() untuk verifikasi password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                           ->with('error', 'Password saat ini tidak sesuai');
        }

        // Hash::make() untuk encrypt password baru
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('pelanggan.profil')
                       ->with('success', 'Password berhasil diubah');
    }
}
