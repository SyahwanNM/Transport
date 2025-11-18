<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kriteria = [
            [
                'kode_kriteria' => 'C1',
                'nama_kriteria' => 'Keterjangkauan/UMR',
                'jenis' => 'benefit'
            ],
            [
                'kode_kriteria' => 'C2',
                'nama_kriteria' => 'Waktu Tempuh',
                'jenis' => 'cost'
            ],
            [
                'kode_kriteria' => 'C3',
                'nama_kriteria' => 'Jumlah Armada (Ketersediaan Transportasi Online)',
                'jenis' => 'benefit'
            ],
            [
                'kode_kriteria' => 'C4',
                'nama_kriteria' => 'Jumlah Kendaraan Pribadi',
                'jenis' => 'cost'
            ]
        ];

        foreach ($kriteria as $k) {
            Kriteria::create($k);
        }
    }
}