@echo off
REM Script Deployment untuk Laravel Application (Windows)
REM Gunakan script ini untuk mempersiapkan aplikasi sebelum upload ke server

echo 🚀 Memulai persiapan deployment...

REM 1. Build assets untuk production
echo 📦 Building assets untuk production...
call npm run build

if %errorlevel% neq 0 (
    echo ❌ Error: Build assets gagal!
    exit /b 1
)

echo ✅ Assets berhasil di-build

REM 2. Clear cache lokal
echo 🧹 Membersihkan cache lokal...
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo ✅ Cache berhasil dibersihkan

REM 3. Optimize autoloader
echo ⚡ Optimizing autoloader...
composer install --no-dev --optimize-autoloader

if %errorlevel% neq 0 (
    echo ❌ Error: Composer install gagal!
    exit /b 1
)

echo ✅ Autoloader berhasil dioptimalkan

REM 4. Verifikasi file penting
echo 🔍 Memverifikasi file penting...

if exist "public\index.php" (
    echo ✅ public\index.php ditemukan
) else (
    echo ⚠️  Warning: public\index.php tidak ditemukan!
)

if exist "public\.htaccess" (
    echo ✅ public\.htaccess ditemukan
) else (
    echo ⚠️  Warning: public\.htaccess tidak ditemukan!
)

if exist "public\build\manifest.json" (
    echo ✅ public\build\manifest.json ditemukan
) else (
    echo ⚠️  Warning: public\build\manifest.json tidak ditemukan!
)

if exist "composer.json" (
    echo ✅ composer.json ditemukan
) else (
    echo ⚠️  Warning: composer.json tidak ditemukan!
)

if exist ".htaccess" (
    echo ✅ .htaccess ditemukan
) else (
    echo ⚠️  Warning: .htaccess tidak ditemukan!
)

echo.
echo 📋 Checklist Pre-Deployment:
echo   [ ] Assets sudah di-build (public/build/)
echo   [ ] File .env.example sudah ada (untuk referensi)
echo   [ ] File .htaccess di root sudah ada
echo   [ ] File .htaccess di public/ sudah ada
echo   [ ] Composer dependencies sudah dioptimalkan
echo.
echo ✅ Persiapan deployment selesai!
echo.
echo 📤 Langkah selanjutnya:
echo   1. Upload semua file ke server (kecuali .env, vendor/, node_modules/)
echo   2. Buat file .env di server (copy dari .env.production.example)
echo   3. Set permission: chmod -R 755 storage bootstrap/cache
echo   4. Install dependencies: composer install --no-dev --optimize-autoloader
echo   5. Generate APP_KEY: php artisan key:generate
echo   6. Run migration: php artisan migrate --force
echo   7. Run seeder: php artisan db:seed --force
echo   8. Cache config: php artisan config:cache
echo.

pause

