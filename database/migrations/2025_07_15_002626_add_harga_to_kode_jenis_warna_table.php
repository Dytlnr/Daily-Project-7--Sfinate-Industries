<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('kode_jenis_warna', 'harga')) {
            Schema::table('kode_jenis_warna', function (Blueprint $table) {
                $table->integer('harga')->default(0)->after('nama');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('kode_jenis_warna', 'harga')) {
            Schema::table('kode_jenis_warna', function (Blueprint $table) {
                $table->dropColumn('harga');
            });
        }
    }
};
