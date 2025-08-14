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
            'id'         => (string) Str::uuid(),
            'email'      => 'admin@kedaikopi.com',
            'name'       => 'Admin Kedai Kopi',
            'password'   => Hash::make('admin123'),
            'gender'     => 'male',
            'role'       => 'admin',
            'address'    => 'Jl. Admin No. 1',
            'phone'      => '08123456789',
            'birth_date' => '1990-01-01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}