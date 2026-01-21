<?php

namespace App\Filament\Widgets;

use App\Models\Session;
use App\Models\Group;
use App\Models\Attendance;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class AdminStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        // Total Laporan (sessions)
        $totalLaporan = Session::count();

        // Laporan Bulan Ini
        $laporanBulanIni = Session::whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->count();

        // Persentase Kehadiran
        $totalAttendances = Attendance::count();
        $presentAttendances = Attendance::where('status', 'present')->count();
        $persentaseKehadiran = $totalAttendances > 0
            ? round(($presentAttendances / $totalAttendances) * 100, 1)
            : 0;

        // Total Grup
        $totalGrup = Group::count();

        return [
            Stat::make('Total Laporan', $totalLaporan)
                ->description('Semua laporan mentoring')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info')
                ->chart([7, 3, 4, 5, 6, 3, 5, 8])
                ->extraAttributes([
                    'class' => 'bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl',
                ]),

            Stat::make('Laporan Bulan Ini', $laporanBulanIni)
                ->description('Bulan ' . Carbon::now()->translatedFormat('F'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning')
                ->chart([3, 5, 2, 4, 6, 8, 5, 4]),

            Stat::make('Persentase Kehadiran', $persentaseKehadiran . '%')
                ->description('Rata-rata kehadiran')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success')
                ->chart([65, 75, 80, 85, 90, 88, 93, 95]),

            Stat::make('Total Grup', $totalGrup)
                ->description('Halaqah terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('danger')
                ->chart([1, 1, 2, 2, 2, 2, 2, 2]),
        ];
    }
}
