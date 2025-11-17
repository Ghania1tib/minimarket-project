<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('products')->onDelete('cascade');
            $table->integer('jumlah')->default(1);
            $table->decimal('harga_satuan', 10, 2);
            $table->timestamps();

            $table->unique(['pelanggan_id', 'produk_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
