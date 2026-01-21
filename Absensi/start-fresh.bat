@echo off
REM Start fresh: clear sessions sebelum start server

echo.
echo [*] Clearing sessions and cache...
php artisan session:clear
php artisan cache:clear
php artisan config:clear
php artisan view:clear

echo.
echo [+] Sessions and cache cleared!
echo.
echo [!] Starting server...
echo.
php artisan serve

pause
