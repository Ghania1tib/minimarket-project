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
        Schema::create('promos', function (Blueprint $table) {
            $table->id(); // Ini adalah promo_id
            $table->string('nama_promo', 100);
            $table->enum('jenis_diskon', ['persen', 'tetap']);
            $table->decimal('nilai_diskon', 10, 2);
            $table->foreignId('target_product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->foreignId('target_category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_berakhir');
            $table->enum('status', ['aktif', 'menjelang', 'expired', 'nonaktif']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
