#!/bin/bash

# Deployment script untuk Railway.app atau VPS
# Otomatis setup environment untuk production

echo "=========================================="
echo "   DEPLOY SCRIPT - SISTEM ABSENSI"
echo "=========================================="
echo ""

# Check apakah di production
if [ "$APP_ENV" != "production" ]; then
    echo "⚠️  WARNING: APP_ENV bukan 'production'"
    echo "   Set APP_ENV=production di environment variables"
    exit 1
fi

echo "✓ Environment: Production"
echo ""

# Install dependencies (production only)
echo "[1/6] Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Install Node dependencies
echo "[2/6] Installing Node dependencies..."
npm ci --production

# Build assets
echo "[3/6] Building frontend assets..."
npm run build

# Clear & cache config
echo "[4/6] Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations (only if DB_AUTO_MIGRATE=true)
if [ "$DB_AUTO_MIGRATE" == "true" ]; then
    echo "[5/6] Running database migrations..."
    php artisan migrate --force --no-interaction
else
    echo "[5/6] Skipping migrations (DB_AUTO_MIGRATE not set)"
fi

# Storage link
echo "[6/6] Creating storage link..."
php artisan storage:link

echo ""
echo "=========================================="
echo "  ✓ DEPLOYMENT COMPLETED!"
echo "=========================================="
echo ""
echo "Access your application at:"
echo "  Admin:  https://<your-domain>/admin"
echo "  Mentor: https://<your-domain>/mentor"
echo ""
