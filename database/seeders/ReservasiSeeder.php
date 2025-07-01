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
                'kode_reservasi'    => 'RSV' . Str::random(5),
                'nama_pelanggan'    => 'Andi Wijaya',
                'no_telepon'        => '081234567890',
                'tanggal_reservasi' => now()->addDay(),
                'jam_reservasi'     => '18:00:00',
                'jumlah_orang'      => 2,
                'nomor_meja'        => 'T01',
                'catatan'           => 'Perayaan anniversary',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'kode_reservasi'    => 'RSV' . Str::random(5),
                'nama_pelanggan'    => 'Sinta Dewi',
                'no_telepon'        => '082345678901',
                'tanggal_reservasi' => now()->addDays(2),
                'jam_reservasi'     => '19:30:00',
                'jumlah_orang'      => 4,
                'nomor_meja'        => 'T03',
                'catatan'           => 'Meeting bisnis',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ];

        foreach ($reservations as $reservation) {
            Reservasi::create($reservation);
        }
    }
}
