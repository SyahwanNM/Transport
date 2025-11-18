#!/bin/bash

# Script Deployment untuk Laravel Application
# Gunakan script ini untuk mempersiapkan aplikasi sebelum upload ke server

echo "🚀 Memulai persiapan deployment..."

# 1. Build assets untuk production
echo "📦 Building assets untuk production..."
npm run build

if [ $? -ne 0 ]; then
    echo "❌ Error: Build assets gagal!"
    exit 1
fi

echo "✅ Assets berhasil di-build"

# 2. Clear cache lokal
echo "🧹 Membersihkan cache lokal..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "✅ Cache berhasil dibersihkan"

# 3. Optimize autoloader
echo "⚡ Optimizing autoloader..."
composer install --no-dev --optimize-autoloader

if [ $? -ne 0 ]; then
    echo "❌ Error: Composer install gagal!"
    exit 1
fi

echo "✅ Autoloader berhasil dioptimalkan"

# 4. Verifikasi file penting
echo "🔍 Memverifikasi file penting..."

files_to_check=(
    "public/index.php"
    "public/.htaccess"
    "public/build/manifest.json"
    "composer.json"
    "composer.lock"
    ".htaccess"
)

for file in "${files_to_check[@]}"; do
    if [ ! -f "$file" ]; then
        echo "⚠️  Warning: File $file tidak ditemukan!"
    else
        echo "✅ $file ditemukan"
    fi
done

# 5. Checklist
echo ""
echo "📋 Checklist Pre-Deployment:"
echo "  [ ] Assets sudah di-build (public/build/)"
echo "  [ ] File .env.example sudah ada (untuk referensi)"
echo "  [ ] File .htaccess di root sudah ada"
echo "  [ ] File .htaccess di public/ sudah ada"
echo "  [ ] Composer dependencies sudah dioptimalkan"
echo ""
echo "✅ Persiapan deployment selesai!"
echo ""
echo "📤 Langkah selanjutnya:"
echo "  1. Upload semua file ke server (kecuali .env, vendor/, node_modules/)"
echo "  2. Buat file .env di server (copy dari .env.production.example)"
echo "  3. Set permission: chmod -R 755 storage bootstrap/cache"
echo "  4. Install dependencies: composer install --no-dev --optimize-autoloader"
echo "  5. Generate APP_KEY: php artisan key:generate"
echo "  6. Run migration: php artisan migrate --force"
echo "  7. Run seeder: php artisan db:seed --force"
echo "  8. Cache config: php artisan config:cache"
echo ""

