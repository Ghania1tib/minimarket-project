<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        return view('pelanggan.checkout');
    }

    public function proses(Request $request)
    {
        // Logic untuk memproses checkout
        // Redirect ke halaman pesanan detail
        return redirect()->route('pelanggan.pesanan.detail', 1)
                        ->with('success', 'Pesanan berhasil diproses');
    }
}
