# Sistem Perhitungan Rekomendasi Multikriteria Tarif Transportasi Online

## Quick Start

### 1. Setup Database

```bash
php artisan migrate
php artisan db:seed
```

### 2. Build Assets

```bash
npm install
npm run build
```

### 3. Run Server

```bash
php artisan serve
```

### 4. Akses Aplikasi

Buka browser dan akses: `http://localhost:8000`

## Struktur File Baru

```
app/
├── Http/
│   ├── Controllers/
│   │   └── ComparisonController.php      # Controller utama
│   └── Requests/
│       └── CompareCityRequest.php         # Validasi form
├── Services/
│   └── MultikriteriaCalculationService.php  # Logika perhitungan (TIDAK BOLEH DIUBAH)
└── Models/                                 # Models (tidak berubah)

resources/views/
└── comparison/
    ├── form.blade.php                     # Form input user
    └── result.blade.php                   # Hasil perbandingan

database/seeders/
└── BandungSeeder.php                      # Data Bandung (fixed reference)
```

## Routing

- `GET /` → Form input data kota
- `POST /compare` → Proses perhitungan
- `GET /result` → Tampilkan hasil

## Data Bandung

Data Bandung adalah **fixed reference** dan harus selalu ada di database. Data ini digunakan sebagai acuan untuk perbandingan.

**Data Bandung:**
- UMR: 4,209,309
- Waktu Tempuh: 1957 detik/km
- Jumlah Armada: 30,000
- Kendaraan Pribadi: 2,360,000
- Tarif Minimum: 6,000

## Dokumentasi Lengkap

- `ARCHITECTURE.md` - Dokumentasi arsitektur lengkap
- `MIGRATION_GUIDE.md` - Panduan migrasi dari project lama

## Catatan Penting

⚠️ **Logika perhitungan di `MultikriteriaCalculationService` TIDAK BOLEH DIUBAH!**

Logika ini diambil langsung dari project lama dan hanya dipindahkan ke Service class untuk reusability.

## Troubleshooting

### Data Bandung tidak ditemukan
```bash
php artisan db:seed --class=BandungSeeder
```

### View tidak ditemukan
Pastikan file di `resources/views/comparison/` sudah ada.

### Route tidak ditemukan
Pastikan routes sudah di-update di `routes/web.php`.

