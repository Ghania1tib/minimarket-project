<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

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

public function redirectToGoogle(Request $request)
{
    try {
        // Simpan intended URL sebelum redirect ke Google
        if (!$request->session()->has('url.intended')) {
            $request->session()->put('url.intended', url()->previous());
        }

        return Socialite::driver('google')
            ->with([
                'prompt' => 'select_account consent', // Force account selection
                'access_type' => 'online',
                'include_granted_scopes' => 'true',
                'login_hint' => '', // Kosongkan agar selalu tampil pilihan
                'hd' => '*', // Allow any Google domain
            ])
            ->scopes(['email', 'profile']) // Scopes yang diperlukan
            ->stateless()
            ->redirect();

    } catch (\Exception $e) {
        \Log::error('Google Redirect Error: ' . $e->getMessage());
        return redirect('/login')->withErrors([
            'google' => 'Gagal mengarahkan ke Google. Silakan coba lagi.'
        ]);
    }
}

    public function handleGoogleCallback()
{
    try {
        // Dapatkan data user dari Google
        $googleUser = Socialite::driver('google')->stateless()->user();

        $email = $googleUser->email;
        $name = $googleUser->name;
        $googleId = $googleUser->getId();

        // Cari user berdasarkan email
        $user = User::where('email', $email)->first();

        if (!$user) {
            // Jika user belum terdaftar, buat user baru sebagai CUSTOMER
            $user = User::create([
                'nama_lengkap' => $name,
                'email' => $email,
                'google_id' => $googleId,
                'password' => Hash::make(uniqid()), // Password acak untuk user Google
                'role' => 'customer', // Default role sebagai customer
                'no_telepon' => null, // Bisa diisi nanti
                'alamat' => null, // Bisa diisi nanti
                'email_verified_at' => now(), // Email dari Google sudah terverifikasi
            ]);

            // Log aktivitas pendaftaran
            \Log::info('New user registered via Google', [
                'email' => $email,
                'id' => $user->id
            ]);

        } else {
            // Update Google ID jika belum ada
            if (empty($user->google_id)) {
                $user->update(['google_id' => $googleId]);
            }

            // Log aktivitas login
            \Log::info('User logged in via Google', [
                'email' => $email,
                'id' => $user->id
            ]);
        }

        // Login user
        Auth::login($user, true);

        // Regenerate session untuk keamanan
        request()->session()->regenerate();

        // Redirect ke dashboard berdasarkan role
        return $this->redirectToDashboard()->with('success', 'Login dengan Google berhasil!');

    } catch (\GuzzleHttp\Exception\ClientException $e) {
        // Tangani error dari Google API
        $response = $e->getResponse();
        $body = $response->getBody()->getContents();
        $errorData = json_decode($body, true);

        \Log::error('Google OAuth Error', [
            'error' => $errorData['error'] ?? 'Unknown',
            'description' => $errorData['error_description'] ?? 'No description'
        ]);

        return redirect('/login')->withErrors([
            'google' => 'Login dengan Google gagal. Silakan coba lagi atau gunakan email/password.'
        ]);

    } catch (\Exception $e) {
        // Tangani error umum
        \Log::error('Google Login Exception', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);

        return redirect('/login')->withErrors([
            'google' => 'Terjadi kesalahan. Silakan coba lagi.'
        ]);
    }
}
}
