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
                'kode_menu_222297'     => 'MNU' . Str::random(5),
                'nama_222297'          => 'Kopi Hitam',
                'deskripsi_222297'     => 'Kopi hitam dengan biji kopi pilihan yang disangrai sempurna',
                'harga_222297'         => 15000.0,
                'kode_kategori_222297' => 'KAT001',
                'path_img_222297'      => 'images/menu/kopi-hitam.jpg',
                'jumlah_222297'        => 100,
                'created_at_222297'    => now(),
            ],
            [
                'kode_menu_222297'     => 'MNU' . Str::random(5),
                'nama_222297'          => 'Cappuccino',
                'deskripsi_222297'     => 'Espresso dengan tambahan susu yang lembut dan foam yang creamy',
                'harga_222297'         => 25000.0,
                'kode_kategori_222297' => 'KAT001',
                'path_img_222297'      => 'images/menu/cappuccino.jpg',
                'jumlah_222297'        => 100,
                'created_at_222297'    => now(),
            ],
            [
                'kode_menu_222297'     => 'MNU' . Str::random(5),
                'nama_222297'          => 'Latte',
                'deskripsi_222297'     => 'Espresso dengan tambahan susu yang banyak dan foam tipis',
                'harga_222297'         => 27000.0,
                'kode_kategori_222297' => 'KAT001',
                'path_img_222297'      => 'images/menu/latte.jpg',
                'jumlah_222297'        => 100,
                'created_at_222297'    => now(),
            ],
            [
                'kode_menu_222297'     => 'MNU' . Str::random(5),
                'nama_222297'          => 'Espresso',
                'deskripsi_222297'     => 'Sari kopi pekat yang disajikan dalam jumlah kecil',
                'harga_222297'         => 18000.0,
                'kode_kategori_222297' => 'KAT001',
                'path_img_222297'      => 'images/menu/espresso.jpg',
                'jumlah_222297'        => 100,
                'created_at_222297'    => now(),
            ],
            // Teh
            [
                'kode_menu_222297'     => 'MNU' . Str::random(5),
                'nama_222297'          => 'Green Tea',
                'deskripsi_222297'     => 'Teh hijau segar yang kaya akan antioksidan',
                'harga_222297'         => 20000.0,
                'kode_kategori_222297' => 'KAT002',
                'path_img_222297'      => 'images/menu/green-tea.jpg',
                'jumlah_222297'        => 100,
                'created_at_222297'    => now(),
            ],
            [
                'kode_menu_222297'     => 'MNU' . Str::random(5),
                'nama_222297'          => 'Earl Grey',
                'deskripsi_222297'     => 'Teh hitam dengan tambahan aroma jeruk bergamot',
                'harga_222297'         => 22000.0,
                'kode_kategori_222297' => 'KAT002',
                'path_img_222297'      => 'images/menu/earl-grey.jpg',
                'jumlah_222297'        => 100,
                'created_at_222297'    => now(),
            ],
            // Makanan Ringan
            [
                'kode_menu_222297'     => 'MNU' . Str::random(5),
                'nama_222297'          => 'Kentang Goreng',
                'deskripsi_222297'     => 'Kentang goreng renyah yang disajikan dengan saus sambal dan mayones',
                'harga_222297'         => 25000.0,
                'kode_kategori_222297' => 'KAT003',
                'path_img_222297'      => 'images/menu/kentang-goreng.jpg',
                'jumlah_222297'        => 50,
                'created_at_222297'    => now(),
            ],
            [
                'kode_menu_222297'     => 'MNU' . Str::random(5),
                'nama_222297'          => 'Sandwich Chicken',
                'deskripsi_222297'     => 'Sandwich dengan isian ayam panggang, selada, tomat, dan saus mayo',
                'harga_222297'         => 35000.0,
                'kode_kategori_222297' => 'KAT003',
                'path_img_222297'      => 'images/menu/sandwich-chicken.jpg',
                'jumlah_222297'        => 30,
                'created_at_222297'    => now(),
            ],
            // Dessert
            [
                'kode_menu_222297'     => 'MNU' . Str::random(5),
                'nama_222297'          => 'Cheesecake',
                'deskripsi_222297'     => 'Kue dengan lapisan keju lembut di atas biscuit yang renyah',
                'harga_222297'         => 35000.0,
                'kode_kategori_222297' => 'KAT004',
                'path_img_222297'      => 'images/menu/cheesecake.jpg',
                'jumlah_222297'        => 20,
                'created_at_222297'    => now(),
            ],
            [
                'kode_menu_222297'     => 'MNU' . Str::random(5),
                'nama_222297'          => 'Chocolate Lava Cake',
                'deskripsi_222297'     => 'Kue coklat hangat dengan isian coklat cair di tengahnya',
                'harga_222297'         => 30000.0,
                'kode_kategori_222297' => 'KAT004',
                'path_img_222297'      => 'images/menu/chocolate-lava.jpg',
                'jumlah_222297'        => 25,
                'created_at_222297'    => now(),
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
