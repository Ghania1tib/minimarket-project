<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Ambil semua pengguna dari database.
        $users = User::all();
        // Tampilkan view 'users.index' dan kirim data pengguna.
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Buat pengguna baru di database.
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Arahkan kembali ke halaman index dengan pesan sukses.
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        // Tampilkan view 'users.show' dengan data pengguna.
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $user = User::findOrFail($id);
        // Tampilkan view 'users.edit' dengan data pengguna.
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Cari pengguna yang akan diperbarui.
        $user = User::findOrFail($id);

        // Validasi data yang masuk.
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Perbarui data pengguna.
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Arahkan kembali dengan pesan sukses.
        return redirect()->route('users.show', $user->id)->with('success', 'Data pengguna berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari pengguna yang akan dihapus.
        $user = User::findOrFail($id);
        // Hapus pengguna tersebut.
        $user->delete();

        // Arahkan kembali ke halaman index dengan pesan sukses.
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}
