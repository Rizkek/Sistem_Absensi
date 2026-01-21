<?php

namespace App\Filament\Widgets;

use App\Models\Session;
use App\Models\Attendance;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class TotalSessionsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalSessions = Session::count();
        $activeSessions = Session::where('status', 'active')->count();
        $totalAttendance = Attendance::count();

        return [
            Stat::make('Total Sesi', $totalSessions)
                ->description('Sesi pembelajaran')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning')
                ->icon('heroicon-o-calendar'),
            Stat::make('Sesi Aktif', $activeSessions)
                ->description('Sedang berjalan')
                ->descriptionIcon('heroicon-m-play')
                ->color('danger')
                ->icon('heroicon-o-play'),
            Stat::make('Total Kehadiran', $totalAttendance)
                ->description('Catatan kehadiran')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->icon('heroicon-o-check-circle'),
        ];
    }
}
