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
    Schema::create('stock_history', function (Blueprint $table) {
        $table->id(); // Ini adalah history_id
        $table->foreignId('product_id')->constrained('products');
        $table->foreignId('user_id')->nullable()->constrained('users');
        $table->foreignId('order_id')->nullable()->constrained('orders');
        $table->integer('jumlah_perubahan');
        $table->integer('stok_sebelum');
        $table->integer('stok_sesudah');
        $table->timestamp('tanggal_perubahan')->useCurrent();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_history');
    }
};
