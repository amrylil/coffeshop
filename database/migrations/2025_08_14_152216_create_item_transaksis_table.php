<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_transaksi', function (Blueprint $table) {
            $table->string('id', 100)->primary();

            $table->string('transaksi_id', 20);

            $table->string('kode_menu', 20);

            $table->unsignedInteger('jumlah');

            $table->decimal('harga', 15, 2);

            $table->timestamps();
            $table
                ->foreign('transaksi_id')
                ->references('kode_transaksi')
                ->on('transaksi')
                ->onDelete("cascade");

            $table
                ->foreign('kode_menu')
                ->references('kode_menu')
                ->on('menu')
                ->onDelete("cascade");

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_transaksi');
    }
};