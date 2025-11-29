<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixOrdersTableStructure extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Hapus kolom yang tidak diperlukan atau typo
            if (Schema::hasColumn('orders', 'metode_penibayaran')) {
                $table->dropColumn('metode_penibayaran');
            }
            if (Schema::hasColumn('orders', 'buki_penibayaran')) {
                $table->dropColumn('buki_penibayaran');
            }
            if (Schema::hasColumn('orders', 'status_penibayaran')) {
                $table->dropColumn('status_penibayaran');
            }
            if (Schema::hasColumn('orders', 'tjpe_pesanan')) {
                $table->dropColumn('tjpe_pesanan');
            }

            // Tambahkan kolom yang diperlukan dengan nama yang benar
            if (!Schema::hasColumn('orders', 'metode_pembayaran')) {
                $table->string('metode_pembayaran')->default('tunai')->after('shipping_cost');
            }
            if (!Schema::hasColumn('orders', 'bukti_pembayaran')) {
                $table->string('bukti_pembayaran')->nullable()->after('nomor_rekening');
            }
            if (!Schema::hasColumn('orders', 'status_pembayaran')) {
                $table->string('status_pembayaran')->default('menunggu_pembayaran')->after('bukti_pembayaran');
            }
            if (!Schema::hasColumn('orders', 'tipe_pesanan')) {
                $table->string('tipe_pesanan')->default('website')->after('status_pembayaran');
            }
            if (!Schema::hasColumn('orders', 'status_pesanan')) {
                $table->string('status_pesanan')->default('pending')->after('tipe_pesanan');
            }

            // Tambahkan kolom baru untuk informasi pengiriman
            if (!Schema::hasColumn('orders', 'nama_lengkap')) {
                $table->string('nama_lengkap')->nullable()->after('status_pesanan');
            }
            if (!Schema::hasColumn('orders', 'no_telepon')) {
                $table->string('no_telepon')->nullable()->after('nama_lengkap');
            }
            if (!Schema::hasColumn('orders', 'alamat')) {
                $table->text('alamat')->nullable()->after('no_telepon');
            }
            if (!Schema::hasColumn('orders', 'kota')) {
                $table->string('kota')->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('orders', 'metode_pengiriman')) {
                $table->string('metode_pengiriman')->nullable()->after('kota');
            }
            if (!Schema::hasColumn('orders', 'catatan')) {
                $table->text('catatan')->nullable()->after('metode_pengiriman');
            }

            // Perbaiki tipe data shipping_cost
            $table->decimal('shipping_cost', 10, 2)->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Rollback changes if needed
            $table->dropColumn([
                'metode_pembayaran',
                'bukti_pembayaran',
                'status_pembayaran',
                'tipe_pesanan',
                'status_pesanan',
                'nama_lengkap',
                'no_telepon',
                'alamat',
                'kota',
                'metode_pengiriman',
                'catatan'
            ]);
        });
    }
}
