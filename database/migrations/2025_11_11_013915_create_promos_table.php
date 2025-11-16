<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('kode_promo')->unique();
            $table->string('nama_promo');
            $table->text('deskripsi')->nullable();
            $table->enum('jenis_promo', ['diskon_persentase', 'diskon_nominal']);
            $table->decimal('nilai_promo', 10, 2);
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->integer('kuota')->nullable();
            $table->integer('digunakan')->default(0);
            $table->boolean('status')->default(true);
            $table->integer('minimal_pembelian')->default(0);
            $table->integer('maksimal_diskon')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('promos');
    }
};
