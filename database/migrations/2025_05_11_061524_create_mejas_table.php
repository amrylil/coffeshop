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
        Schema::create('meja', function (Blueprint $table) {
            $table->string('nomor_meja', 10)->primary();
            $table->integer('kapasitas')->nullable();
            $table->enum('status', ['kosong', 'dipesan', 'digunakan'])->default('kosong');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meja');
    }
};
