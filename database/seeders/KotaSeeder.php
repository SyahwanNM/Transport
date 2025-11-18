<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kota;

class KotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama
        Kota::query()->delete();
        
        // Data sesuai dengan matriks keputusan awal dari gambar
        $kota = [
            [
                'nama_kota' => 'Bandung',
                'umr' => 4209309,
                'waktu_tempuh' => 1957,
                'jumlah_armada' => 30000,
                'jumlah_kendaraan_pribadi' => 2360000,
                'tarif_minimum_aktual' => 6000
            ],
            [
                'nama_kota' => 'Medan',
                'umr' => 3769082,
                'waktu_tempuh' => 1923,
                'jumlah_armada' => 2000,
                'jumlah_kendaraan_pribadi' => 3690000,
                'tarif_minimum_aktual' => 5000
            ],
            [
                'nama_kota' => 'Palembang',
                'umr' => 3677591,
                'waktu_tempuh' => 1675,
                'jumlah_armada' => 25000,
                'jumlah_kendaraan_pribadi' => 1640000,
                'tarif_minimum_aktual' => 4500
            ],
            [
                'nama_kota' => 'Surabaya',
                'umr' => 4725479,
                'waktu_tempuh' => 1619,
                'jumlah_armada' => 15350,
                'jumlah_kendaraan_pribadi' => 3810000,
                'tarif_minimum_aktual' => 7000
            ],
            [
                'nama_kota' => 'Jakarta',
                'umr' => 5396761,
                'waktu_tempuh' => 1531,
                'jumlah_armada' => 1000000,
                'jumlah_kendaraan_pribadi' => 24356669,
                'tarif_minimum_aktual' => 8000
            ]
        ];

        foreach ($kota as $k) {
            Kota::create($k);
        }
    }
}