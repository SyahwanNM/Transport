<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kota;

class BandungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeder ini hanya untuk menyimpan data Bandung sebagai kota acuan tetap
     */
    public function run(): void
    {
        // Update atau create data Bandung
        $bandung = Kota::where('nama_kota', 'Bandung')->first();
        
        if ($bandung) {
            // Update data yang sudah ada
            $bandung->update([
                'umr' => 4209309,
                'waktu_tempuh' => 1957,
                'jumlah_armada' => 30000,
                'jumlah_kendaraan_pribadi' => 2360000,
                'tarif_minimum_aktual' => 8000
            ]);
        } else {
            // Create jika belum ada
            Kota::create([
                'nama_kota' => 'Bandung',
                'umr' => 4209309,
                'waktu_tempuh' => 1957,
                'jumlah_armada' => 30000,
                'jumlah_kendaraan_pribadi' => 2360000,
                'tarif_minimum_aktual' => 8000
            ]);
        }
    }
}

