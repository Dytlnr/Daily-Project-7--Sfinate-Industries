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
        Schema::table('orderans', function (Blueprint $table) {
            $table->string('nama_pelanggan')->after('kode_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orderans', function (Blueprint $table) {
            $table->dropColumn('nama_pelanggan');
        });
    }
};
