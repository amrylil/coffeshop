<?php
namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\Menu;
use App\Models\MenuBahan;
use Illuminate\Database\Seeder;

class MenuBahanSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil menu by name
        $kopiHitam  = Menu::where('nama', 'Kopi Hitam')->first();
        $cappuccino = Menu::where('nama', 'Cappuccino')->first();
        $latte      = Menu::where('nama', 'Latte')->first();
        $espresso   = Menu::where('nama', 'Espresso')->first();
        $greenTea   = Menu::where('nama', 'Green Tea')->first();
        $earlGrey   = Menu::where('nama', 'Earl Grey')->first();
        $sandwich   = Menu::where('nama', 'Sandwich Chicken')->first();
        $kentang    = Menu::where('nama', 'Kentang Goreng')->first();
        $cheesecake = Menu::where('nama', 'Cheesecake')->first();
        $lava       = Menu::where('nama', 'Chocolate Lava Cake')->first();

        // Ambil bahan
        $kopi   = Inventory::where('nama_bahan', 'Biji Kopi')->first();
        $gula   = Inventory::where('nama_bahan', 'Gula')->first();
        $susu   = Inventory::where('nama_bahan', 'Susu')->first();
        $tehH   = Inventory::where('nama_bahan', 'Teh Hijau')->first();
        $tehB   = Inventory::where('nama_bahan', 'Teh Hitam')->first();
        $roti   = Inventory::where('nama_bahan', 'Roti')->first();
        $kent   = Inventory::where('nama_bahan', 'Kentang')->first();
        $keju   = Inventory::where('nama_bahan', 'Keju')->first();
        $coklat = Inventory::where('nama_bahan', 'Coklat')->first();

        $relations = [
            // Kopi Hitam
            [$kopiHitam, $kopi, 10],
            [$kopiHitam, $gula, 5],

            // Cappuccino
            [$cappuccino, $kopi, 8],
            [$cappuccino, $susu, 50],
            [$cappuccino, $gula, 5],

            // Latte
            [$latte, $kopi, 8],
            [$latte, $susu, 80],
            [$latte, $gula, 5],

            // Espresso
            [$espresso, $kopi, 10],

            // Green Tea
            [$greenTea, $tehH, 5],
            [$greenTea, $gula, 5],

            // Earl Grey
            [$earlGrey, $tehB, 5],
            [$earlGrey, $gula, 5],

            // Sandwich
            [$sandwich, $roti, 2],
            [$sandwich, $susu, 20],
            [$sandwich, $keju, 10],

            // Kentang Goreng
            [$kentang, $kent, 200],

            // Cheesecake
            [$cheesecake, $keju, 50],
            [$cheesecake, $susu, 20],

            // Lava Cake
            [$lava, $coklat, 40],
            [$lava, $susu, 20],
        ];

        foreach ($relations as [$menu, $bahan, $jumlah]) {
            if ($menu && $bahan) {
                MenuBahan::create([
                    'kode_menu'  => $menu->kode_menu,
                    'kode_bahan' => $bahan->kode_bahan,
                    'jumlah'     => $jumlah,
                ]);
            }
        }
    }
}