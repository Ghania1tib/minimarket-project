<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    // Menampilkan daftar semua kategori
    public function index()
    {
        // Cek role untuk akses
        $user = Auth::user();
        if (!$user->isKasir() && !$user->isOwner() && !$user->isAdmin()) {
            return redirect('/')->with('error', 'Akses ditolak! Hanya untuk kasir, owner, dan admin.');
        }

        $kategories = Category::withCount('products')->latest()->get();
        return view('kategori.index', compact('kategories'));
    }

    // Menampilkan formulir untuk membuat kategori baru
    public function create()
    {
        $user = Auth::user();
        if (!$user->isKasir() && !$user->isOwner() && !$user->isAdmin()) {
            return redirect('/')->with('error', 'Akses ditolak! Hanya untuk kasir, owner, dan admin.');
        }

        return view('kategori.create');
    }

    // Menyimpan kategori baru ke database
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->isKasir() && !$user->isOwner() && !$user->isAdmin()) {
            return redirect('/')->with('error', 'Akses ditolak! Hanya untuk kasir, owner, dan admin.');
        }

        $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:categories',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.',
        ]);

        Category::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Menampilkan detail kategori
    public function show($id)
    {
        $user = Auth::user();
        if (!$user->isKasir() && !$user->isOwner() && !$user->isAdmin()) {
            return redirect('/')->with('error', 'Akses ditolak! Hanya untuk kasir, owner, dan admin.');
        }

        $kategori = Category::with('products')->findOrFail($id);
        return view('kategori.show', compact('kategori'));
    }

    // Form edit kategori
    public function edit($id)
    {
        $user = Auth::user();
        if (!$user->isKasir() && !$user->isOwner() && !$user->isAdmin()) {
            return redirect('/')->with('error', 'Akses ditolak! Hanya untuk kasir, owner, dan admin.');
        }

        $kategori = Category::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    // Update kategori
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isKasir() && !$user->isOwner() && !$user->isAdmin()) {
            return redirect('/')->with('error', 'Akses ditolak! Hanya untuk kasir, owner, dan admin.');
        }

        $kategori = Category::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:categories,nama_kategori,' . $id,
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.',
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('kategori.index')->with('success', "Kategori berhasil diperbarui!");
    }

    // Hapus kategori
    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->isKasir() && !$user->isOwner() && !$user->isAdmin()) {
            return redirect('/')->with('error', 'Akses ditolak! Hanya untuk kasir, owner, dan admin.');
        }

        $kategori = Category::findOrFail($id);

        // Cek jika kategori memiliki produk
        if ($kategori->products()->count() > 0) {
            return redirect()->route('kategori.index')->with('error', 'Tidak dapat menghapus kategori yang masih memiliki produk!');
        }
        
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', "Kategori berhasil dihapus!");
    }
}
