<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            'name.required'     => 'Kolom nama wajib diisi.',
            'name.min'          => 'Nama minimal 3 karakter.',
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',

            'password.min'      => 'Kata sandi harus minimal 8 karakter.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.regex'    => 'Kata sandi harus mengandung kombinasi huruf besar, huruf kecil, dan angka.',
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

        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $is_valid_input = ! empty($credentials['email']) && ! empty($credentials['password']);

        if ($is_valid_input) {
            $request->session()->regenerate();
            $email = strtolower($credentials['email']);
            if ($email === 'admin@minimarket.com') {
                return redirect()->route('dashboard.owner')->with('success', 'Selamat datang, Owner!');
            } elseif ($email === 'kasir@minimarket.com') {
                return redirect()->route('dashboard.staff')->with('success', 'Selamat datang, Staff Kasir!');
            } elseif ($email === 'pelanggan@minimarket.com') {
                return redirect()->route('pelanggan.dashboard')->with('success', 'Selamat berbelanja!');
            } else {
                return redirect()->route('home')->with('success', 'Selamat datang kembali!');
            }
        }
    }
}
