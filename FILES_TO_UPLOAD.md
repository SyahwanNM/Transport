# File yang Perlu Diupload ke Hostinger

Daftar lengkap file dan folder yang perlu diupload ke server.

## ✅ File/Folder yang HARUS Diupload

### Core Laravel Files
```
app/
bootstrap/
config/
database/
  ├── migrations/
  ├── seeders/
  └── factories/
routes/
resources/
  ├── css/
  ├── js/
  └── views/
public/
  ├── index.php
  ├── .htaccess
  ├── build/          ← Penting! Folder build dari npm run build
  └── images/
storage/               ← Upload folder kosong, set permission 755
  ├── app/
  ├── framework/
  └── logs/
artisan
composer.json
composer.lock
package.json
package-lock.json
vite.config.js
phpunit.xml
```

### File Konfigurasi
- `.htaccess` (di root, jika diperlukan)
- `.htaccess` (di folder `public/` - sudah ada)

## ❌ File/Folder yang TIDAK Perlu Diupload

### Development Files
```
.git/
.gitignore
.idea/
.vscode/
.env                    ← Akan dibuat di server
.env.example
.env.production.example
```

### Dependencies (akan diinstall di server)
```
vendor/                 ← Akan dibuat dengan: composer install
node_modules/          ← Tidak perlu jika sudah build assets
```

### Test Files
```
tests/
phpunit.xml            ← Opsional, bisa diupload tapi tidak perlu
```

### Cache & Logs (akan dibuat otomatis)
```
storage/logs/*.log
storage/framework/cache/*
storage/framework/sessions/*
storage/framework/views/*
bootstrap/cache/*
```

### Database Local
```
database/database.sqlite
```

### Documentation (opsional)
```
README.md
README_NEW_SYSTEM.md
ARCHITECTURE.md
MIGRATION_GUIDE.md
ADMIN_GUIDE.md
OPTIMIZATION_CHECKLIST.md
HOSTINGER_DEPLOYMENT_GUIDE.md
DEPLOYMENT_CHECKLIST.md
FILES_TO_UPLOAD.md     ← File ini sendiri
```

## 📦 Cara Upload

### Metode 1: File Manager (Recommended)
1. Login ke hPanel Hostinger
2. Buka File Manager
3. Masuk ke `public_html/`
4. Upload semua file/folder yang diperlukan
5. Pastikan struktur folder benar

### Metode 2: FTP/SFTP
1. Gunakan FTP client (FileZilla, WinSCP)
2. Connect ke server
3. Upload ke `public_html/`
4. Pastikan mode transfer: Binary (untuk file binary)

### Metode 3: ZIP Upload (untuk banyak file)
1. Zip semua file yang perlu diupload
2. Upload ZIP ke server
3. Extract di server via File Manager

## ⚠️ Catatan Penting

1. **Folder `public/build/`**: 
   - Pastikan folder ini sudah di-build dengan `npm run build` sebelum upload
   - Folder ini berisi CSS dan JS yang sudah di-compile

2. **Folder `storage/`**:
   - Upload folder kosong dengan struktur:
     ```
     storage/
     ├── app/
     │   ├── private/
     │   └── public/
     ├── framework/
     │   ├── cache/
     │   ├── sessions/
     │   └── views/
     └── logs/
     ```
   - Set permission 755 setelah upload

3. **File `.env`**:
   - JANGAN upload file `.env` dari local
   - Buat file `.env` baru di server
   - Copy isi dari `.env.production.example` dan sesuaikan

4. **File `composer.json` dan `composer.lock`**:
   - HARUS diupload
   - Akan digunakan untuk install dependencies di server

5. **File `package.json` dan `package-lock.json`**:
   - HARUS diupload (jika perlu build di server)
   - Atau bisa skip jika sudah build di local dan upload folder `public/build/`

## 📋 Checklist Upload

- [ ] Semua folder core Laravel sudah diupload
- [ ] Folder `public/build/` sudah ada (dari npm build)
- [ ] File `composer.json` dan `composer.lock` sudah diupload
- [ ] File `package.json` sudah diupload (opsional)
- [ ] Folder `storage/` sudah diupload (kosong)
- [ ] File `.htaccess` di `public/` sudah ada
- [ ] File `.env` TIDAK diupload (akan dibuat di server)
- [ ] Folder `vendor/` TIDAK diupload (akan diinstall)
- [ ] Folder `node_modules/` TIDAK diupload
- [ ] Permission folder `storage/` sudah di-set (755)

## 🔍 Verifikasi Setelah Upload

Setelah upload, pastikan:

1. **Struktur folder benar:**
   ```
   public_html/
   ├── app/
   ├── bootstrap/
   ├── config/
   ├── database/
   ├── public/
   ├── resources/
   ├── routes/
   ├── storage/
   ├── artisan
   ├── composer.json
   └── ...
   ```

2. **File penting ada:**
   - `public/index.php` ✓
   - `public/.htaccess` ✓
   - `artisan` ✓
   - `composer.json` ✓

3. **Permission benar:**
   - `storage/` → 755
   - `bootstrap/cache/` → 755

---

**Total ukuran file (estimasi):**
- Core files: ~5-10 MB
- `public/build/`: ~1-2 MB
- Total: ~6-12 MB (tanpa vendor dan node_modules)

