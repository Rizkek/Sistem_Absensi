<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Mentor Dashboard Stats
 * Personal KPIs for mentors
 */
class MentorStatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $mentor = auth()->user();

        $myGroups = $mentor->groups()->count();
        $myStudents = DB::table('students')
            ->whereIn('group_id', $mentor->groups()->pluck('id'))
            ->count();

        $todayAttendance = DB::table('attendances')
            ->whereDate('created_at', today())
            ->whereIn('session_id', DB::table('sessions')
                ->whereIn('group_id', $mentor->groups()->pluck('id'))
                ->pluck('id'))
            ->where('status', 'present')
            ->count();

        $thisSessions = DB::table('sessions')
            ->whereIn('group_id', $mentor->groups()->pluck('id'))
            ->whereMonth('date', now()->month)
            ->count();

        return [
            Stat::make('Grup Saya', $myGroups)
                ->description('Halaqah yang dibimbing')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info')
                ->icon('heroicon-o-user-group'),

            Stat::make('Total Santri', $myStudents)
                ->description('Siswa aktif')
                ->descriptionIcon('heroicon-m-users')
                ->color('success')
                ->icon('heroicon-o-users'),

            Stat::make('Hadir Hari Ini', $todayAttendance)
                ->description('Santri yang hadir')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('warning')
                ->icon('heroicon-o-check-circle'),

            Stat::make('Sesi Bulan Ini', $thisSessions)
                ->description('Total sesi mentoring')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('success')
                ->icon('heroicon-o-calendar-days'),
        ];
    }
}
