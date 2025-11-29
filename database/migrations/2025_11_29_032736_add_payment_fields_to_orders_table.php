<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('nomor_rekening')->nullable()->after('metode_pembayaran');
            $table->string('bukti_pembayaran')->nullable()->after('nomor_rekening');
            $table->string('status_pembayaran')->default('menunggu_pembayaran')->after('bukti_pembayaran');
            $table->string('order_number')->nullable()->after('id');
            $table->decimal('shipping_cost', 12, 2)->default(0)->after('total_bayar');
            $table->text('catatan')->nullable()->after('alamat_pengiriman');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'nomor_rekening',
                'bukti_pembayaran',
                'status_pembayaran',
                'order_number',
                'shipping_cost',
                'catatan'
            ]);
        });
    }
};
