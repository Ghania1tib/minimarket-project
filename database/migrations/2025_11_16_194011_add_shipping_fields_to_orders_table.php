<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShippingFieldsToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('nama_lengkap')->nullable();
            $table->string('no_telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kota')->nullable();
            $table->string('kode_pos')->nullable();
            $table->decimal('biaya_pengiriman', 10, 2)->default(0);
            $table->text('catatan')->nullable();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'nama_lengkap',
                'no_telepon',
                'alamat',
                'kota',
                'kode_pos',
                'biaya_pengiriman',
                'catatan'
            ]);
        });
    }
}
