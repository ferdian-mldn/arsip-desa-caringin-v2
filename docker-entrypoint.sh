#!/bin/sh
set -e

echo "======================================"
echo "  Arsip Desa Caringin - Starting Up"
echo "======================================"

# Tunggu MySQL siap
echo "[1/5] Menunggu koneksi database..."
until php -r "
    \$conn = @new PDO(
        'mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT'),
        getenv('DB_USERNAME'),
        getenv('DB_PASSWORD')
    );
" 2>/dev/null; do
    echo "      Database belum siap, coba lagi dalam 3 detik..."
    sleep 3
done
echo "      Database siap!"

# Clear config cache
echo "[2/5] Clear cache..."
php artisan config:clear --quiet
php artisan cache:clear --quiet
php artisan view:clear --quiet

# Jalankan migrasi
echo "[3/5] Menjalankan migrasi database..."
php artisan migrate --force --no-interaction

# Jalankan seeder (hanya jika tabel users kosong)
echo "[4/5] Mengecek data awal..."
USER_COUNT=$(php artisan tinker --execute="echo App\Models\User::count();" 2>/dev/null | tail -n1 | tr -d '[:space:]')
if [ "$USER_COUNT" = "0" ] || [ -z "$USER_COUNT" ]; then
    echo "      Menjalankan seeder..."
    php artisan db:seed --force --no-interaction
    echo "      Seeder selesai!"
else
    echo "      Data sudah ada ($USER_COUNT user), seeder dilewati."
fi

# Storage link
echo "[5/5] Membuat storage link..."
php artisan storage:link --force 2>/dev/null || true

echo ""
echo "======================================"
echo "  Aplikasi siap! Akses di port 80"
echo "======================================"
echo ""

# Jalankan Apache
exec "$@"
