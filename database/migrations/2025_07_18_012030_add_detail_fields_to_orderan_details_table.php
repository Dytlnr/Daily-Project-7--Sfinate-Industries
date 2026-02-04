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
        Schema::table('orderan_details', function (Blueprint $table) {
            $table->string('gramasi')->nullable();   // dari kd_gramasi (nama)
            $table->string('ukuran')->nullable();    // dari ukuran anak / dewasa
            $table->string('tinta')->nullable();     // dari kd_tinta (nama)
            $table->string('warna')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orderan_details', function (Blueprint $table) {
            $table->dropColumn(['gramasi', 'ukuran', 'tinta', 'warna']);
        });
    }
};
