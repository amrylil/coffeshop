<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kategori_produk_222297', function (Blueprint $table) {
            $table->string('kode_kategori_222297', 20)->primary();
            $table->string('nama_222297', 255)->nullable();
            $table->text('deskripsi_222297')->nullable();
            $table->string('path_img_222297', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_produk_222297');
    }
};
