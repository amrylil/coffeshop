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
        Schema::create('menu_222297', function (Blueprint $table) {
            $table->string('kode_menu_222297', 20)->primary();
            $table->string('nama_222297', 255)->nullable();
            $table->text('deskripsi_222297')->nullable();
            $table->decimal('harga_222297', 10, 2)->nullable();
            $table->string('kode_kategori_222297', 20)->nullable();
            $table->string('path_img_222297', 255)->nullable();
            $table->integer('jumlah_222297')->nullable();
            $table->timestamp('created_at_222297')->nullable();

            $table
                ->foreign('kode_kategori_222297')
                ->references('kode_kategori_222297')
                ->on('kategori_produk_222297');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_222297');
    }
};
