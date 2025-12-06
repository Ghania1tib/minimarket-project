<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGoogleFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom untuk Google OAuth
            $table->string('google_id')->nullable()->after('password');
            $table->string('foto_profil')->nullable()->after('google_id');
            $table->string('registered_via')->nullable()->after('foto_profil')->comment('google, manual, etc');

            // Pastikan email_verified_at ada
            if (!Schema::hasColumn('users', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'foto_profil', 'registered_via']);
        });
    }
}
