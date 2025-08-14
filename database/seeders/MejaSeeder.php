<?php
namespace Database\Seeders;

use App\Helpers\IDGeneratorHelper;
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
                'nomor_meja' => IDGeneratorHelper::generateMejaID(),
                'kapasitas'  => 2,
                'status'     => 'kosong',
            ],
            [
                'nomor_meja' => IDGeneratorHelper::generateMejaID(),
                'kapasitas'  => 2,
                'status'     => 'kosong',
            ],
            [
                'nomor_meja' => IDGeneratorHelper::generateMejaID(),
                'kapasitas'  => 4,
                'status'     => 'kosong',
            ],
            [
                'nomor_meja' => IDGeneratorHelper::generateMejaID(),
                'kapasitas'  => 4,
                'status'     => 'kosong',
            ],
            [
                'nomor_meja' => IDGeneratorHelper::generateMejaID(),
                'kapasitas'  => 6,
                'status'     => 'kosong',
            ],
            [
                'nomor_meja' => IDGeneratorHelper::generateMejaID(),
                'kapasitas'  => 8,
                'status'     => 'kosong',
            ],
        ];

        foreach ($tables as $table) {
            Meja::create($table);
        }
    }
}