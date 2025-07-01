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
        Schema::create('users', function (Blueprint $table) {
            $table->string('email', 255)->primary();
            $table->string('name', 255)->nullable();
            $table->string('password', 255)->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('role', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('profile_photo', 255)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
