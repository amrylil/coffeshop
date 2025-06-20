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
        Schema::create('item_keranjang_222297', function (Blueprint $table) {
            $table->string('kode_item_222297', 100)->primary();
            $table->string('kode_keranjang_222297', 100)->nullable();
            $table->string('kode_menu_222297', 100)->nullable();
            $table->integer('quantity_222297')->nullable();
            $table->decimal('price_222297', 10, 2)->nullable();
            $table->timestamp('created_at_222297')->nullable();
            $table->timestamp('updated_at_222297')->nullable();

            $table
                ->foreign('kode_keranjang_222297')
                ->references('kode_keranjang_222297')
                ->on('keranjang_222297');
            $table
                ->foreign('kode_menu_222297')
                ->references('kode_menu_222297')
                ->on('menu_222297');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_keranjang_222297');
    }
};
