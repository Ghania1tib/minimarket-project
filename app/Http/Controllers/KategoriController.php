<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    // Menampilkan daftar semua kategori
    public function index()
{
    // Ambil semua data kategori dari database
    $kategori = Kategori::all();

    // Kirim data ke view
    return view('kategori.index', compact('kategori'));
}

    // Menampilkan formulir untuk membuat kategori baru
    public function create()
    {
        return view('kategori.create');
    }

    // Menyimpan kategori baru ke database
    public function store(Request $request)
    {
        Kategori::create([
            'nama' => $request->nama,
            'gambar' => $request->gambar,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Menampilkan detail kategori
    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.show', compact('kategori'));
    }

    // Form edit kategori
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    // Update kategori
    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama' => $request->nama,
            'gambar' => $request->gambar,
        ]);

        return redirect()->route('kategori.index')->with('success', "Kategori berhasil diperbarui!");
    }

    // Hapus kategori
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', "Kategori berhasil dihapus!");
    }
}
