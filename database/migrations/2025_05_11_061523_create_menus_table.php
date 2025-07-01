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
        Schema::create('menu', function (Blueprint $table) {
            $table->string('kode_menu', 20)->primary();
            $table->string('nama', 255)->nullable();
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 10, 2)->nullable();
            $table->string('kode_kategori', 20)->nullable();
            $table->string('path_img', 255)->nullable();
            $table->integer('jumlah')->nullable();
            $table->timestamp('created_at')->nullable();

            $table
                ->foreign('kode_kategori')
                ->references('kode_kategori')
                ->on('kategori_produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
