@echo off
echo Starting Laravel Scaffolding...
call composer create-project laravel/laravel . --prefer-dist
if %errorlevel% neq 0 (
    echo Laravel installation failed!
    pause
    exit /b %errorlevel%
)

echo.
echo Installing Filament...
call composer require filament/filament:"^3.2" -W
if %errorlevel% neq 0 (
    echo Filament installation failed!
    pause
    exit /b %errorlevel%
)

echo.
echo Setup Complete! You can close this window.
pause
