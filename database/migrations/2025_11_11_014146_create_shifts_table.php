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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id(); // Ini adalah shift_id
            $table->foreignId('user_id')->constrained('users');
            $table->decimal('modal_awal', 10, 2);
            $table->decimal('total_penjualan_sistem', 10, 2)->nullable();
            $table->decimal('total_tunai_sistem', 10, 2)->nullable();
            $table->decimal('total_debit_sistem', 10, 2)->nullable();
            $table->decimal('total_qris_sistem', 10, 2)->nullable();
            $table->decimal('uang_fisik_di_laci', 10, 2)->nullable();
            $table->decimal('selisih', 10, 2)->nullable();
            $table->timestamp('waktu_mulai')->useCurrent();
            $table->timestamp('waktu_selesai')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_kas');
    }
};
