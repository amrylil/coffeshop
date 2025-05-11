<?php

namespace Database\Seeders;

use App\Models\Reservasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ReservasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reservations = [
            [
                'kode_reservasi_222297'    => 'RSV' . Str::random(5),
                'nama_pelanggan_222297'    => 'Andi Wijaya',
                'no_telepon_222297'        => '081234567890',
                'tanggal_reservasi_222297' => now()->addDay(),
                'jam_reservasi_222297'     => '18:00:00',
                'jumlah_orang_222297'      => 2,
                'nomor_meja_222297'        => 'T01',
                'catatan_222297'           => 'Perayaan anniversary',
                'created_at_222297'        => now(),
                'updated_at_222297'        => now(),
            ],
            [
                'kode_reservasi_222297'    => 'RSV' . Str::random(5),
                'nama_pelanggan_222297'    => 'Sinta Dewi',
                'no_telepon_222297'        => '082345678901',
                'tanggal_reservasi_222297' => now()->addDays(2),
                'jam_reservasi_222297'     => '19:30:00',
                'jumlah_orang_222297'      => 4,
                'nomor_meja_222297'        => 'T03',
                'catatan_222297'           => 'Meeting bisnis',
                'created_at_222297'        => now(),
                'updated_at_222297'        => now(),
            ],
        ];

        foreach ($reservations as $reservation) {
            Reservasi::create($reservation);
        }
    }
}
