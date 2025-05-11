<?php

namespace Database\Seeders;

use App\Models\Meja;
use Illuminate\Database\Seeder;

class MejaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tables = [
            [
                'nomor_meja_222297' => 'T01',
                'kapasitas_222297'  => 2,
                'status_222297'     => 'kosong',
            ],
            [
                'nomor_meja_222297' => 'T02',
                'kapasitas_222297'  => 2,
                'status_222297'     => 'kosong',
            ],
            [
                'nomor_meja_222297' => 'T03',
                'kapasitas_222297'  => 4,
                'status_222297'     => 'kosong',
            ],
            [
                'nomor_meja_222297' => 'T04',
                'kapasitas_222297'  => 4,
                'status_222297'     => 'kosong',
            ],
            [
                'nomor_meja_222297' => 'T05',
                'kapasitas_222297'  => 6,
                'status_222297'     => 'kosong',
            ],
            [
                'nomor_meja_222297' => 'T06',
                'kapasitas_222297'  => 8,
                'status_222297'     => 'kosong',
            ],
        ];

        foreach ($tables as $table) {
            Meja::create($table);
        }
    }
}
