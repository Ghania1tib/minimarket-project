<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return "Menampilkan produk";
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return "Form untuk menambah produk baru";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return "Menyimpan produk baru ke database";
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        return "Anda mengakses produk " . $slug;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return "Form untuk mengedit produk dengan ID: " . $id;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return "Memperbarui data produk dengan ID: " . $id;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    // app/Http/Controllers/ProdukController.php

// ... (tambahkan di dalam class ProdukController)

    public function search(Request $request)
    {
        // Ambil keyword dari input form
        $keyword = $request->input('keyword');

        // Validasi jika keyword tidak kosong
        if (! $keyword) {
            return redirect()->back();
        }

        // Cari produk di database berdasarkan nama yang mirip dengan keyword
        // Ganti 'nama_produk' dengan nama kolom produk di database Anda
        $produks = Produk::where('nama_produk', 'LIKE', "%{$keyword}%")->paginate(12);

        // Kirim data hasil pencarian ke sebuah view
        return view('produk.search_results', [
            'produks' => $produks,
            'keyword' => $keyword,
        ]);
    }
}
