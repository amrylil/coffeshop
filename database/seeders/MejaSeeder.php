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
                'nomor_meja' => 'T01',
                'kapasitas'  => 2,
                'status'     => 'kosong',
            ],
            [
                'nomor_meja' => 'T02',
                'kapasitas'  => 2,
                'status'     => 'kosong',
            ],
            [
                'nomor_meja' => 'T03',
                'kapasitas'  => 4,
                'status'     => 'kosong',
            ],
            [
                'nomor_meja' => 'T04',
                'kapasitas'  => 4,
                'status'     => 'kosong',
            ],
            [
                'nomor_meja' => 'T05',
                'kapasitas'  => 6,
                'status'     => 'kosong',
            ],
            [
                'nomor_meja' => 'T06',
                'kapasitas'  => 8,
                'status'     => 'kosong',
            ],
        ];

        foreach ($tables as $table) {
            Meja::create($table);
        }
    }
}
