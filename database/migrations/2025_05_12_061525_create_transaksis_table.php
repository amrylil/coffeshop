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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->string('kode_transaksi', 100)->primary();
            $table->string('email', 100)->nullable();
            $table->string('kode_menu', 20)->nullable();
            $table->integer('jumlah')->nullable();
            $table->decimal('harga_total', 10, 2)->nullable();
            $table->enum('status', ['pending', 'dikonfirmasi', 'selesai', 'dikirim', 'ditolak'])->nullable();
            $table->string('bukti_tf', 255)->nullable();
            $table->timestamp('tanggal_transaksi')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table
                ->enum('jenis_pesanan', ['delivery', 'di_lokasi'])
                ->default('di_lokasi');

            $table
                ->foreign('email')
                ->references('email')
                ->on('users');
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
        Schema::dropIfExists('transaksi');
    }
};
