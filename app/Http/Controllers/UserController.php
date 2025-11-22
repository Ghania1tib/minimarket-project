<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        // Langkah 4: Middleware auth untuk proteksi halaman
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Langkah 4: Cek authentication dan role
        if (!Auth::check() || (!Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        $query = User::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_telepon', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('user.index', compact('users'));
    }

    public function create()
    {
        if (!Auth::check() || (!Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        return view('user.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check() || (!Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'nama_lengkap' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:owner,admin,kasir,customer',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255'
        ]);

        // Hash::make() untuk encrypt password - SESUAI MODUL
        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        if (!Auth::check() || (!Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!Auth::check() || (!Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'nama_lengkap' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:owner,admin,kasir,customer',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255'
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'role' => $request->role,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat
        ];

        if ($request->password) {
            // Hash::make() untuk encrypt password baru - SESUAI MODUL
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'User berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        if (!Auth::check() || (!Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('user.index')->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus!');
    }
}
