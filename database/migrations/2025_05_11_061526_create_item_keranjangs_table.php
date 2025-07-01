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
        Schema::create('item_keranjang', function (Blueprint $table) {
            $table->string('kode_item', 100)->primary();
            $table->string('kode_keranjang', 100)->nullable();
            $table->string('kode_menu', 100)->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table
                ->foreign('kode_keranjang')
                ->references('kode_keranjang')
                ->on('keranjang');
            $table
                ->foreign('kode_menu')
                ->references('kode_menu')
                ->on('menu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_keranjang');
    }
};
