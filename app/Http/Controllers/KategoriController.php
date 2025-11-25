<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori; // UBAH: dari Category ke Kategori
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function __construct()
    {
        // Langkah 4: Middleware auth untuk proteksi halaman
        $this->middleware('auth');
    }

    // Menampilkan daftar semua kategori
    public function index()
    {
        // Langkah 4: Cek authentication dan role
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        // PERBAIKAN: Gunakan model Kategori dan variabel yang konsisten
        $kategories = Kategori::withCount('products')->latest()->get();
        return view('kategori.index', compact('kategories'));
    }

    // Menampilkan formulir untuk membuat kategori baru
    public function create()
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        return view('kategori.create');
    }

    // Menyimpan kategori baru ke database
    public function store(Request $request)
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:categories', // PERBAIKAN: sesuaikan dengan nama tabel
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.',
        ]);

        // PERBAIKAN: Gunakan model Kategori
        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Menampilkan detail kategori
    public function show($id)
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        // PERBAIKAN: Gunakan model Kategori
        $kategori = Kategori::with('products')->findOrFail($id);
        return view('kategori.show', compact('kategori'));
    }

    // Form edit kategori
    public function edit($id)
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        // PERBAIKAN: Gunakan model Kategori
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    // Update kategori
    public function update(Request $request, $id)
    {
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        // PERBAIKAN: Gunakan model Kategori
        $kategori = Kategori::findOrFail($id);

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
        if (!Auth::check() || (!Auth::user()->isKasir() && !Auth::user()->isOwner() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized access.');
        }

        $kategori = Kategori::findOrFail($id);

        // Cek jika kategori memiliki produk
        if ($kategori->products()->count() > 0) {
            return redirect()->route('kategori.index')->with('error', 'Tidak dapat menghapus kategori yang masih memiliki produk!');
        }

        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', "Kategori berhasil dihapus!");
    }
}
