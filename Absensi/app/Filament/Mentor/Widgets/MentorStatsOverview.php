<?php

namespace App\Filament\Mentor\Widgets;

use App\Models\Session;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class MentorStatsOverview extends BaseWidget
{
    // Widget ini kita disable dulu karena diganti yang baru custom view
    public static function canView(): bool
    {
        return false;
    }

    protected function getStats(): array
    {
        return [];
    }
}
