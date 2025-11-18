# Arsitektur Sistem Perhitungan Rekomendasi Multikriteria Tarif Transportasi Online

## Overview

Sistem ini adalah versi baru dari project lama yang menggunakan metode **Analytic Hierarchy Process (AHP)** dan **Simple Additive Weighting (SAW)** untuk menghitung rekomendasi tarif transportasi online.

### Perbedaan dengan Project Lama

| Aspek | Project Lama | Project Baru |
|-------|-------------|--------------|
| **Input Data** | Admin input semua data kota | User input data kotanya sendiri |
| **Perbandingan** | User pilih 2 kota dari database | Sistem otomatis bandingkan dengan Bandung (fixed) |
| **Alur** | Multi-step dengan admin panel | Single flow: Form → Calculate → Result |
| **UI** | Traditional Bootstrap | Modern TailwindCSS |

## Struktur Folder

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── ComparisonController.php    # Controller baru untuk routing utama
│   │   └── AhpSawController.php         # Controller lama (dipertahankan untuk referensi)
│   └── Requests/
│       └── CompareCityRequest.php       # Request validation untuk form input
├── Models/
│   ├── Kota.php                         # Model kota (tidak berubah)
│   ├── Kriteria.php                     # Model kriteria (tidak berubah)
│   ├── Bobot.php                        # Model bobot (tidak berubah)
│   ├── HasilPerhitungan.php            # Model hasil perhitungan (tidak berubah)
│   └── TarifRekomendasi.php            # Model tarif rekomendasi (tidak berubah)
└── Services/
    └── MultikriteriaCalculationService.php  # Service class untuk logika perhitungan

resources/
└── views/
    └── comparison/
        ├── form.blade.php               # Form input user (UI baru)
        └── result.blade.php             # Hasil perbandingan (UI baru)

database/
└── seeders/
    └── BandungSeeder.php                # Seeder untuk data Bandung (fixed reference)
