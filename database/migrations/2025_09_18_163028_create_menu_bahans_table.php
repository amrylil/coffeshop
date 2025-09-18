<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_bahan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_menu', 20);
            $table->string('kode_bahan', 20);
            $table->decimal('jumlah', 10, 2)->default(0);
            $table->string('satuan', 50)->nullable();
            $table->timestamps();

            $table
                ->foreign('kode_menu')
                ->references('kode_menu')
                ->on('menu')
                ->onDelete('cascade');

            $table
                ->foreign('kode_bahan')
                ->references('kode_bahan')
                ->on('inventory')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_bahan');
    }
};