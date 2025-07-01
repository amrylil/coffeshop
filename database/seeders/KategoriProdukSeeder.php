<?php

namespace Database\Seeders;

use App\Models\KategoriProduk;
use Illuminate\Database\Seeder;

class KategoriProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'kode_kategori' => 'KAT001',
                'nama'          => 'Kopi',
                'deskripsi'     => 'Berbagai macam kopi pilihan dengan kualitas premium',
                'path_img'      => 'images/kategori/kopi.jpg',
            ],
            [
                'kode_kategori' => 'KAT002',
                'nama'          => 'Teh',
                'deskripsi'     => 'Bermacam jenis teh dengan aroma yang menyegarkan',
                'path_img'      => 'images/kategori/teh.jpg',
            ],
            [
                'kode_kategori' => 'KAT003',
                'nama'          => 'Makanan Ringan',
                'deskripsi'     => 'Makanan pendamping untuk dinikmati bersama minuman favorit',
                'path_img'      => 'images/kategori/snack.jpg',
            ],
            [
                'kode_kategori' => 'KAT004',
                'nama'          => 'Dessert',
                'deskripsi'     => 'Berbagai macam hidangan pencuci mulut yang lezat',
                'path_img'      => 'images/kategori/dessert.jpg',
            ],
        ];

        foreach ($categories as $category) {
            KategoriProduk::create($category);
        }
    }
}
