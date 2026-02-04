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
            $table->integer('subtotal_kotor')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orderan_details', function (Blueprint $table) {
            $table->dropColumn('subtotal_kotor');
        });
    }
};
