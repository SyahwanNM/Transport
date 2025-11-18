# Deployment Checklist - Quick Reference

Checklist cepat untuk deployment ke Hostinger.

## ✅ Pre-Deployment (Lokal)

- [ ] Build assets untuk production:
  ```bash
  npm run build
  ```
- [ ] Test aplikasi di local masih berfungsi
- [ ] Backup database (jika ada data penting)
- [ ] Catat semua environment variables yang digunakan
- [ ] Pastikan `APP_DEBUG=false` di production

## ✅ File Preparation

- [ ] Buat list file yang perlu diupload
- [ ] Exclude file yang tidak perlu:
  - `.git/`
  - `.env` (akan dibuat di server)
  - `node_modules/`
  - `vendor/` (akan diinstall di server)
  - `tests/`
  - `storage/logs/*.log`
  - `database/database.sqlite`

## ✅ Upload ke Server

- [ ] Upload semua file ke `public_html/`
- [ ] Pastikan struktur folder benar
- [ ] Set permission folder `storage/` → 755
- [ ] Set permission folder `bootstrap/cache/` → 755

## ✅ Database Setup

- [ ] Buat database di hPanel
- [ ] Catat: Database name, username, password, host
- [ ] Test koneksi database via phpMyAdmin

## ✅ Environment Configuration

- [ ] Buat file `.env` di server
- [ ] Isi semua konfigurasi:
  - `APP_NAME`
  - `APP_ENV=production`
  - `APP_DEBUG=false`
  - `APP_URL=https://yourdomain.com`
  - `DB_*` (database credentials)
  - `ADMIN_PASSWORD`
- [ ] Generate `APP_KEY`:
  ```bash
  php artisan key:generate
  ```

## ✅ Dependencies Installation

- [ ] Install Composer dependencies:
  ```bash
  composer install --no-dev --optimize-autoloader
  ```
- [ ] Pastikan folder `public/build/` sudah ada (dari npm build)

## ✅ Database Migration & Seeding

- [ ] Run migration:
  ```bash
  php artisan migrate --force
  ```
- [ ] Run seeder:
  ```bash
  php artisan db:seed --force
  ```
- [ ] Atau seed spesifik:
  ```bash
  php artisan db:seed --class=KriteriaSeeder --force
  php artisan db:seed --class=BobotSeeder --force
  php artisan db:seed --class=BandungSeeder --force
  ```

## ✅ Server Configuration

- [ ] Set PHP version ke 8.2+ di hPanel
- [ ] Aktifkan extension PHP yang diperlukan
- [ ] Pastikan document root benar
- [ ] Pastikan `.htaccess` ada di folder `public/`
- [ ] Test mod_rewrite aktif

## ✅ Optimization

- [ ] Clear cache:
  ```bash
  php artisan config:clear
  php artisan cache:clear
  php artisan route:clear
  php artisan view:clear
  ```
- [ ] Cache untuk production:
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  ```

## ✅ Testing

- [ ] Test halaman utama: `https://yourdomain.com`
- [ ] Test form input dan submit
- [ ] Test hasil perhitungan muncul
- [ ] Test admin login: `https://yourdomain.com/admin/login`
- [ ] Test admin dashboard
- [ ] Test CRUD kota pembanding
- [ ] Test view history
- [ ] Test error handling (404, 500)
- [ ] Test di mobile device (responsive)

## ✅ Security

- [ ] Pastikan `APP_DEBUG=false`
- [ ] Pastikan `APP_ENV=production`
- [ ] Ubah password admin default
- [ ] Aktifkan HTTPS/SSL
- [ ] Pastikan `.env` tidak bisa diakses via browser
- [ ] Cek permission file dan folder

## ✅ Final Checks

- [ ] Semua fitur berfungsi dengan baik
- [ ] Tidak ada error di log: `storage/logs/laravel.log`
- [ ] Database terhubung dengan benar
- [ ] Assets (CSS/JS) muncul dengan benar
- [ ] Form validation berfungsi
- [ ] Session berfungsi (login/logout)

## 📝 Notes

**Jika ada masalah:**
1. Cek log: `storage/logs/laravel.log`
2. Cek `.env` configuration
3. Cek database connection
4. Cek file permissions
5. Hubungi support Hostinger jika perlu

**URL Penting:**
- Home: `https://yourdomain.com`
- Admin: `https://yourdomain.com/admin/login`
- phpMyAdmin: (dari hPanel)

---

**Status:** ⬜ Belum mulai | 🟡 Sedang proses | ✅ Selesai

