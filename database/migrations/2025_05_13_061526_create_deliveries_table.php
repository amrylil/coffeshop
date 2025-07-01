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
        Schema::create('delivery', function (Blueprint $table) {
            $table->string('kode_pengantaran', 20)->primary();
            $table->string('kode_transaksi', 20)->nullable();
            $table->string('nama_penerima', 255)->nullable();
            $table->text('alamat_pengantaran')->nullable();
            $table->string('nomor_hp', 20)->nullable();
            $table->string('jasa_kurir', 100)->nullable();
            $table->decimal('ongkir', 10, 2)->nullable();
            $table->enum('status_pengiriman', ['belum dikirim', 'dalam perjalanan', 'sampai'])->nullable();
            $table->timestamp('tanggal_kirim')->nullable();

            $table
                ->foreign('kode_transaksi')
                ->references('kode_transaksi')
                ->on('transaksi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery');
    }
};
