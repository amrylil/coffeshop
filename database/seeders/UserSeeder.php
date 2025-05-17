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
            'user_id_222297'    => 'USR' . Str::random(5),
            'email_222297'      => 'adminkedai@gmail.com',
            'name_222297'       => 'Admin Kedai Kopi',
            'password_222297'   => Hash::make('admin123'),
            'gender_222297'     => 'male',
            'role_222297'       => 'admin',
            'address_222297'    => 'Jl. Admin No. 1',
            'phone_222297'      => '08123456789',
            'birth_date_222297' => '1990-01-01',
            'created_at_222297' => now(),
            'updated_at_222297' => now(),
        ]);

        // Regular users
        User::create([
            'user_id_222297'    => 'USR' . Str::random(5),
            'email_222297'      => 'customer1@example.com',
            'name_222297'       => 'Customer One',
            'password_222297'   => Hash::make('password'),
            'gender_222297'     => 'female',
            'role_222297'       => 'customer',
            'address_222297'    => 'Jl. Customer No. 1',
            'phone_222297'      => '08234567890',
            'birth_date_222297' => '1995-05-15',
            'created_at_222297' => now(),
            'updated_at_222297' => now(),
        ]);

        User::create([
            'user_id_222297'    => 'USR' . Str::random(5),
            'email_222297'      => 'customer2@example.com',
            'name_222297'       => 'Customer Two',
            'password_222297'   => Hash::make('password'),
            'gender_222297'     => 'male',
            'role_222297'       => 'customer',
            'address_222297'    => 'Jl. Customer No. 2',
            'phone_222297'      => '08345678901',
            'birth_date_222297' => '1992-10-20',
            'created_at_222297' => now(),
            'updated_at_222297' => now(),
        ]);
    }
}
