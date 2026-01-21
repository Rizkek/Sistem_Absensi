<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class AttendanceOverviewWidget extends ChartWidget
{
    protected static ?string $heading = 'Tren Kehadiran 7 Hari Terakhir';
    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $labels = [];
        $haidirData = [];
        $terlambatData = [];
        $alpaData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('d M');

            $hadir = Attendance::whereDate('created_at', $date)
                ->where('status', 'hadir')
                ->count();

            $terlambat = Attendance::whereDate('created_at', $date)
                ->where('status', 'terlambat')
                ->count();

            $alpa = Attendance::whereDate('created_at', $date)
                ->where('status', 'alpa')
                ->count();

            $haidirData[] = $hadir;
            $terlambatData[] = $terlambat;
            $alpaData[] = $alpa;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Hadir',
                    'data' => $haidirData,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                    'borderWidth' => 2,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Terlambat',
                    'data' => $terlambatData,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'fill' => true,
                    'borderWidth' => 2,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Alpa',
                    'data' => $alpaData,
                    'borderColor' => '#ef4444',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                    'fill' => true,
                    'borderWidth' => 2,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
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
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }
}
