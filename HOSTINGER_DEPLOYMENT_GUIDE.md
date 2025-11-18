# Panduan Deployment ke Hostinger

Panduan lengkap untuk meng-host project Laravel ini di Hostinger.

## 📋 Daftar Isi

1. [Persyaratan Server](#persyaratan-server)
2. [Persiapan File](#persiapan-file)
3. [Upload ke Hostinger](#upload-ke-hostinger)
4. [Konfigurasi Database](#konfigurasi-database)
5. [Konfigurasi Environment](#konfigurasi-environment)
6. [Konfigurasi Server](#konfigurasi-server)
7. [Installasi Dependencies](#installasi-dependencies)
8. [Setup Database](#setup-database)
9. [Optimasi untuk Production](#optimasi-untuk-production)
10. [Testing](#testing)
11. [Troubleshooting](#troubleshooting)

---

## 🔧 Persyaratan Server

### Minimum Requirements (Hostinger Shared Hosting)

- **PHP Version**: 8.2 atau lebih tinggi
- **MySQL**: 5.7+ atau MariaDB 10.3+
- **Extensions PHP yang Diperlukan**:
  - `php-mbstring`
  - `php-xml`
  - `php-curl`
  - `php-zip`
  - `php-gd`
  - `php-mysql`
  - `php-openssl`
  - `php-json`
  - `php-fileinfo`
  - `php-tokenizer`
  - `php-pdo`

### Cek Versi PHP di Hostinger

1. Login ke **hPanel** Hostinger
2. Buka **Advanced** → **PHP Configuration**
3. Pilih PHP 8.2 atau lebih tinggi
4. Pastikan semua extension di atas aktif

---

## 📦 Persiapan File

### 1. File yang TIDAK Perlu Diupload

Buat file `.htaccess` di root project untuk mengecualikan file yang tidak perlu:

```htaccess
# .htaccess untuk .gitignore (opsional, untuk keamanan)
```

**File/Folder yang TIDAK perlu diupload:**
- `.git/` (jika menggunakan Git)
- `.env` (akan dibuat di server)
- `node_modules/`
- `tests/`
- `vendor/` (akan diinstall di server)
- `storage/logs/*.log`
- `storage/framework/cache/*`
- `storage/framework/sessions/*`
- `storage/framework/views/*`
- `.idea/` (jika menggunakan IDE)
- `.vscode/`
- `database/database.sqlite` (jika ada)

### 2. File yang HARUS Diupload

**Semua file berikut HARUS diupload:**
- `app/`
- `bootstrap/`
- `config/`
- `database/` (kecuali `database.sqlite`)
- `public/`
- `resources/`
- `routes/`
- `storage/` (folder kosong, pastikan permission 755)
- `artisan`
- `composer.json`
- `composer.lock`
- `package.json`
- `package-lock.json`
- `vite.config.js`
- `phpunit.xml`
- `.htaccess` (jika ada di root)

### 3. Struktur Folder di Server

Setelah upload, struktur folder di Hostinger seharusnya:

```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/          ← File di folder ini yang diakses via web
│   ├── index.php
│   ├── .htaccess
│   └── build/
├── resources/
├── routes/
├── storage/
├── vendor/         ← Akan dibuat setelah composer install
├── node_modules/   ← Akan dibuat setelah npm install
├── artisan
├── composer.json
├── package.json
└── .env            ← Akan dibuat manual
```

**⚠️ PENTING**: Di Hostinger, folder `public/` harus dipindahkan isinya ke `public_html/` atau konfigurasi document root.

---

## 📤 Upload ke Hostinger

### Metode 1: File Manager (Recommended untuk pertama kali)

1. Login ke **hPanel** Hostinger
2. Buka **File Manager**
3. Masuk ke folder `public_html/` atau `domains/yourdomain.com/public_html/`
4. Upload semua file (gunakan **Upload Files** atau **Upload Folder**)
5. Tunggu hingga proses upload selesai

### Metode 2: FTP/SFTP

1. Dapatkan kredensial FTP dari hPanel:
   - **FTP Host**: `ftp.yourdomain.com` atau IP server
   - **FTP Username**: (dari hPanel)
   - **FTP Password**: (dari hPanel)
   - **Port**: 21 (FTP) atau 22 (SFTP)

2. Gunakan FTP client (FileZilla, WinSCP, dll):
   ```
   Host: ftp.yourdomain.com
   Username: [username dari hPanel]
   Password: [password dari hPanel]
   Port: 21
   ```

3. Upload semua file ke `public_html/`

### Metode 3: Git (Jika Hostinger Support)

1. SSH ke server (jika tersedia)
2. Clone repository:
   ```bash
   git clone https://github.com/yourusername/your-repo.git
   ```

---

## 🗄️ Konfigurasi Database

### 1. Buat Database di Hostinger

1. Login ke **hPanel**
2. Buka **Databases** → **MySQL Databases**
3. Klik **Create Database**
4. Isi:
   - **Database Name**: `hitungtarif_db` (atau sesuai keinginan)
   - **Username**: (akan dibuat otomatis atau buat manual)
   - **Password**: (buat password yang kuat)
5. Klik **Create**
6. **Catat informasi berikut:**
   - Database Name
   - Database Username
   - Database Password
   - Database Host (biasanya `localhost`)

### 2. Import Database (Opsional - jika ada)

Jika Anda sudah punya database backup:

1. Buka **phpMyAdmin** dari hPanel
2. Pilih database yang baru dibuat
3. Klik **Import**
4. Upload file `.sql` backup
5. Klik **Go**

---

## ⚙️ Konfigurasi Environment

### 1. Buat File `.env`

1. Di **File Manager**, buka folder `public_html/`
2. Buat file baru bernama `.env`
3. Copy template berikut dan sesuaikan:

```env
APP_NAME="Sistem Perhitungan Tarif"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_TIMEZONE=Asia/Jakarta
APP_URL=https://yourdomain.com

APP_LOCALE=id
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=id_ID

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=username_database_anda
DB_PASSWORD=password_database_anda

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

# Admin Password (untuk login admin panel)
ADMIN_PASSWORD=admin123

# AWS_ACCESS_KEY_ID=
# AWS_SECRET_ACCESS_KEY=
# AWS_DEFAULT_REGION=us-east-1
# AWS_BUCKET=
# AWS_USE_PATH_STYLE_ENDPOINT=false

# VITE_APP_NAME="${APP_NAME}"
```

### 2. Generate Application Key

Setelah membuat `.env`, generate application key:

**Via SSH (jika tersedia):**
```bash
cd public_html
php artisan key:generate
```

**Via File Manager + Terminal (jika tidak ada SSH):**
1. Buka **Terminal** di hPanel
2. Masuk ke folder project:
   ```bash
   cd public_html
   ```
3. Jalankan:
   ```bash
   php artisan key:generate
   ```

**Atau manual:**
Jika tidak bisa akses terminal, buka file `.env` dan tambahkan:
```env
APP_KEY=base64:PASTE_KEY_DARI_LOCAL_DISINI
```
(Copy `APP_KEY` dari `.env` di local development)

---

## 🖥️ Konfigurasi Server

### 1. Set Document Root

Di Hostinger, biasanya document root adalah `public_html/`. 

**Jika struktur folder Anda:**
```
public_html/
├── app/
├── public/
│   └── index.php
└── ...
```

**Maka perlu konfigurasi:**

**Opsi A: Pindahkan isi `public/` ke `public_html/`**
1. Pindahkan semua file dari `public/` ke `public_html/`
2. Update path di `public_html/index.php`:
   ```php
   require __DIR__.'/../vendor/autoload.php';
   $app = require_once __DIR__.'/../bootstrap/app.php';
   ```

**Opsi B: Ubah Document Root (jika bisa)**
1. Di hPanel, buka **Advanced** → **Domain**
2. Ubah Document Root ke `public_html/public`
3. Atau hubungi support Hostinger untuk mengubah document root

### 2. Set Permission Folder

Set permission untuk folder berikut:

1. Buka **File Manager**
2. Klik kanan pada folder, pilih **Change Permissions**
3. Set permission:
   - `storage/` → **755** (atau **775**)
   - `storage/framework/` → **755**
   - `storage/framework/cache/` → **755**
   - `storage/framework/sessions/` → **755**
   - `storage/framework/views/` → **755**
   - `storage/logs/` → **755**
   - `bootstrap/cache/` → **755**

**Via Terminal (jika ada SSH):**
```bash
cd public_html
chmod -R 755 storage bootstrap/cache
```

### 3. Buat File `.htaccess` di Root (jika perlu)

Jika document root adalah `public_html/` (bukan `public_html/public/`), buat file `.htaccess` di root:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

---

## 📥 Installasi Dependencies

### 1. Install Composer Dependencies

**Via SSH:**
```bash
cd public_html
composer install --no-dev --optimize-autoloader
```

**Via Terminal di hPanel:**
1. Buka **Terminal** di hPanel
2. Masuk ke folder project:
   ```bash
   cd public_html
   ```
3. Install dependencies:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

**Jika Composer tidak tersedia:**
1. Download Composer di local: https://getcomposer.org/download/
2. Upload file `composer.phar` ke `public_html/`
3. Jalankan:
   ```bash
   php composer.phar install --no-dev --optimize-autoloader
   ```

### 2. Install NPM Dependencies (Opsional)

Jika perlu build assets:

**Via SSH:**
```bash
cd public_html
npm install
npm run build
```

**Catatan:** Di shared hosting, biasanya tidak perlu install npm jika sudah build di local. Upload saja folder `public/build/` yang sudah di-build.

---

## 🗃️ Setup Database

### 1. Run Migration

**Via SSH:**
```bash
cd public_html
php artisan migrate --force
```

**Via Terminal di hPanel:**
```bash
cd public_html
php artisan migrate --force
```

### 2. Run Seeder

**Via SSH:**
```bash
php artisan db:seed --force
```

Atau seed spesifik:
```bash
php artisan db:seed --class=KriteriaSeeder --force
php artisan db:seed --class=BobotSeeder --force
php artisan db:seed --class=BandungSeeder --force
```

---

## 🚀 Optimasi untuk Production

### 1. Clear dan Cache

**Via SSH/Terminal:**
```bash
cd public_html

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Cache untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Optimize Autoloader

```bash
composer install --optimize-autoloader --no-dev
```

### 3. Set APP_DEBUG=false

Pastikan di `.env`:
```env
APP_DEBUG=false
APP_ENV=production
```

### 4. Set Permission (jika belum)

```bash
chmod -R 755 storage bootstrap/cache
```

---

## ✅ Testing

### 1. Test Halaman Utama

1. Buka browser
2. Akses: `https://yourdomain.com`
3. Pastikan halaman form muncul dengan benar

### 2. Test Form Input

1. Isi form dengan data test
2. Submit form
3. Pastikan hasil perhitungan muncul

### 3. Test Admin Panel

1. Akses: `https://yourdomain.com/admin/login`
2. Login dengan password admin
3. Test fitur:
   - Dashboard
   - Tambah/Edit/Hapus Kota
   - View History

### 4. Test Database

1. Login ke phpMyAdmin
2. Cek tabel:
   - `kota`
   - `kriteria`
   - `bobot`
   - `history_penggunaan`
3. Pastikan data ada

### 5. Test Error Handling

1. Coba akses URL yang tidak ada
2. Pastikan error page muncul (bukan debug info)

---

## 🔧 Troubleshooting

### Error: "500 Internal Server Error"

**Solusi:**
1. Cek file `.env` sudah benar
2. Cek `APP_KEY` sudah di-generate
3. Cek permission folder `storage/` dan `bootstrap/cache/`
4. Cek log error di `storage/logs/laravel.log`

**Cek log:**
```bash
tail -f storage/logs/laravel.log
```

### Error: "Class not found" atau "Autoload error"

**Solusi:**
```bash
composer dump-autoload
php artisan optimize:clear
php artisan config:cache
```

### Error: "Database connection failed"

**Solusi:**
1. Cek kredensial database di `.env`
2. Pastikan database sudah dibuat
3. Cek `DB_HOST` (biasanya `127.0.0.1` atau `localhost`)
4. Test koneksi via phpMyAdmin

### Error: "Permission denied" untuk storage

**Solusi:**
```bash
chmod -R 755 storage bootstrap/cache
```

Atau via File Manager, set permission folder ke **755**

### Error: "Route not found" atau 404

**Solusi:**
1. Pastikan `.htaccess` ada di folder `public/`
2. Pastikan mod_rewrite aktif
3. Clear route cache:
   ```bash
   php artisan route:clear
   php artisan route:cache
   ```

### Error: "Vite manifest not found"

**Solusi:**
1. Pastikan folder `public/build/` sudah di-upload
2. Atau build assets:
   ```bash
   npm run build
   ```

### Error: "Session driver [database] not available"

**Solusi:**
1. Pastikan migration sudah dijalankan:
   ```bash
   php artisan migrate
   ```
2. Atau ubah `SESSION_DRIVER` di `.env`:
   ```env
   SESSION_DRIVER=file
   ```

### CSS/JS tidak muncul

**Solusi:**
1. Pastikan `APP_URL` di `.env` benar:
   ```env
   APP_URL=https://yourdomain.com
   ```
2. Clear cache:
   ```bash
   php artisan view:clear
   php artisan config:clear
   ```
3. Pastikan folder `public/build/` sudah di-upload

### Admin login tidak berfungsi

**Solusi:**
1. Cek `ADMIN_PASSWORD` di `.env`
2. Pastikan session driver berfungsi
3. Clear cache:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

---

## 📝 Checklist Deployment

Gunakan checklist ini untuk memastikan semua langkah sudah dilakukan:

- [ ] PHP 8.2+ sudah aktif
- [ ] Semua extension PHP sudah aktif
- [ ] File sudah di-upload ke server
- [ ] Database sudah dibuat
- [ ] File `.env` sudah dibuat dan dikonfigurasi
- [ ] `APP_KEY` sudah di-generate
- [ ] Permission folder `storage/` dan `bootstrap/cache/` sudah di-set (755)
- [ ] Composer dependencies sudah di-install
- [ ] Migration sudah dijalankan
- [ ] Seeder sudah dijalankan
- [ ] Cache sudah di-clear dan di-cache ulang
- [ ] `APP_DEBUG=false` di `.env`
- [ ] Document root sudah benar
- [ ] `.htaccess` sudah ada di folder `public/`
- [ ] Halaman utama bisa diakses
- [ ] Form input berfungsi
- [ ] Admin panel bisa diakses
- [ ] Database terhubung dengan benar

---

## 🔒 Keamanan Tambahan

### 1. Ubah Password Admin

Di file `.env`:
```env
ADMIN_PASSWORD=password_yang_sangat_kuat_disini
```

### 2. Aktifkan HTTPS

1. Install SSL certificate (biasanya gratis di Hostinger)
2. Pastikan `APP_URL` menggunakan `https://`

### 3. Hide Sensitive Files

Pastikan file `.env` tidak bisa diakses via browser. Hostinger biasanya sudah mengatur ini, tapi pastikan dengan membuat `.htaccess` di root:

```apache
<Files .env>
    Order allow,deny
    Deny from all
</Files>
```

### 4. Update Laravel

Pastikan menggunakan versi Laravel terbaru:
```bash
composer update
```

---

## 📞 Support

Jika mengalami masalah:

1. **Cek Log Error:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Hubungi Support Hostinger:**
   - Live Chat di hPanel
   - Email support
   - Ticket system

3. **Cek Dokumentasi Laravel:**
   - https://laravel.com/docs/deployment

---

## 🎉 Selesai!

Setelah semua langkah di atas selesai, aplikasi Anda seharusnya sudah berjalan di Hostinger!

**URL Aplikasi:**
- Home: `https://yourdomain.com`
- Admin: `https://yourdomain.com/admin/login`

**Selamat! Aplikasi Anda sudah online! 🚀**

