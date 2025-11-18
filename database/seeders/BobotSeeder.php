<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bobot;

class BobotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bobot = [
            [
                'kode_kriteria' => 'C1',
                'bobot' => 0.33
            ],
            [
                'kode_kriteria' => 'C2',
                'bobot' => 0.31
            ],
            [
                'kode_kriteria' => 'C3',
                'bobot' => 0.29
            ],
            [
                'kode_kriteria' => 'C4',
                'bobot' => 0.06
            ]
        ];

        foreach ($bobot as $b) {
            Bobot::create($b);
        }
    }
}
