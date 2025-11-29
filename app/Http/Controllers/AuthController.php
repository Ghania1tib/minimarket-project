<?php
namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showSignupForm()
    {
        // Langkah 4: Cek jika user sudah login, redirect ke dashboard
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }
        return view('signup');
    }

    public function signup(Request $request)
    {
        // Auth::check jika user sudah login, redirect ke dashboard
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }

        $request->validate([
            'nama_lengkap' => 'required|min:3|max:50',
            'email'        => ['required', 'email', 'unique:users'],
            'password'     => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
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

        // Hash::make() untuk encrypt password
        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'role'         => 'customer',
            'no_telepon'   => $request->no_telepon,
            'alamat'       => $request->alamat,
        ]);

        // Auth::login() untuk login user
        Auth::login($user);

        return $this->redirectToDashboard()->with('success', 'Pendaftaran berhasil! Selamat datang.');
    }

    public function showLoginForm()
    {
        // Langkah 4: Cek jika user sudah login, redirect ke dashboard
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }
        return view('login');
    }

    public function login(Request $request)
    {
        // Auth::Check jika user sudah login, redirect ke dashboard
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }

        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        //Pengecekan Email & Password menggunakan Hash::check()
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return $this->redirectToDashboard()->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        //Auth::logout() untuk logout
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logout berhasil!');
    }

    private function redirectToDashboard()
    {
        $user = Auth::user();
        if ($user->isOwner() || $user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isKasir()) {
            return redirect()->route('dashboard.staff');
        } elseif ($user->isCustomer()) {
            return redirect()->route('pelanggan.dashboard');
        }
        return redirect('/');
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $email_user = $googleUser->email;
        dd($email_user);
    }
}
