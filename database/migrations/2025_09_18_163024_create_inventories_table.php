<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->string('kode_bahan', 20)->primary();
            $table->string('nama_bahan', 255);
            $table->decimal('stok', 10, 2)->default(0);
            $table->string('satuan', 50); // gram, ml, pcs
            $table->decimal('harga_per_unit', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};