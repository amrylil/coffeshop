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
        Schema::create('meja_222297', function (Blueprint $table) {
            $table->string('nomor_meja_222297', 10)->primary();
            $table->integer('kapasitas_222297')->nullable();
            $table->enum('status_222297', ['kosong', 'dipesan', 'digunakan'])->default('kosong');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meja_222297');
    }
};