```

## Routing

### Routes Baru (Project Baru)

```php
GET  /              → ComparisonController@index    (Form input)
POST /compare       → ComparisonController@compare  (Proses perhitungan)
GET  /result        → ComparisonController@result   (Tampilkan hasil)
```

### Routes Lama (Dipertahankan)

Routes lama tetap ada untuk referensi dan kompatibilitas, tetapi tidak digunakan dalam flow baru.

## Alur Aplikasi

### 1. Form Input (GET /)

User mengisi form dengan data:
- `city_name`: Nama kota
- `umr`: Upah Minimum Regional
- `avg_time`: Waktu tempuh rata-rata (detik per km)
- `armada_count`: Jumlah armada ojek online
- `private_vehicle`: Jumlah kendaraan pribadi
- `actual_min_tarif`: Tarif minimum aktual

### 2. Proses Perhitungan (POST /compare)

1. **Validasi Input**: `CompareCityRequest` memvalidasi semua field
2. **Ambil Data Bandung**: Query database untuk kota Bandung (fixed reference)
3. **Buat Kota Temporary**: Simpan data user ke database sementara
4. **Hitung SAW**: Panggil `MultikriteriaCalculationService::hitungSaw()`
5. **Hitung Tarif Rekomendasi**: Panggil `MultikriteriaCalculationService::hitungTarifRekomendasi()`
6. **Simpan ke Session**: Simpan hasil ke session untuk ditampilkan
7. **Hapus Kota Temporary**: Hapus data temporary dari database
8. **Redirect ke Result**: Redirect ke `/result`

### 3. Tampilkan Hasil (GET /result)

1. **Ambil dari Session**: Ambil data hasil perhitungan dari session
2. **Tampilkan Perbandingan**: Tampilkan perbandingan antara kota user dan Bandung
3. **Tampilkan Rekomendasi**: Tampilkan tarif rekomendasi dan selisih

## Service Layer: MultikriteriaCalculationService

Service ini berisi **logika perhitungan yang tidak boleh diubah** dari project lama.

### Methods

#### `hitungSaw(Collection $kota)`
Melakukan perhitungan SAW untuk semua kota yang diberikan.

**Algoritma:**
1. Ambil semua kriteria dan bobot dari database
2. Untuk setiap kota:
   - Hitung nilai kriteria untuk setiap kriteria
   - Normalisasi nilai menggunakan SAW
   - Hitung skor preferensi (normalisasi × bobot)
   - Simpan ke tabel `hasil_perhitungan`

#### `getNilaiKriteria(Kota $kota, string $kodeKriteria): float`
Mendapatkan nilai kriteria untuk kota tertentu.

**Mapping:**
- `C1`: UMR / tarif_minimum_aktual (jika ada), atau UMR saja
- `C2`: waktu_tempuh
- `C3`: jumlah_armada
- `C4`: jumlah_kendaraan_pribadi

#### `hitungNormalisasi(float $nilai, Kriteria $kriteria, Collection $semuaKota): float`
Menghitung normalisasi SAW.

**Formula:**
- **Benefit**: `nilai / max(nilai_semua_kota)`
- **Cost**: `min(nilai_semua_kota) / nilai`

#### `hitungTarifRekomendasi(Kota $kotaAcuan, Kota $kotaBanding): TarifRekomendasi`
Menghitung tarif rekomendasi berdasarkan perbandingan skor.

**Formula:**
```
rasio_skor = skor_banding / skor_acuan
tarif_rekomendasi = tarif_acuan × rasio_skor
```

## Database

### Tabel yang Digunakan

1. **kota**: Menyimpan data kota
   - Bandung: Fixed reference (di-seed)
   - User kota: Temporary (dibuat saat perhitungan, dihapus setelahnya)

2. **kriteria**: Kriteria penilaian (C1-C4)
   - C1: Keterjangkauan/UMR (benefit)
   - C2: Waktu Tempuh (cost)
   - C3: Jumlah Armada (benefit)
   - C4: Jumlah Kendaraan Pribadi (cost)

3. **bobot**: Bobot AHP untuk setiap kriteria
   - C1: 0.33
   - C2: 0.31
   - C3: 0.29
   - C4: 0.06

4. **hasil_perhitungan**: Hasil perhitungan SAW untuk setiap kota dan kriteria

5. **tarif_rekomendasi**: Hasil perbandingan dan rekomendasi tarif

## Setup & Installation

### 1. Install Dependencies

```bash
composer install
npm install
```

### 2. Setup Database

```bash
php artisan migrate
php artisan db:seed --class=KriteriaSeeder
php artisan db:seed --class=BobotSeeder
php artisan db:seed --class=BandungSeeder
```

### 3. Build Assets

```bash
npm run build
# atau untuk development
npm run dev
```

### 4. Run Application

```bash
php artisan serve
```

## Catatan Penting

### ⚠️ Logika Perhitungan Tidak Boleh Diubah

Semua logika perhitungan di `MultikriteriaCalculationService` **TIDAK BOLEH DIUBAH**. Logika ini diambil langsung dari `AhpSawController` project lama dan hanya dipindahkan ke Service class untuk reusability.

### ✅ Yang Boleh Diubah

- UI/UX (views)
- Routing
- Controller logic (selain perhitungan)
- Validasi
- Error handling

### 🔄 Data Bandung

Data Bandung adalah **fixed reference** dan harus selalu ada di database. Gunakan `BandungSeeder` untuk memastikan data Bandung tersedia.

## Troubleshooting

### Error: "Data kota Bandung tidak ditemukan"

**Solusi**: Jalankan seeder Bandung
```bash
php artisan db:seed --class=BandungSeeder
```

### Error: "Tidak ada data perbandingan"

**Solusi**: Pastikan Anda mengisi form dan submit terlebih dahulu sebelum mengakses `/result`.

### Hasil perhitungan tidak muncul

**Solusi**: 
1. Pastikan kriteria dan bobot sudah di-seed
2. Check log Laravel untuk error detail
3. Pastikan session driver berfungsi dengan baik

