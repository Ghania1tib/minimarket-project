<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('shifts', function (Blueprint $table) {
            // Ubah nama kolom yang typo
            if (Schema::hasColumn('shifts', 'total_perjualan_sistem')) {
                $table->renameColumn('total_perjualan_sistem', 'total_penjualan_sistem');
            }

            if (Schema::hasColumn('shifts', 'total_tunal_sistem')) {
                $table->renameColumn('total_tunal_sistem', 'total_tunai_sistem');
            }

            if (Schema::hasColumn('shifts', 'selfish')) {
                $table->renameColumn('selfish', 'selisih');
            }

            if (Schema::hasColumn('shifts', 'uang_fisik_di_laci')) {
                $table->renameColumn('uang_fisik_di_laci', 'uang_fisik_di_kasir');
            }

            // Tambah kolom yang missing
            if (!Schema::hasColumn('shifts', 'status')) {
                $table->string('status')->default('active')->after('waktu_selesai');
            }

            if (!Schema::hasColumn('shifts', 'catatan')) {
                $table->text('catatan')->nullable()->after('selisih');
            }

            // Update kolom yang nullable menjadi default 0
            $table->decimal('total_tunai_sistem', 15, 2)->default(0)->change();
            $table->decimal('total_debit_sistem', 15, 2)->default(0)->change();
            $table->decimal('total_qris_sistem', 15, 2)->default(0)->change();
            $table->decimal('uang_fisik_di_kasir', 15, 2)->default(0)->change();
            $table->decimal('selisih', 15, 2)->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('shifts', function (Blueprint $table) {
            // Rollback rename
            if (Schema::hasColumn('shifts', 'total_penjualan_sistem')) {
                $table->renameColumn('total_penjualan_sistem', 'total_perjualan_sistem');
            }

            if (Schema::hasColumn('shifts', 'total_tunai_sistem')) {
                $table->renameColumn('total_tunai_sistem', 'total_tunal_sistem');
            }

            if (Schema::hasColumn('shifts', 'selisih')) {
                $table->renameColumn('selisih', 'selfish');
            }

            if (Schema::hasColumn('shifts', 'uang_fisik_di_kasir')) {
                $table->renameColumn('uang_fisik_di_kasir', 'uang_fisik_di_laci');
            }

            // Hapus kolom yang ditambahkan
            if (Schema::hasColumn('shifts', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('shifts', 'catatan')) {
                $table->dropColumn('catatan');
            }
        });
    }
};
