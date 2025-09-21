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
        Schema::create('reservasi', function (Blueprint $table) {
            $table->string('kode_reservasi', 20)->primary();
            $table->date('tanggal_reservasi')->nullable();
            $table->time('jam_reservasi')->nullable();
            $table->uuid('user_id')->nullable();
            $table->string('nomor_meja', 10)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table
                ->foreign('nomor_meja')
                ->references('nomor_meja')
                ->on('meja');
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
        Schema::dropIfExists('reservasi');
    }
};