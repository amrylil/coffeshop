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
        Schema::create('transaksi_222297', function (Blueprint $table) {
            $table->string('kode_transaksi_222297', 100)->primary();
            $table->string('email_222297', 100)->nullable();
            $table->string('kode_menu_222297', 20)->nullable();
            $table->integer('jumlah_222297')->nullable();
            $table->decimal('harga_total_222297', 10, 2)->nullable();
            $table->enum('status_222297', ['pending', 'dikemas', 'dikirim', 'selesai'])->nullable();
            $table->string('bukti_tf_222297', 255)->nullable();
            $table->timestamp('tanggal_transaksi_222297')->nullable();
            $table->timestamp('created_at_222297')->nullable();
            $table->timestamp('updated_at_222297')->nullable();

            $table
                ->foreign('email_222297')
                ->references('email_222297')
                ->on('users_222297');
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
        Schema::dropIfExists('transaksi_222297');
    }
};
