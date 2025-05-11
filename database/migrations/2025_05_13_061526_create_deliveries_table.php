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
        Schema::create('delivery_222297', function (Blueprint $table) {
            $table->string('kode_pengantaran_222297', 20)->primary();
            $table->string('kode_transaksi_222297', 20)->nullable();
            $table->string('nama_penerima_222297', 255)->nullable();
            $table->text('alamat_pengantaran_222297')->nullable();
            $table->string('nomor_hp_222297', 20)->nullable();
            $table->string('jasa_kurir_222297', 100)->nullable();
            $table->decimal('ongkir_222297', 10, 2)->nullable();
            $table->enum('status_pengiriman_222297', ['belum dikirim', 'dalam perjalanan', 'sampai'])->nullable();
            $table->timestamp('tanggal_kirim_222297')->nullable();

            $table
                ->foreign('kode_transaksi_222297')
                ->references('kode_transaksi_222297')
                ->on('transaksi_222297');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_222297');
    }
};
