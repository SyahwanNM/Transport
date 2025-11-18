<?php

namespace App\Services;

use App\Models\Kota;
use App\Models\Kriteria;
use App\Models\Bobot;
use App\Models\HasilPerhitungan;
use App\Models\TarifRekomendasi;
use Illuminate\Support\Collection;

/**
 * Service class untuk perhitungan multikriteria menggunakan metode AHP dan SAW
 * 
 * Logika perhitungan ini diambil dari AhpSawController dan tidak boleh diubah
 * Hanya dipindahkan ke Service class untuk reusability
 */
class MultikriteriaCalculationService
{
    /**
     * Melakukan perhitungan SAW untuk semua kota
     * 
     * @param Collection $kota Collection of Kota models
     * @return void
     */
    public function hitungSaw(Collection $kota): void
    {
        $kriteria = Kriteria::all();
        $bobot = Bobot::all()->keyBy('kode_kriteria');

        // Hapus hasil perhitungan lama
        HasilPerhitungan::truncate();

        // Lakukan perhitungan SAW untuk setiap kota
        foreach ($kota as $k) {
            foreach ($kriteria as $kr) {
                $nilaiKriteria = $this->getNilaiKriteria($k, $kr->kode_kriteria);
                $nilaiNormalisasi = $this->hitungNormalisasi($nilaiKriteria, $kr, $kota);

                // Simpan hasil perhitungan
                HasilPerhitungan::create([
                    'kota_id' => $k->id,
                    'kode_kriteria' => $kr->kode_kriteria,
                    'nilai_asli' => $nilaiKriteria,
                    'nilai_normalisasi' => $nilaiNormalisasi,
                    'bobot' => $bobot[$kr->kode_kriteria]->bobot,
                    'skor_preferensi' => $nilaiNormalisasi * $bobot[$kr->kode_kriteria]->bobot
                ]);
            }
        }
    }

    /**
     * Mendapatkan nilai kriteria untuk kota tertentu
     * 
     * @param Kota $kota
     * @param string $kodeKriteria
     * @return float
     */
    public function getNilaiKriteria(Kota $kota, string $kodeKriteria): float
    {
        switch ($kodeKriteria) {
            case 'C1': // UMR - hitung UMR / tarif minimum aktual
                if ($kota->tarif_minimum_aktual && $kota->tarif_minimum_aktual > 0) {
                    return $kota->umr / $kota->tarif_minimum_aktual;
                }
                return $kota->umr;
            case 'C2': // Waktu tempuh
                return $kota->waktu_tempuh;
            case 'C3': // Jumlah armada
                return $kota->jumlah_armada;
            case 'C4': // Jumlah kendaraan pribadi
                return $kota->jumlah_kendaraan_pribadi;
            default:
                return 0;
        }
    }

    /**
     * Menghitung normalisasi SAW
     * 
     * @param float $nilai
     * @param Kriteria $kriteria
     * @param Collection $semuaKota
     * @return float
     */
    public function hitungNormalisasi(float $nilai, Kriteria $kriteria, Collection $semuaKota): float
    {
        $nilaiKriteria = $semuaKota->map(function($kota) use ($kriteria) {
            return $this->getNilaiKriteria($kota, $kriteria->kode_kriteria);
        });

        if ($kriteria->jenis == 'benefit') {
            $max = $nilaiKriteria->max();
            return $max > 0 ? $nilai / $max : 0;
        } else { // cost
            $min = $nilaiKriteria->min();
            return $min > 0 ? $min / $nilai : 0;
        }
    }

    /**
     * Menghitung tarif rekomendasi berdasarkan perbandingan skor
     * 
     * @param Kota $kotaAcuan
     * @param Kota $kotaBanding
     * @return TarifRekomendasi
     */
    public function hitungTarifRekomendasi(Kota $kotaAcuan, Kota $kotaBanding): TarifRekomendasi
    {
        $skorAcuan = $kotaAcuan->hasilPerhitungan->sum('skor_preferensi');
        $skorBanding = $kotaBanding->hasilPerhitungan->sum('skor_preferensi');
        
        // Gunakan tarif minimum kota acuan
        $tarifAcuan = $kotaAcuan->tarif_minimum_aktual ?? 8000; // Default 8000 jika tidak ada
        
        // Hitung tarif rekomendasi berdasarkan rasio skor
        $rasioSkor = $skorBanding / $skorAcuan;
        $tarifRekomendasi = $tarifAcuan * $rasioSkor;
        
        // Simpan hasil perbandingan
        $perbandingan = TarifRekomendasi::create([
            'kota_acuan_id' => $kotaAcuan->id,
            'kota_banding_id' => $kotaBanding->id,
            'tarif_acuan' => $tarifAcuan,
            'skor_acuan' => $skorAcuan,
            'skor_banding' => $skorBanding,
            'tarif_rekomendasi' => $tarifRekomendasi,
            'tarif_aktual' => $kotaBanding->tarif_minimum_aktual,
            'selisih' => $kotaBanding->tarif_minimum_aktual ? 
                $tarifRekomendasi - $kotaBanding->tarif_minimum_aktual : null
        ]);

        return $perbandingan;
    }

    /**
     * Mendapatkan skor preferensi total untuk kota
     * 
     * @param Kota $kota
     * @return float
     */
    public function getSkorPreferensiTotal(Kota $kota): float
    {
        return $kota->hasilPerhitungan->sum('skor_preferensi');
    }
}

