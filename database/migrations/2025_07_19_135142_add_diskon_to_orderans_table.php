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
            $table->decimal('diskon', 15, 2)->default(0)->after('harga_total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orderans', function (Blueprint $table) {
            $table->dropColumn('diskon');
        });
    }
};
