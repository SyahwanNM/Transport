<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompareCityRequest;
use App\Models\Kota;
use App\Models\HasilPerhitungan;
use App\Models\TarifRekomendasi;
use App\Models\HistoryPenggunaan;
use App\Services\MultikriteriaCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ComparisonController extends Controller
{
    protected $calculationService;

    public function __construct(MultikriteriaCalculationService $calculationService)
    {
        $this->calculationService = $calculationService;
    }

    /**
     * Menampilkan form input data kota user
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua kota yang bisa digunakan sebagai pembanding
        $kotaPembanding = Kota::orderBy('nama_kota')->get();
        return view('comparison.form', compact('kotaPembanding'));
    }

    /**
     * Memproses input user dan melakukan perbandingan dengan Bandung
     * 
     * @param CompareCityRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function compare(CompareCityRequest $request)
    {
        // Validasi kota pembanding
        $request->validate([
            'kota_pembanding_id' => 'required|exists:kota,id',
        ]);

        // Ambil kota pembanding yang dipilih user
        $kotaPembanding = Kota::findOrFail($request->kota_pembanding_id);

        // Bersihkan format angka (hapus titik pemisah ribuan) sebelum menyimpan
        $umr = str_replace('.', '', $request->umr);
        $avgTime = str_replace('.', '', $request->avg_time);
        $armadaCount = str_replace('.', '', $request->armada_count);
        $privateVehicle = str_replace('.', '', $request->private_vehicle);
        $actualMinTarif = str_replace('.', '', $request->actual_min_tarif);

        // Buat kota temporary dari input user (tidak disimpan ke database)
        $userKota = new Kota([
            'nama_kota' => $request->city_name,
            'umr' => $umr,
            'waktu_tempuh' => $avgTime,
            'jumlah_armada' => $armadaCount,
            'jumlah_kendaraan_pribadi' => $privateVehicle,
            'tarif_minimum_aktual' => $actualMinTarif,
        ]);

        // Simpan sementara ke database untuk perhitungan
        // Kita akan hapus setelah perhitungan selesai
        $userKota->save();

        try {
            // Kumpulkan kedua kota untuk perhitungan
            $kotaUntukPerhitungan = collect([$kotaPembanding, $userKota]);

            // Lakukan perhitungan SAW
            $this->calculationService->hitungSaw($kotaUntukPerhitungan);

            // Refresh data untuk mendapatkan hasil perhitungan (dengan relasi)
            $kotaPembanding->refresh();
            $kotaPembanding->load('hasilPerhitungan');
            $userKota->refresh();
            $userKota->load('hasilPerhitungan');

            // Hitung tarif rekomendasi
            $tarifRekomendasi = $this->calculationService->hitungTarifRekomendasi($kotaPembanding, $userKota);

            // Hitung skor
            $skorPembanding = $this->calculationService->getSkorPreferensiTotal($kotaPembanding);
            $skorUser = $this->calculationService->getSkorPreferensiTotal($userKota);

            // Simpan history penggunaan (gunakan nilai yang sudah dibersihkan dari titik)
            HistoryPenggunaan::create([
                'nama_kota_user' => $request->city_name,
                'umr_user' => $umr,
                'waktu_tempuh_user' => $avgTime,
                'jumlah_armada_user' => $armadaCount,
                'jumlah_kendaraan_pribadi_user' => $privateVehicle,
                'tarif_minimum_aktual_user' => $actualMinTarif,
                'kota_pembanding_id' => $kotaPembanding->id,
                'tarif_rekomendasi' => $tarifRekomendasi->tarif_rekomendasi,
                'selisih' => $tarifRekomendasi->selisih,
                'skor_user' => $skorUser,
                'skor_pembanding' => $skorPembanding,
                'ip_address' => $request->ip(),
                'created_at' => now(),
            ]);

            // Simpan data ke session untuk ditampilkan di halaman result
            Session::put('comparison_result', [
                'user_kota' => $userKota->toArray(),
                'kota_pembanding' => $kotaPembanding->toArray(),
                'tarif_rekomendasi' => $tarifRekomendasi->toArray(),
                'skor_pembanding' => $skorPembanding,
                'skor_user' => $skorUser,
            ]);

            // Simpan ID kota temporary untuk cleanup
            $userKotaId = $userKota->id;
            $tarifRekomendasiId = $tarifRekomendasi->id;

            // Hapus data terkait sebelum menghapus kota (untuk menghindari foreign key constraint)
            // Hapus tarif_rekomendasi yang terkait dengan kota temporary
            TarifRekomendasi::where('id', $tarifRekomendasiId)->delete();
            
            // Hapus hasil_perhitungan yang terkait dengan kota temporary
            HasilPerhitungan::where('kota_id', $userKotaId)->delete();
            
            // Hapus kota temporary dari database
            Kota::where('id', $userKotaId)->delete();

            return redirect()->route('comparison.result');
        } catch (\Exception $e) {
            // Cleanup jika terjadi error
            if (isset($userKota) && $userKota->id) {
                try {
                    // Hapus data terkait terlebih dahulu
                    HasilPerhitungan::where('kota_id', $userKota->id)->delete();
                    TarifRekomendasi::where('kota_acuan_id', $userKota->id)
                        ->orWhere('kota_banding_id', $userKota->id)
                        ->delete();
                    // Hapus kota
                    Kota::where('id', $userKota->id)->delete();
                } catch (\Exception $cleanupError) {
                    // Log error jika cleanup gagal
                    \Log::error('Cleanup error: ' . $cleanupError->getMessage());
                }
            }

            return redirect()->route('comparison.index')
                ->with('error', 'Terjadi kesalahan saat melakukan perhitungan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan hasil perbandingan
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function result()
    {
        $result = Session::get('comparison_result');

        if (!$result) {
            return redirect()->route('comparison.index')
                ->with('error', 'Tidak ada data perbandingan. Silakan isi form terlebih dahulu.');
        }

        // Ambil detail hasil perhitungan jika diperlukan
        $kriteria = \App\Models\Kriteria::all();
        $bobot = \App\Models\Bobot::all()->keyBy('kode_kriteria');

        return view('comparison.result', compact('result', 'kriteria', 'bobot'));
    }
}

