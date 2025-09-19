<?php
namespace Database\Seeders;

use App\Helpers\IDGeneratorHelper;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            // Kopi
            [
                'kode_menu'     => IDGeneratorHelper::generateMenuID(),
                'nama'          => 'Kopi Hitam',
                'deskripsi'     => 'Kopi hitam dengan biji kopi pilihan yang disangrai sempurna',
                'harga'         => 15000.0,
                'kode_kategori' => 'KAT001',
                'path_img'      => 'images/menu/kopi-hitam.jpg',
                'status'        => 'available',
            ],
            [
                'kode_menu'     => IDGeneratorHelper::generateMenuID(),
                'nama'          => 'Cappuccino',
                'deskripsi'     => 'Espresso dengan tambahan susu yang lembut dan foam yang creamy',
                'harga'         => 25000.0,
                'kode_kategori' => 'KAT001',
                'path_img'      => 'images/menu/cappuccino.jpg',
                'status'        => 'available',
            ],
            [
                'kode_menu'     => IDGeneratorHelper::generateMenuID(),
                'nama'          => 'Latte',
                'deskripsi'     => 'Espresso dengan tambahan susu yang banyak dan foam tipis',
                'harga'         => 27000.0,
                'kode_kategori' => 'KAT001',
                'path_img'      => 'images/menu/latte.jpg',
                'status'        => 'available',
            ],
            [
                'kode_menu'     => IDGeneratorHelper::generateMenuID(),
                'nama'          => 'Espresso',
                'deskripsi'     => 'Sari kopi pekat yang disajikan dalam jumlah kecil',
                'harga'         => 18000.0,
                'kode_kategori' => 'KAT001',
                'path_img'      => 'images/menu/espresso.jpg',
                'status'        => 'available',
            ],
            // Teh
            [
                'kode_menu'     => IDGeneratorHelper::generateMenuID(),
                'nama'          => 'Green Tea',
                'deskripsi'     => 'Teh hijau segar yang kaya akan antioksidan',
                'harga'         => 20000.0,
                'kode_kategori' => 'KAT002',
                'path_img'      => 'images/menu/green-tea.jpg',
                'status'        => 'available',
            ],
            [
                'kode_menu'     => IDGeneratorHelper::generateMenuID(),
                'nama'          => 'Earl Grey',
                'deskripsi'     => 'Teh hitam dengan tambahan aroma jeruk bergamot',
                'harga'         => 22000.0,
                'kode_kategori' => 'KAT002',
                'path_img'      => 'images/menu/earl-grey.jpg',
                'status'        => 'available',
            ],
            // Makanan Ringan
            [
                'kode_menu'     => IDGeneratorHelper::generateMenuID(),
                'nama'          => 'Kentang Goreng',
                'deskripsi'     => 'Kentang goreng renyah dengan saus sambal dan mayones',
                'harga'         => 25000.0,
                'kode_kategori' => 'KAT003',
                'path_img'      => 'images/menu/kentang-goreng.jpg',
                'status'        => 'available',
            ],
            [
                'kode_menu'     => IDGeneratorHelper::generateMenuID(),
                'nama'          => 'Sandwich Chicken',
                'deskripsi'     => 'Sandwich dengan isian ayam panggang, selada, tomat, dan saus mayo',
                'harga'         => 35000.0,
                'kode_kategori' => 'KAT003',
                'path_img'      => 'images/menu/sandwich-chicken.jpg',
                'status'        => 'available',
            ],
            // Dessert
            [
                'kode_menu'     => IDGeneratorHelper::generateMenuID(),
                'nama'          => 'Cheesecake',
                'deskripsi'     => 'Kue dengan lapisan keju lembut di atas biscuit yang renyah',
                'harga'         => 35000.0,
                'kode_kategori' => 'KAT004',
                'path_img'      => 'images/menu/cheesecake.jpg',
                'status'        => 'available',
            ],
            [
                'kode_menu'     => IDGeneratorHelper::generateMenuID(),
                'nama'          => 'Chocolate Lava Cake',
                'deskripsi'     => 'Kue coklat hangat dengan isian coklat cair di tengahnya',
                'harga'         => 30000.0,
                'kode_kategori' => 'KAT004',
                'path_img'      => 'images/menu/chocolate-lava.jpg',
                'status'        => 'available',
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}