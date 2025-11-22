<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        // Langkah 4: Auth::check() untuk proteksi - SESUAI MODUL
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // PERBAIKAN: Gunakan user_id bukan pelanggan_id
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong');
        }

        $total = $cartItems->sum('subtotal');
        $user = Auth::user();

        return view('checkout.index', compact('cartItems', 'total', 'user'));
    }
}
