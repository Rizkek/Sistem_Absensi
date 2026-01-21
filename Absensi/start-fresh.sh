#!/bin/bash
# Start fresh: clear sessions sebelum start server

echo "🧹 Clearing sessions and cache..."
php artisan session:clear
php artisan cache:clear
php artisan config:clear
php artisan view:clear

echo "✅ Sessions and cache cleared!"
echo "🚀 Starting server..."
php artisan serve
