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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->string('kode_transaksi', 100)->primary();
            $table->string('user_id', 100);

            $table->string('order_id_midtrans')->unique()->nullable();

            // Total harga dari semua item
            $table->decimal('total_harga', 15, 2);

            // Status transaksi: pending, lunas, kedaluwarsa, gagal
            $table->string('status')->default('pending');

            // Catatan tambahan dari pembeli
            $table->text('catatan')->nullable();

            $table->timestamps();

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};