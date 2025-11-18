<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\HistoryPenggunaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\RateLimiter;

class AdminController extends Controller
{
    /**
     * Menampilkan halaman login admin
     */
    public function showLogin()
    {
        return view('admin.login');
    }

    /**
     * Proses login admin
     */
    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        // Simple password check (untuk production, gunakan authentication yang lebih aman)
        $adminPassword = env('ADMIN_PASSWORD', 'admin123');
        
        if ($request->password === $adminPassword) {
            // Reset rate limiter setelah login berhasil
            // Named rate limiter menggunakan format khusus Laravel
            $key = 'admin-login:' . $request->ip();
            RateLimiter::clear($key);
            
            Session::put('admin_logged_in', true);
            return redirect()->route('admin.dashboard')
                ->with('success', 'Login berhasil!');
        }

        // Hitung sisa percobaan untuk rate limiting
        // Named rate limiter menggunakan format: 'limiter_name:identifier'
        // Identifier adalah IP address dari request
        $key = 'admin-login:' . $request->ip();
        $maxAttempts = 5;
        $decayMinutes = 1;
        
        // Cek apakah masih bisa mencoba
        // Throttle middleware akan memblokir request jika sudah mencapai limit
        // Kita cek di sini untuk memberikan feedback yang lebih baik
        try {
            $attempts = RateLimiter::attempts($key);
            $remaining = max(0, $maxAttempts - $attempts - 1);
            
            $errorMessage = 'Password salah!';
            if ($remaining <= 2 && $remaining > 0) {
                $errorMessage .= " Sisa percobaan: {$remaining}. Setelah {$maxAttempts} percobaan gagal, Anda harus menunggu {$decayMinutes} menit.";
            } elseif ($remaining == 0) {
                try {
                    $seconds = RateLimiter::availableIn($key);
                    $minutes = max(1, ceil($seconds / 60));
                    $errorMessage = "Terlalu banyak percobaan login gagal. Silakan coba lagi dalam {$minutes} menit.";
                } catch (\Exception $e) {
                    $errorMessage = "Terlalu banyak percobaan login gagal. Silakan coba lagi dalam {$decayMinutes} menit.";
                }
            }
        } catch (\Exception $e) {
            // Jika ada error saat mengakses rate limiter, tetap tampilkan pesan error standar
            $errorMessage = 'Password salah!';
        }

