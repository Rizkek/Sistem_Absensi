<?php

namespace App\Filament\Mentor\Widgets;

use App\Models\Session;
use App\Models\Group;
use App\Models\Attendance;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MentorStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $userId = Auth::id();

        // Get groups owned by this mentor
        $groupIds = Group::where('mentor_id', $userId)->pluck('id');

        // Total Laporan (sessions)
        $totalLaporan = Session::whereIn('group_id', $groupIds)->count();

        // Laporan Bulan Ini
        $laporanBulanIni = Session::whereIn('group_id', $groupIds)
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->count();

        // Persentase Kehadiran
        $totalAttendances = Attendance::whereHas('session', function ($query) use ($groupIds) {
            $query->whereIn('group_id', $groupIds);
        })->count();

        $presentAttendances = Attendance::whereHas('session', function ($query) use ($groupIds) {
            $query->whereIn('group_id', $groupIds);
        })->where('status', 'present')->count();

        $persentaseKehadiran = $totalAttendances > 0
            ? round(($presentAttendances / $totalAttendances) * 100, 1)
            : 0;

        // Total Grup
        $totalGrup = $groupIds->count();

        return [
            Stat::make('Total Laporan', $totalLaporan)
                ->description('Semua laporan mentoring')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info')
                ->chart([7, 3, 4, 5, 6, 3, 5]),

            Stat::make('Laporan Bulan Ini', $laporanBulanIni)
                ->description('Bulan ' . Carbon::now()->translatedFormat('F'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning')
                ->chart([3, 5, 2, 4, 6, 8, 5]),

            Stat::make('Persentase Kehadiran', $persentaseKehadiran . '%')
                ->description('Rata-rata kehadiran')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success')
                ->chart([65, 75, 80, 85, 90, 88, 93]),

            Stat::make('Total Grup', $totalGrup)
                ->description('Halaqah yang diampu')
                ->descriptionIcon('heroicon-m-users')
                ->color('danger')
                ->chart([1, 1, 1, 1, 1, 1, 1]),
        ];
    }
}
