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
        Schema::table('keuangans', function (Blueprint $table) {
            $table->string('sumber')->nullable()->after('jumlah');
            $table->unsignedBigInteger('sumber_id')->nullable()->after('sumber');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keuangans', function (Blueprint $table) {
            $table->dropColumn('sumber');
            $table->dropColumn('sumber_id');
        });
    }
};