        return back()->with('error', $errorMessage);
    }

    /**
     * Logout admin
     */
    public function logout()
    {
        Session::forget('admin_logged_in');
        return redirect()->route('admin.login')
            ->with('success', 'Logout berhasil!');
    }

    /**
     * Dashboard admin
     */
    public function dashboard()
    {
        $totalKota = Kota::count();
        $totalHistory = HistoryPenggunaan::count();
        $recentHistory = HistoryPenggunaan::with('kotaPembanding')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('admin.dashboard', compact('totalKota', 'totalHistory', 'recentHistory'));
    }

    /**
     * Menampilkan daftar kota
     */
    public function indexKota()
    {
        $kota = Kota::orderBy('nama_kota')->get();
        return view('admin.kota.index', compact('kota'));
    }

    /**
     * Menampilkan form tambah kota
     */
    public function createKota()
    {
        return view('admin.kota.create');
    }

    /**
     * Menyimpan kota baru
     */
    public function storeKota(Request $request)
    {
        // Bersihkan format angka (hapus titik pemisah ribuan) sebelum validasi
        $data = $request->all();
        if (isset($data['umr'])) {
            $data['umr'] = str_replace('.', '', $data['umr']);
        }
        if (isset($data['waktu_tempuh'])) {
            $data['waktu_tempuh'] = str_replace('.', '', $data['waktu_tempuh']);
        }
        if (isset($data['jumlah_armada'])) {
            $data['jumlah_armada'] = str_replace('.', '', $data['jumlah_armada']);
        }
        if (isset($data['jumlah_kendaraan_pribadi'])) {
            $data['jumlah_kendaraan_pribadi'] = str_replace('.', '', $data['jumlah_kendaraan_pribadi']);
        }
        if (isset($data['tarif_minimum_aktual'])) {
            $data['tarif_minimum_aktual'] = str_replace('.', '', $data['tarif_minimum_aktual']);
        }

        // Merge data yang sudah dibersihkan ke request
        $request->merge($data);

        $request->validate([
            'nama_kota' => 'required|string|max:255|unique:kota,nama_kota',
            'umr' => 'required|numeric|min:0',
            'waktu_tempuh' => 'required|numeric|min:0',
            'jumlah_armada' => 'required|integer|min:0',
            'jumlah_kendaraan_pribadi' => 'required|integer|min:0',
            'tarif_minimum_aktual' => 'required|numeric|min:0',
        ]);

        Kota::create($data);

        return redirect()->route('admin.kota.index')
            ->with('success', 'Kota berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit kota
     */
    public function editKota($id)
    {
        $kota = Kota::findOrFail($id);
        return view('admin.kota.edit', compact('kota'));
    }

    /**
     * Update kota
     */
    public function updateKota(Request $request, $id)
    {
        $kota = Kota::findOrFail($id);

        // Bersihkan format angka (hapus titik pemisah ribuan) sebelum validasi
        $data = $request->all();
        if (isset($data['umr'])) {
            $data['umr'] = str_replace('.', '', $data['umr']);
        }
        if (isset($data['waktu_tempuh'])) {
            $data['waktu_tempuh'] = str_replace('.', '', $data['waktu_tempuh']);
        }
        if (isset($data['jumlah_armada'])) {
            $data['jumlah_armada'] = str_replace('.', '', $data['jumlah_armada']);
        }
        if (isset($data['jumlah_kendaraan_pribadi'])) {
            $data['jumlah_kendaraan_pribadi'] = str_replace('.', '', $data['jumlah_kendaraan_pribadi']);
        }
        if (isset($data['tarif_minimum_aktual'])) {
            $data['tarif_minimum_aktual'] = str_replace('.', '', $data['tarif_minimum_aktual']);
        }

        // Merge data yang sudah dibersihkan ke request
        $request->merge($data);

        $request->validate([
            'nama_kota' => 'required|string|max:255|unique:kota,nama_kota,' . $id,
            'umr' => 'required|numeric|min:0',
            'waktu_tempuh' => 'required|numeric|min:0',
            'jumlah_armada' => 'required|integer|min:0',
            'jumlah_kendaraan_pribadi' => 'required|integer|min:0',
            'tarif_minimum_aktual' => 'required|numeric|min:0',
        ]);

        $kota->update($data);

        return redirect()->route('admin.kota.index')
            ->with('success', 'Kota berhasil diupdate!');
    }

    /**
     * Hapus kota
     */
    public function destroyKota($id)
    {
        $kota = Kota::findOrFail($id);
        
        // Cek apakah kota digunakan sebagai pembanding di history
        $usedInHistory = HistoryPenggunaan::where('kota_pembanding_id', $id)->exists();
        
        if ($usedInHistory) {
            return redirect()->route('admin.kota.index')
                ->with('error', 'Kota tidak dapat dihapus karena sudah digunakan dalam history!');
        }

        // Hapus hasil perhitungan terkait
        \App\Models\HasilPerhitungan::where('kota_id', $id)->delete();
        \App\Models\TarifRekomendasi::where('kota_acuan_id', $id)
            ->orWhere('kota_banding_id', $id)
            ->delete();
        
        $kota->delete();

        return redirect()->route('admin.kota.index')
            ->with('success', 'Kota berhasil dihapus!');
    }

    /**
     * Menampilkan history penggunaan
     */
    public function history()
    {
        $history = HistoryPenggunaan::with('kotaPembanding')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.history', compact('history'));
    }
}
