<?php
namespace Database\Seeders;

use App\Models\Inventory;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $inventories = [
            ['kode_bahan' => 'BAH001', 'nama_bahan' => 'Biji Kopi', 'satuan' => 'gram', 'stok' => 1000],
            ['kode_bahan' => 'BAH002', 'nama_bahan' => 'Gula', 'satuan' => 'gram', 'stok' => 2000],
            ['kode_bahan' => 'BAH003', 'nama_bahan' => 'Susu', 'satuan' => 'ml', 'stok' => 5000],
            ['kode_bahan' => 'BAH004', 'nama_bahan' => 'Teh Hijau', 'satuan' => 'gram', 'stok' => 800],
            ['kode_bahan' => 'BAH005', 'nama_bahan' => 'Teh Hitam', 'satuan' => 'gram', 'stok' => 800],
            ['kode_bahan' => 'BAH006', 'nama_bahan' => 'Roti', 'satuan' => 'pcs', 'stok' => 50],
            ['kode_bahan' => 'BAH007', 'nama_bahan' => 'Kentang', 'satuan' => 'gram', 'stok' => 5000],
            ['kode_bahan' => 'BAH008', 'nama_bahan' => 'Keju', 'satuan' => 'gram', 'stok' => 1000],
            ['kode_bahan' => 'BAH009', 'nama_bahan' => 'Coklat', 'satuan' => 'gram', 'stok' => 1200],
        ];

        foreach ($inventories as $inv) {
            Inventory::create($inv);
        }
    }
}