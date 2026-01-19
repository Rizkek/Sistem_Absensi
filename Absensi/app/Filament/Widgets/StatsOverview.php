<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use App\Models\Group;
use App\Models\Attendance;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Santri', Student::count())
                ->description('Total seluruh santri terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Total Halaqah', Group::count())
                ->description('Kelompok belajar aktif')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Stat::make('Kehadiran Rata-rata', number_format(Attendance::where('status', 'present')->count() / max(Attendance::count(), 1) * 100, 1) . '%')
                ->description('Persentase kehadiran keseluruhan')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info'),
        ];
    }
}
