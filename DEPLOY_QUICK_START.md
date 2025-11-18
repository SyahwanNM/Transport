# 🚀 Quick Start Deployment Guide

Panduan cepat untuk deployment aplikasi ke server production.

## 📋 Pre-Deployment (Lokal)

### 1. Jalankan Script Deployment

**Windows:**
```bash
deploy.bat
```

**Linux/Mac:**
```bash
chmod +x deploy.sh
./deploy.sh
```

Script ini akan:
- ✅ Build assets untuk production (`npm run build`)
- ✅ Clear cache lokal
- ✅ Optimize composer autoloader
- ✅ Verifikasi file penting

### 2. Manual Build (Jika Script Tidak Bisa)

```bash
# Build assets
npm run build

# Optimize composer
composer install --no-dev --optimize-autoloader

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

## 📤 Upload ke Server

### File yang HARUS Diupload:
- ✅ `app/`
- ✅ `bootstrap/`
- ✅ `config/`
- ✅ `database/` (kecuali `database.sqlite`)
- ✅ `public/` (termasuk `public/build/`)
- ✅ `resources/`
- ✅ `routes/`
- ✅ `storage/` (folder kosong dengan struktur)
- ✅ `artisan`
- ✅ `composer.json`
- ✅ `composer.lock`
- ✅ `.htaccess` (di root)
- ✅ `.htaccess` (di `public/`)

### File yang TIDAK Perlu Diupload:
- ❌ `.env` (buat baru di server)
- ❌ `vendor/` (install di server)
- ❌ `node_modules/` (tidak perlu)
- ❌ `tests/`
- ❌ `.git/`
- ❌ `database/database.sqlite`

## ⚙️ Setup di Server

### 1. Buat File `.env`

Copy dari template dan sesuaikan:

```env
APP_NAME="Sistem Perhitungan Tarif"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_TIMEZONE=Asia/Jakarta
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=username_database_anda
DB_PASSWORD=password_database_anda

SESSION_DRIVER=database
CACHE_STORE=database

ADMIN_PASSWORD=password_kuat_disini
```

### 2. Set Permission

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### 3. Install Dependencies

```bash
composer install --no-dev --optimize-autoloader
```

### 4. Generate APP_KEY

```bash
php artisan key:generate
```

### 5. Setup Database

```bash
# Run migration
php artisan migrate --force

# Run seeder
php artisan db:seed --force
```

### 6. Optimize untuk Production

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## ✅ Testing

1. Buka browser: `https://yourdomain.com`
2. Test form input dan submit
3. Test admin login: `https://yourdomain.com/admin/login`
4. Test semua fitur

## 🔧 Troubleshooting

### Error 500
- Cek `.env` sudah benar
- Cek `APP_KEY` sudah di-generate
- Cek permission `storage/` dan `bootstrap/cache/`
- Cek log: `storage/logs/laravel.log`

### CSS/JS tidak muncul
- Pastikan `public/build/` sudah di-upload
- Pastikan `APP_URL` di `.env` benar
- Clear cache: `php artisan view:clear`

### Database error
- Cek kredensial database di `.env`
- Pastikan database sudah dibuat
- Pastikan migration sudah dijalankan

## 📝 Checklist Final

- [ ] Assets sudah di-build
- [ ] File sudah di-upload ke server
- [ ] File `.env` sudah dibuat dan dikonfigurasi
- [ ] `APP_KEY` sudah di-generate
- [ ] Permission folder sudah di-set (755)
- [ ] Dependencies sudah di-install
- [ ] Migration sudah dijalankan
- [ ] Seeder sudah dijalankan
- [ ] Cache sudah di-optimalkan
- [ ] `APP_DEBUG=false` di `.env`
- [ ] Aplikasi bisa diakses
- [ ] Semua fitur berfungsi

---

**Selamat! Aplikasi Anda sudah online! 🎉**

