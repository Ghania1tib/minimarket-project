@extends('layouts.app')

@section('content')
<div class="section" style="max-width: 400px; margin: 2rem auto;">
    <div style="text-align: center; margin-bottom: 2rem;">
        <i class="fas fa-user-circle" style="font-size: 4rem; color: var(--purple-dark); margin-bottom: 1rem;"></i>
        <h2 style="color: var(--purple-dark);">Login ke Akun Anda</h2>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">Email</label>
            <input type="email" name="email" required 
                   style="width: 100%; padding: 12px; border: 2px solid var(--pink-pastel); border-radius: 10px; font-size: 1rem;"
                   placeholder="Masukkan email Anda">
            @error('email')
                <span style="color: #ff6b6b; font-size: 0.9rem;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">Password</label>
            <input type="password" name="password" required 
                   style="width: 100%; padding: 12px; border: 2px solid var(--pink-pastel); border-radius: 10px; font-size: 1rem;"
                   placeholder="Masukkan password Anda">
            @error('password')
                <span style="color: #ff6b6b; font-size: 0.9rem;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" 
                style="width: 100%; padding: 12px; background: linear-gradient(135deg, var(--pink-dark), var(--purple-dark)); color: white; border: none; border-radius: 10px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
            <i class="fas fa-sign-in-alt"></i> Login
        </button>

        <div style="text-align: center; margin-top: 1rem;">
            <span style="color: var(--text-medium);">Belum punya akun? </span>
            <a href="{{ route('register') }}" style="color: var(--purple-dark); font-weight: 600; text-decoration: none;">Daftar di sini</a>
        </div>
    </form>
</div>
@endsection