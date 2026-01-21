<?php

namespace App\Filament\Mentor\Pages;

use App\Filament\Mentor\Widgets\MentorStatsOverview;
use App\Filament\Mentor\Widgets\LaporanTableWidget;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    public function getHeading(): string
    {
        $userName = Auth::user()?->name ?? 'Pembimbing';
        return 'Dashboard';
    }

    public function getSubheading(): ?string
    {
        $userName = Auth::user()?->name ?? 'Pembimbing';
        return "Selamat datang, {$userName}!";
    }

    public function getWidgets(): array
    {
        return [
            MentorStatsOverview::class,
            LaporanTableWidget::class,
        ];
    }

    public function getColumns(): int|string|array
    {
        return [
            'default' => 1,
            'sm' => 2,
            'md' => 4,
            'lg' => 4,
            'xl' => 4,
        ];
    }
}
