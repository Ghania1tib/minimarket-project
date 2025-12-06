@extends('layouts.app')

@section('content')
<div class="section" style="max-width: 400px; margin: 2rem auto;">
    <div style="text-align: center; margin-bottom: 2rem;">
        <i class="fas fa-user-plus" style="font-size: 4rem; color: var(--purple-dark); margin-bottom: 1rem;"></i>
        <h2 style="color: var(--purple-dark);">Daftar Akun Baru</h2>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">Nama Lengkap</label>
            <input type="text" name="name" required 
                   style="width: 100%; padding: 12px; border: 2px solid var(--pink-pastel); border-radius: 10px; font-size: 1rem;"
                   placeholder="Masukkan nama lengkap Anda">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">Email</label>
            <input type="email" name="email" required 
                   style="width: 100%; padding: 12px; border: 2px solid var(--pink-pastel); border-radius: 10px; font-size: 1rem;"
                   placeholder="Masukkan email Anda">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">No. Telepon</label>
            <input type="tel" name="phone" required 
                   style="width: 100%; padding: 12px; border: 2px solid var(--pink-pastel); border-radius: 10px; font-size: 1rem;"
                   placeholder="Masukkan nomor telepon">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">Alamat</label>
            <textarea name="address" required 
                      style="width: 100%; padding: 12px; border: 2px solid var(--pink-pastel); border-radius: 10px; font-size: 1rem; min-height: 80px;"
                      placeholder="Masukkan alamat lengkap"></textarea>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">Password</label>
            <input type="password" name="password" required 
                   style="width: 100%; padding: 12px; border: 2px solid var(--pink-pastel); border-radius: 10px; font-size: 1rem;"
                   placeholder="Masukkan password">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required 
                   style="width: 100%; padding: 12px; border: 2px solid var(--pink-pastel); border-radius: 10px; font-size: 1rem;"
                   placeholder="Konfirmasi password">
        </div>

        <button type="submit" 
                style="width: 100%; padding: 12px; background: linear-gradient(135deg, var(--pink-dark), var(--purple-dark)); color: white; border: none; border-radius: 10px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
            <i class="fas fa-user-plus"></i> Daftar
        </button>

        <div style="text-align: center; margin-top: 1rem;">
            <span style="color: var(--text-medium);">Sudah punya akun? </span>
            <a href="{{ route('login') }}" style="color: var(--purple-dark); font-weight: 600; text-decoration: none;">Login di sini</a>
        </div>
    </form>
</div>
@endsection