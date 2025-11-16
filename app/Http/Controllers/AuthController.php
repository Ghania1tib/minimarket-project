<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showSignupForm()
    {
        return view('signup');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|min:3|max:50',
            'email'        => ['required', 'email', 'unique:users'],
            'password'     => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/', // harus mengandung huruf kecil
                'regex:/[A-Z]/', // harus mengandung huruf besar
                'regex:/[0-9]/', // harus mengandung angka
            ],
            'no_telepon'   => 'required|string|max:20',
            'alamat'       => 'required|string|max:255',
        ], [
            'nama_lengkap.required' => 'Kolom nama lengkap wajib diisi.',
            'nama_lengkap.min'      => 'Nama minimal 3 karakter.',
            'nama_lengkap.max'      => 'Nama maksimal 50 karakter.',
            'email.required'        => 'Alamat email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email sudah terdaftar.',
            'password.required'     => 'Kata sandi wajib diisi.',
            'password.min'          => 'Kata sandi harus minimal 8 karakter.',
            'password.regex'        => 'Kata sandi harus mengandung kombinasi huruf besar, huruf kecil, dan angka.',
            'no_telepon.required'   => 'Nomor telepon wajib diisi.',
            'no_telepon.max'        => 'Nomor telepon maksimal 20 karakter.',
            'alamat.required'       => 'Alamat wajib diisi.',
            'alamat.max'            => 'Alamat maksimal 255 karakter.',
        ]);

        // Buat user baru dengan role customer
        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'role'         => 'customer',
            'no_telepon'   => $request->no_telepon,
            'alamat'       => $request->alamat,
        ]);

        // Login user setelah registrasi
        Auth::login($user);

        return redirect()->route('pelanggan.dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang.');
    }

    public function showLoginForm()
    {
        return view('login');
    }

   public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ], [
        'email.required'    => 'Alamat email wajib diisi.',
        'email.email'       => 'Format email tidak valid.',
        'password.required' => 'Kata sandi wajib diisi.',
    ]);

    // Coba login dengan credentials
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $user = Auth::user();

        // Redirect berdasarkan role
        if ($user->isOwner() || $user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, Admin!');
        } elseif ($user->isKasir()) {
            return redirect()->route('dashboard.staff')->with('success', 'Selamat datang, Staff Kasir!');
        } elseif ($user->isCustomer()) {
            return redirect()->route('pelanggan.dashboard')->with('success', 'Selamat berbelanja!');
        }
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logout berhasil!');
    }
}
