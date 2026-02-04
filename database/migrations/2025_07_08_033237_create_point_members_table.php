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
        Schema::create('point_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->integer('total_point')->default(0);
            $table->timestamps();
        });

        Schema::create('riwayat_poin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members');
            $table->foreignId('orderan_id')->nullable()->constrained('orderans');
            $table->integer('poin');
            $table->enum('tipe', ['tambah', 'kurang']); // penambahan atau penukaran poin
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_members');
        Schema::dropIfExists('riwayat_poin');
    }
};
