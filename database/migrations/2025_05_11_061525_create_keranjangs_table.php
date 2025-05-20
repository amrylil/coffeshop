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
        Schema::create('keranjang_222297', function (Blueprint $table) {
            $table->string('kode_keranjang_222297', 20)->primary();
            $table->string('email_222297', 20)->nullable();
            $table->timestamp('created_at_222297')->nullable();
            $table->timestamp('updated_at_222297')->nullable();

            $table
                ->foreign('email_222297')
                ->references('email_222297')
                ->on('users_222297');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang_222297');
    }
};
