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
                'kode_kategori_222297' => 'KAT001',
                'nama_222297'          => 'Kopi',
                'deskripsi_222297'     => 'Berbagai macam kopi pilihan dengan kualitas premium',
                'path_img_222297'      => 'images/kategori/kopi.jpg',
            ],
            [
                'kode_kategori_222297' => 'KAT002',
                'nama_222297'          => 'Teh',
                'deskripsi_222297'     => 'Bermacam jenis teh dengan aroma yang menyegarkan',
                'path_img_222297'      => 'images/kategori/teh.jpg',
            ],
            [
                'kode_kategori_222297' => 'KAT003',
                'nama_222297'          => 'Makanan Ringan',
                'deskripsi_222297'     => 'Makanan pendamping untuk dinikmati bersama minuman favorit',
                'path_img_222297'      => 'images/kategori/snack.jpg',
            ],
            [
                'kode_kategori_222297' => 'KAT004',
                'nama_222297'          => 'Dessert',
                'deskripsi_222297'     => 'Berbagai macam hidangan pencuci mulut yang lezat',
                'path_img_222297'      => 'images/kategori/dessert.jpg',
            ],
        ];

        foreach ($categories as $category) {
            KategoriProduk::create($category);
        }
    }
}
