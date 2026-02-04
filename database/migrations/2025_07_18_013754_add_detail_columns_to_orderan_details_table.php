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
            $table->unsignedBigInteger('kd_gramasi')->nullable()->after('diskon');
            $table->unsignedBigInteger('kd_tinta')->nullable()->after('kd_gramasi');
            $table->unsignedBigInteger('kd_size_dewasa')->nullable()->after('kd_tinta');
            $table->unsignedBigInteger('kd_size_anak')->nullable()->after('kd_size_dewasa');
            $table->text('warna')->nullable()->after('kd_size_anak'); // disimpan sebagai "1,2,3"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orderan_details', function (Blueprint $table) {
            $table->dropColumn([
                'kd_gramasi',
                'kd_tinta',
                'kd_size_dewasa',
                'kd_size_anak',
                'warna'
            ]);
        });
    }
};
