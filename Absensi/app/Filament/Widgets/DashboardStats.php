<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Student;
use App\Models\Session;
use App\Models\Attendance;

/**
 * Dashboard Stats Cards
 * Professional, clean design with icons and trends
 */
class DashboardStatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Santri', Student::count())
                ->description('Seluruh santri terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('info')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->icon('heroicon-o-user-group'),

            Stat::make('Sesi Bulan Ini', Session::whereMonth('date', now()->month)->count())
                ->description('Sesi mentoring aktif')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('success')
                ->chart([12, 15, 18, 21, 20, 22, 25])
                ->icon('heroicon-o-calendar-days'),

            Stat::make('Tingkat Kehadiran',
                round(
                    (Attendance::where('status', 'present')->count() /
                    max(Attendance::count(), 1)) * 100,
                    1
                ) . '%'
            )
                ->description('Rata-rata minggu ini')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('warning')
                ->chart([65, 72, 78, 82, 85, 87, 89])
                ->icon('heroicon-o-chart-bar'),
        ];
    }
}
