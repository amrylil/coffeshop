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
        Schema::create('users_222297', function (Blueprint $table) {
            $table->string('user_id_222297', 20)->primary();
            $table->string('email_222297', 255)->nullable();
            $table->string('name_222297', 255)->nullable();
            $table->string('password_222297', 255)->nullable();
            $table->enum('gender_222297', ['male', 'female'])->nullable();
            $table->string('role_222297', 255)->nullable();
            $table->string('address_222297', 255)->nullable();
            $table->string('phone_222297', 255)->nullable();
            $table->date('birth_date_222297')->nullable();
            $table->string('profile_photo_222297', 255)->nullable();
            $table->timestamp('created_at_222297')->nullable();
            $table->timestamp('updated_at_222297')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_222297');
    }
};
