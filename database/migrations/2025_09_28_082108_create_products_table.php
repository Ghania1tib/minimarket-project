<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Ini adalah product_id
            $table->foreignId('category_id')->constrained('categories');
            $table->string('nama_produk', 150);
            $table->string('barcode', 50)->unique()->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('gambar_url')->nullable();
            $table->decimal('harga_beli', 10, 2);
            $table->decimal('harga_jual', 10, 2);
            $table->integer('stok');
            $table->integer('stok_kritis')->default(5);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
