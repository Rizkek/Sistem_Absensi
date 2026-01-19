@echo off
title Fix Styling - Install Filament & Build Assets

echo ============================================
echo   FIX TAMPILAN - INSTALL DEPENDENCIES
echo ============================================
echo.

echo [Step 1/4] Install Filament (bypass intl)...
call composer require filament/filament:"^3.2" -W --ignore-platform-req=ext-intl
if %errorlevel% neq 0 (
    echo ERROR: Filament installation failed!
    pause
    exit /b %errorlevel%
)

echo.
echo [Step 2/4] Install Node dependencies...
call npm install
if %errorlevel% neq 0 (
    echo ERROR: npm install failed!
    pause
    exit /b %errorlevel%
)

echo.
echo [Step 3/4] Build assets (Tailwind CSS)...
call npm run build
if %errorlevel% neq 0 (
    echo ERROR: Build failed!
    pause
    exit /b %errorlevel%
)

echo.
echo [Step 4/4] Clear cache...
call php artisan optimize:clear

echo.
echo ============================================
echo   SUCCESS! Styling sudah siap
echo ============================================
echo.
echo Silakan refresh browser (Ctrl+F5)
echo Tampilan Filament sekarang sudah ada Tailwind CSS!
echo.
pause
