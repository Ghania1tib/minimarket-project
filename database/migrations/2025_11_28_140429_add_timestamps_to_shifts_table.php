<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('shifts', function (Blueprint $table) {
            // Tambahkan timestamps jika belum ada
            if (!Schema::hasColumn('shifts', 'created_at')) {
                $table->timestamp('created_at')->nullable()->after('catatan');
            }
            if (!Schema::hasColumn('shifts', 'updated_at')) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
            }

            // Pastikan kolom status ada
            if (!Schema::hasColumn('shifts', 'status')) {
                $table->string('status')->default('active')->after('waktu_selesai');
            }

            // Pastikan kolom catatan ada
            if (!Schema::hasColumn('shifts', 'catatan')) {
                $table->text('catatan')->nullable()->after('selisih');
            }
        });
    }

    public function down()
    {
        Schema::table('shifts', function (Blueprint $table) {
            if (Schema::hasColumn('shifts', 'created_at')) {
                $table->dropColumn('created_at');
            }
            if (Schema::hasColumn('shifts', 'updated_at')) {
                $table->dropColumn('updated_at');
            }
            if (Schema::hasColumn('shifts', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('shifts', 'catatan')) {
                $table->dropColumn('catatan');
            }
        });
    }
};
