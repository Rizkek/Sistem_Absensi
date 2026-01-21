<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $title = 'Dashboard';

    public function getHeading(): string
    {
        return 'Dashboard';
    }

    public function getSubheading(): ?string
    {
        $userName = Auth::user()?->name ?? 'Administrator';
        return "Selamat datang, {$userName}!";
    }

    // Temporarily disable custom widgets to debug
    public function getWidgets(): array
    {
        return [];
    }
}
