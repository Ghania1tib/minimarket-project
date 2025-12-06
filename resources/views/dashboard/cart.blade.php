@extends('layouts.app')

@section('content')
    <header class="header">
        <div class="top-bar">
            <div class="logo">
                <span>🛒</span>
                MINIMARKET-4 - Cart
            </div>
            <div class="nav-icons">
                <a href="/" class="nav-icon" title="Back to Shop">🏠</a>
            </div>
        </div>
    </header>

    <div class="content-section" style="text-align: center; padding: 4rem 2rem;">
        <div style="font-size: 4rem; margin-bottom: 1rem;">🛍️</div>
        <h2 style="color: var(--pink-dark); margin-bottom: 1rem;">Keranjang Belanja Kosong</h2>
        <p style="color: #666; margin-bottom: 2rem;">Belum ada produk di keranjang belanja Anda</p>
        <a href="/" style="background: linear-gradient(135deg, var(--pink-dark) 0%, var(--purple-dark) 100%); 
                          color: white; padding: 1rem 2rem; border-radius: 15px; text-decoration: none; 
                          font-weight: 600; display: inline-block;">
            Lanjutkan Belanja
        </a>
    </div>
@endsection