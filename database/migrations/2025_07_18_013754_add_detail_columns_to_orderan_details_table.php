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
        if (! Schema::hasColumn('orderan_details', 'kd_gramasi')) {
            Schema::table('orderan_details', function (Blueprint $table) {
                $table->unsignedBigInteger('kd_gramasi')->nullable()->after('diskon');
            });
        }

        if (! Schema::hasColumn('orderan_details', 'kd_tinta')) {
            Schema::table('orderan_details', function (Blueprint $table) {
                $table->unsignedBigInteger('kd_tinta')->nullable()->after('kd_gramasi');
            });
        }

        if (! Schema::hasColumn('orderan_details', 'kd_size_dewasa')) {
            Schema::table('orderan_details', function (Blueprint $table) {
                $table->unsignedBigInteger('kd_size_dewasa')->nullable()->after('kd_tinta');
            });
        }

        if (! Schema::hasColumn('orderan_details', 'kd_size_anak')) {
            Schema::table('orderan_details', function (Blueprint $table) {
                $table->unsignedBigInteger('kd_size_anak')->nullable()->after('kd_size_dewasa');
            });
        }

        if (! Schema::hasColumn('orderan_details', 'warna')) {
            Schema::table('orderan_details', function (Blueprint $table) {
                $table->text('warna')->nullable()->after('kd_size_anak'); // disimpan sebagai "1,2,3"
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('orderan_details', 'kd_gramasi')) {
            Schema::table('orderan_details', function (Blueprint $table) {
                $table->dropColumn('kd_gramasi');
            });
        }

        if (Schema::hasColumn('orderan_details', 'kd_tinta')) {
            Schema::table('orderan_details', function (Blueprint $table) {
                $table->dropColumn('kd_tinta');
            });
        }

        if (Schema::hasColumn('orderan_details', 'kd_size_dewasa')) {
            Schema::table('orderan_details', function (Blueprint $table) {
                $table->dropColumn('kd_size_dewasa');
            });
        }

        if (Schema::hasColumn('orderan_details', 'kd_size_anak')) {
            Schema::table('orderan_details', function (Blueprint $table) {
                $table->dropColumn('kd_size_anak');
            });
        }

        if (Schema::hasColumn('orderan_details', 'warna')) {
            Schema::table('orderan_details', function (Blueprint $table) {
                $table->dropColumn('warna');
            });
        }
    }
};
