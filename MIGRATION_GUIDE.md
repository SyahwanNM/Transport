# Panduan Migrasi: Project Lama → Project Baru

## Overview

Dokumen ini menjelaskan langkah-langkah migrasi dari project lama ke project baru, termasuk perubahan yang dilakukan dan file yang dapat dihapus.

## Perubahan Utama

### 1. Routing

**Lama:**
```php
Route::get('/', function () {
    return view('dashboard');
});
```

**Baru:**
```php
Route::get('/', [ComparisonController::class, 'index'])->name('comparison.index');
Route::post('/compare', [ComparisonController::class, 'compare'])->name('comparison.compare');
Route::get('/result', [ComparisonController::class, 'result'])->name('comparison.result');
```

### 2. Controller

**Lama:** `AhpSawController` - Berisi semua logika perhitungan

**Baru:** 
- `ComparisonController` - Handle routing baru
- `MultikriteriaCalculationService` - Extract logika perhitungan

### 3. Views

**Lama:** 
- `ahp-saw/*` - Views untuk admin dan perhitungan
- `dashboard.blade.php` - Dashboard utama

**Baru:**
- `comparison/form.blade.php` - Form input user
- `comparison/result.blade.php` - Hasil perbandingan

### 4. Data Flow

**Lama:**
1. Admin input data kota → Database
2. Admin jalankan perhitungan → Semua kota dihitung
3. User pilih 2 kota → Bandingkan

**Baru:**
1. User input data kota → Temporary di database
2. Sistem otomatis bandingkan dengan Bandung
3. Tampilkan hasil → Hapus data temporary

## Step-by-Step Migration

### Step 1: Backup Project Lama

```bash
# Buat backup dari project lama
cp -r HitungTarif HitungTarif-backup
```

### Step 2: Install Dependencies Baru

Dependencies sudah terinstall (TailwindCSS sudah ada di package.json).

### Step 3: Run Migrations & Seeders

```bash
# Pastikan database sudah di-migrate
php artisan migrate

# Seed kriteria dan bobot (jika belum)
php artisan db:seed --class=KriteriaSeeder
php artisan db:seed --class=BobotSeeder

# Seed data Bandung (penting!)
php artisan db:seed --class=BandungSeeder
```

### Step 4: Test Routing Baru

1. Akses `http://localhost:8000/` → Harus muncul form input
2. Isi form dan submit → Harus redirect ke `/result`
3. Cek hasil perbandingan → Harus tampil dengan benar

### Step 5: Cleanup (Opsional)

File-file berikut **dapat dihapus** jika tidak diperlukan lagi:

#### Controllers (Opsional)
- `app/Http/Controllers/AdminController.php` - Jika tidak butuh admin panel
- `app/Http/Controllers/AuthController.php` - Jika tidak butuh authentication

#### Views (Opsional)
- `resources/views/admin/*` - Jika tidak butuh admin panel
- `resources/views/ahp-saw/*` - Views lama (kecuali untuk referensi)
- `resources/views/dashboard.blade.php` - Dashboard lama
- `resources/views/hitungtarif.blade.php` - View lama

#### Routes (Opsional)
Hapus routes lama dari `routes/web.php` jika tidak diperlukan:
- Routes `/ahp-saw/*`
- Routes `/admin/*`
- Routes `/login`, `/logout`

**⚠️ Catatan**: Sebelum menghapus, pastikan tidak ada dependency yang masih menggunakan file-file tersebut.

## File yang Wajib Dipertahankan

### Models
- ✅ `app/Models/Kota.php`
- ✅ `app/Models/Kriteria.php`
- ✅ `app/Models/Bobot.php`
- ✅ `app/Models/HasilPerhitungan.php`
- ✅ `app/Models/TarifRekomendasi.php`

### Migrations
- ✅ `database/migrations/2025_09_29_030114_create_tables_for_ahp_saw_system.php`
- ✅ `database/migrations/2025_09_29_082232_add_nilai_asli_and_bobot_to_hasil_perhitungan_table.php`

### Seeders
- ✅ `database/seeders/KriteriaSeeder.php`
- ✅ `database/seeders/BobotSeeder.php`
- ✅ `database/seeders/BandungSeeder.php` (baru)

## Testing Checklist

### ✅ Functional Testing

- [ ] Form input dapat diisi dengan benar
- [ ] Validasi form bekerja (test dengan data invalid)
- [ ] Perhitungan menghasilkan hasil yang benar
- [ ] Hasil perbandingan tampil dengan benar
- [ ] Data temporary dihapus setelah perhitungan

### ✅ Data Integrity

- [ ] Data Bandung selalu ada di database
- [ ] Kriteria dan bobot sudah di-seed
- [ ] Hasil perhitungan tersimpan dengan benar
- [ ] Session menyimpan data dengan benar

### ✅ UI/UX Testing

- [ ] Form responsive di mobile
- [ ] Hasil perbandingan mudah dibaca
- [ ] Error messages jelas dan informatif
- [ ] Loading state (jika ada) bekerja dengan baik

## Rollback Plan

Jika terjadi masalah, rollback dengan:

1. **Restore dari backup:**
```bash
rm -rf HitungTarif
cp -r HitungTarif-backup HitungTarif
```

2. **Atau revert perubahan:**
```bash
git checkout HEAD -- routes/web.php
# Hapus file baru
rm app/Http/Controllers/ComparisonController.php
rm app/Services/MultikriteriaCalculationService.php
# dll...
```

## Troubleshooting

### Issue: "Class 'App\Services\MultikriteriaCalculationService' not found"

**Solusi**: Run `composer dump-autoload`

### Issue: "Route [comparison.index] not defined"

**Solusi**: Pastikan routes sudah di-update di `routes/web.php`

### Issue: "View [comparison.form] not found"

**Solusi**: Pastikan file `resources/views/comparison/form.blade.php` sudah dibuat

### Issue: "Data Bandung tidak ditemukan"

**Solusi**: 
```bash
php artisan db:seed --class=BandungSeeder
```

## Next Steps (Opsional Enhancement)

Setelah migrasi berhasil, pertimbangkan untuk:

1. **Caching**: Cache data Bandung dan kriteria untuk performa
2. **Queue**: Pindahkan perhitungan ke queue untuk handle request besar
3. **API**: Buat API endpoint untuk integrasi dengan sistem lain
4. **Export**: Tambahkan fitur export hasil ke PDF/Excel
5. **History**: Simpan history perhitungan user (jika perlu)
6. **Validation Enhancement**: Tambahkan validasi lebih ketat (range values, dll)

## Support

Jika ada pertanyaan atau masalah selama migrasi, referensi:
- `ARCHITECTURE.md` - Dokumentasi arsitektur
- `AhpSawController.php` - Referensi logika lama
- Laravel Documentation - https://laravel.com/docs

