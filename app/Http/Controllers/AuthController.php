<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showSignupForm()
    {
        // Ganti 'auth.signup' dengan lokasi view signup Anda yang sebenarnya
        return view('signup');
    }

    public function signup(Request $request)
    {
         $request->validate([
            'name'     => 'required|min:3|max:50',
            'email'    => ['required', 'email'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
        ], [
            'name.required' => 'Kolom nama wajib diisi.',
            'name.min' => 'Nama minimal 3 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',

            'password.min' => 'Kata sandi harus minimal 8 karakter.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.regex' => 'Kata sandi harus mengandung kombinasi huruf besar, huruf kecil, dan angka.',
        ]);
        $pageData['name']     = $request->name;
        $pageData['email']    = $request->email;
        $pageData['password'] = $request->password;
        return redirect()->route('home')->with('success', 'Pendaftaran berhasil! Selamat datang.');

    }
    public function showLoginForm()
    {
        // Mengembalikan view login (akan kita buat di langkah 3)
        return view('login');
    }

    /**
     * Memproses permintaan login.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            // Pesan error custom dalam Bahasa Indonesia
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // 2. Coba Proses Otentikasi
        if (Auth::attempt($credentials)) {
            // Regenerasi session untuk mencegah session fixation
            $request->session()->regenerate();

            // Redirect ke halaman dashboard atau home setelah berhasil login
            return redirect()->intended('/home')->with('success', 'Selamat datang kembali!');
        }

        // 3. Jika Otentikasi Gagal
        // Kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }
}
