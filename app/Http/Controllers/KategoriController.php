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
            'icon_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.',
            'icon_url.image' => 'File harus berupa gambar.',
            'icon_url.mimes' => 'Gambar harus berformat: jpeg, png, jpg, gif, svg.',
            'icon_url.max' => 'Ukuran gambar maksimal 2MB.'
        ]);

        $iconUrl = null;
        if ($request->hasFile('icon_url')) {
            $iconUrl = $request->file('icon_url')->store('categories', 'public');
        }

        Category::create([
            'nama_kategori' => $request->nama_kategori,
            'icon_url' => $iconUrl
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
            'icon_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.',
            'icon_url.image' => 'File harus berupa gambar.',
            'icon_url.mimes' => 'Gambar harus berformat: jpeg, png, jpg, gif, svg.',
            'icon_url.max' => 'Ukuran gambar maksimal 2MB.'
        ]);

        $iconUrl = $kategori->icon_url;
        if ($request->hasFile('icon_url')) {
            // Hapus icon lama jika ada
            if ($iconUrl) {
                Storage::disk('public')->delete($iconUrl);
            }
            $iconUrl = $request->file('icon_url')->store('categories', 'public');
        }

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'icon_url' => $iconUrl
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

        // Hapus icon jika ada
        if ($kategori->icon_url) {
            Storage::disk('public')->delete($kategori->icon_url);
        }

        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', "Kategori berhasil dihapus!");
    }
}
