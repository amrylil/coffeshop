<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            // Kopi
            [
                'kode_menu'     => 'MNU' . Str::random(5),
                'nama'          => 'Kopi Hitam',
                'deskripsi'     => 'Kopi hitam dengan biji kopi pilihan yang disangrai sempurna',
                'harga'         => 15000.0,
                'kode_kategori' => 'KAT001',
                'path_img'      => 'images/menu/kopi-hitam.jpg',
                'jumlah'        => 100,
                'created_at'    => now(),
            ],
            [
                'kode_menu'     => 'MNU' . Str::random(5),
                'nama'          => 'Cappuccino',
                'deskripsi'     => 'Espresso dengan tambahan susu yang lembut dan foam yang creamy',
                'harga'         => 25000.0,
                'kode_kategori' => 'KAT001',
                'path_img'      => 'images/menu/cappuccino.jpg',
                'jumlah'        => 100,
                'created_at'    => now(),
            ],
            [
                'kode_menu'     => 'MNU' . Str::random(5),
                'nama'          => 'Latte',
                'deskripsi'     => 'Espresso dengan tambahan susu yang banyak dan foam tipis',
                'harga'         => 27000.0,
                'kode_kategori' => 'KAT001',
                'path_img'      => 'images/menu/latte.jpg',
                'jumlah'        => 100,
                'created_at'    => now(),
            ],
            [
                'kode_menu'     => 'MNU' . Str::random(5),
                'nama'          => 'Espresso',
                'deskripsi'     => 'Sari kopi pekat yang disajikan dalam jumlah kecil',
                'harga'         => 18000.0,
                'kode_kategori' => 'KAT001',
                'path_img'      => 'images/menu/espresso.jpg',
                'jumlah'        => 100,
                'created_at'    => now(),
            ],
            // Teh
            [
                'kode_menu'     => 'MNU' . Str::random(5),
                'nama'          => 'Green Tea',
                'deskripsi'     => 'Teh hijau segar yang kaya akan antioksidan',
                'harga'         => 20000.0,
                'kode_kategori' => 'KAT002',
                'path_img'      => 'images/menu/green-tea.jpg',
                'jumlah'        => 100,
                'created_at'    => now(),
            ],
            [
                'kode_menu'     => 'MNU' . Str::random(5),
                'nama'          => 'Earl Grey',
                'deskripsi'     => 'Teh hitam dengan tambahan aroma jeruk bergamot',
                'harga'         => 22000.0,
                'kode_kategori' => 'KAT002',
                'path_img'      => 'images/menu/earl-grey.jpg',
                'jumlah'        => 100,
                'created_at'    => now(),
            ],
            // Makanan Ringan
            [
                'kode_menu'     => 'MNU' . Str::random(5),
                'nama'          => 'Kentang Goreng',
                'deskripsi'     => 'Kentang goreng renyah yang disajikan dengan saus sambal dan mayones',
                'harga'         => 25000.0,
                'kode_kategori' => 'KAT003',
                'path_img'      => 'images/menu/kentang-goreng.jpg',
                'jumlah'        => 50,
                'created_at'    => now(),
            ],
            [
                'kode_menu'     => 'MNU' . Str::random(5),
                'nama'          => 'Sandwich Chicken',
                'deskripsi'     => 'Sandwich dengan isian ayam panggang, selada, tomat, dan saus mayo',
                'harga'         => 35000.0,
                'kode_kategori' => 'KAT003',
                'path_img'      => 'images/menu/sandwich-chicken.jpg',
                'jumlah'        => 30,
                'created_at'    => now(),
            ],
            // Dessert
            [
                'kode_menu'     => 'MNU' . Str::random(5),
                'nama'          => 'Cheesecake',
                'deskripsi'     => 'Kue dengan lapisan keju lembut di atas biscuit yang renyah',
                'harga'         => 35000.0,
                'kode_kategori' => 'KAT004',
                'path_img'      => 'images/menu/cheesecake.jpg',
                'jumlah'        => 20,
                'created_at'    => now(),
            ],
            [
                'kode_menu'     => 'MNU' . Str::random(5),
                'nama'          => 'Chocolate Lava Cake',
                'deskripsi'     => 'Kue coklat hangat dengan isian coklat cair di tengahnya',
                'harga'         => 30000.0,
                'kode_kategori' => 'KAT004',
                'path_img'      => 'images/menu/chocolate-lava.jpg',
                'jumlah'        => 25,
                'created_at'    => now(),
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
