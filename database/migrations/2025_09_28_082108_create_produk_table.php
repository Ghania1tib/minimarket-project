<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id(); // Kolom ID (wajib ada)
            $table->string('nama_produk');
            $table->integer('harga');
            $table->integer('stok');
            $table->text('deskripsi')->nullable();

            // Ini contoh jika produk punya relasi ke tabel kategori
            $table->foreignId('kategori_id')->constrained('kategori');

            $table->timestamps(); // Kolom created_at & updated_at
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};


