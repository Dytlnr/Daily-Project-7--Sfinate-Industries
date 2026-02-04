<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orderan_details', function (Blueprint $table) {
            $table->decimal('jasa_sablon', 12, 2)->default(0)->after('warna');
        });
    }

    public function down(): void
    {
        Schema::table('orderan_details', function (Blueprint $table) {
            $table->dropColumn('jasa_sablon');
        });
    }
};
