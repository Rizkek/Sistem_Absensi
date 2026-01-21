<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\Student;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class TodayAttendanceWidget extends ChartWidget
{
    protected static ?string $heading = 'Kehadiran Hari Ini';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $today = Carbon::today();

        $present = Attendance::whereDate('created_at', $today)
            ->where('status', 'hadir')
            ->count();

        $absent = Attendance::whereDate('created_at', $today)
            ->where('status', 'alpa')
            ->count();

        $late = Attendance::whereDate('created_at', $today)
            ->where('status', 'terlambat')
            ->count();

        $totalStudents = Student::count();
        $notMarked = $totalStudents - ($present + $absent + $late);

        return [
            'datasets' => [
                [
                    'label' => 'Kehadiran',
                    'data' => [$present, $late, $absent, $notMarked],
                    'backgroundColor' => [
                        '#10b981',
                        '#f59e0b',
                        '#ef4444',
                        '#d1d5db',
                    ],
                    'borderColor' => [
                        '#059669',
                        '#d97706',
                        '#dc2626',
                        '#9ca3af',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => ['Hadir', 'Terlambat', 'Alpa', 'Belum Diisi'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => true,
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
