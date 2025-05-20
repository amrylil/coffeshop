<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'email_222297'      => 'admin@kedaikopi.com',
            'name_222297'       => 'Admin Kedai Kopi',
            'password_222297'   => Hash::make('password'),
            'gender_222297'     => 'male',
            'role_222297'       => 'admin',
            'address_222297'    => 'Jl. Admin No. 1',
            'phone_222297'      => '08123456789',
            'birth_date_222297' => '1990-01-01',
            'created_at_222297' => now(),
            'updated_at_222297' => now(),
        ]);
    }
}
