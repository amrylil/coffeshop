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
        Schema::create('reservasi_222297', function (Blueprint $table) {
            $table->string('kode_reservasi_222297', 20)->primary();
            $table->string('nama_pelanggan_222297', 255)->nullable();
            $table->string('no_telepon_222297', 50)->nullable();
            $table->date('tanggal_reservasi_222297')->nullable();
            $table->time('jam_reservasi_222297')->nullable();
            $table->integer('jumlah_orang_222297')->nullable();
            $table->string('nomor_meja_222297', 10)->nullable();
            $table->text('catatan_222297')->nullable();
            $table->timestamp('created_at_222297')->nullable();
            $table->timestamp('updated_at_222297')->nullable();

            $table
                ->foreign('nomor_meja_222297')
                ->references('nomor_meja_222297')
                ->on('meja_222297');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi_222297');
    }
};
