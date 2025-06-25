<?php

namespace Database\Seeders;

use App\Models\Kendaraan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KendaraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kendaraans = [
            [
                'nama' => 'Toyota Hiace',
                'jenis' => 'angkutan orang',
                'tipe' => 'milik',
                'no_polisi' => 'B 1234 TPL',
                'region' => 'Kantor Pusat',
                'konsumsi_bbm' => 10.5,
                'jadwal_service_berikutnya' => now()->addMonths(2),
            ],
            [
                'nama' => 'Isuzu Elf',
                'jenis' => 'angkutan orang',
                'tipe' => 'sewaan',
                'no_polisi' => 'D 2345 NPL',
                'region' => 'Tambang A',
                'konsumsi_bbm' => 8.0,
                'jadwal_service_berikutnya' => now()->addMonths(1),
            ],
            [
                'nama' => 'Hino Dutro 130',
                'jenis' => 'angkutan barang',
                'tipe' => 'milik',
                'no_polisi' => 'L 9876 AB',
                'region' => 'Tambang B',
                'konsumsi_bbm' => 6.5,
                'jadwal_service_berikutnya' => now()->addWeeks(3),
            ],
            [
                'nama' => 'Mitsubishi Fuso',
                'jenis' => 'angkutan barang',
                'tipe' => 'sewaan',
                'no_polisi' => 'N 5678 TR',
                'region' => 'Tambang C',
                'konsumsi_bbm' => 5.8,
                'jadwal_service_berikutnya' => now()->addMonths(3),
            ],
        ];

        foreach ($kendaraans as $kendaraan) {
            Kendaraan::create($kendaraan);
        }
    }
}
