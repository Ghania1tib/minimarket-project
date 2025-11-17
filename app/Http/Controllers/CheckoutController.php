<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'pelanggan') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai pelanggan');
        }

        $cartItems = Cart::with('product')
            ->where('pelanggan_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong');
        }

        $total = $cartItems->sum('subtotal');
        $user = Auth::user();

        return view('checkout.index', compact('cartItems', 'total', 'user'));
    }
}
