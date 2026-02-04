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
        Schema::table('barangs', function (Blueprint $table) {
            $table->string('warna')->nullable();
            $table->string('ukuran')->nullable();
            $table->string('jenis_kaos')->nullable();
            $table->decimal('harga_modal', 12, 2)->nullable();
            $table->decimal('harga_jual', 12, 2)->nullable();
            $table->decimal('harga_diskon', 12, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn(['warna', 'ukuran', 'jenis_kaos', 'harga_modal', 'harga_jual', 'harga_diskon']);
        });
    }
};
