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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Ini adalah order_id
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('set null');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('total_diskon', 10, 2)->default(0);
            $table->decimal('total_bayar', 10, 2);
            $table->enum('metode_pembayaran', ['tunai', 'debit_kredit', 'qris_ewallet']);
            $table->enum('tipe_pesanan', ['pos', 'website']);
            $table->enum('status_pesanan', ['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])->default('pending');
            $table->timestamps(); // created_at akan menjadi tanggal_pesanan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
