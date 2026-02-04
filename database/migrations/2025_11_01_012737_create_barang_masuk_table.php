<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->string('kode_masuk')->unique();
            $table->string('nama_barang');
            $table->integer('jumlah');
            $table->decimal('harga_modal', 15, 2)->nullable();
            $table->string('supplier')->nullable();
            $table->date('tanggal_masuk');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_masuk');
    }
};
