<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Admin Analytics - Attendance Trends
 * System-wide attendance analytics
 */
class AdminAttendanceTrendChart extends ChartWidget
{
    protected static ?string $heading = 'Tren Kehadiran Sistem';
    protected static ?int $sort = 1;

    public function getDescription(): ?string
    {
        return 'Rata-rata kehadiran per minggu di seluruh sistem';
    }

    protected function getData(): array
    {
        $weeks = collect(range(0, 11))->map(function ($week) {
            $startDate = Carbon::now()->startOfWeek()->subWeeks(11 - $week);
            return [
                'week' => 'W' . $startDate->week,
                'start' => $startDate,
                'end' => $startDate->endOfWeek(),
            ];
        });

        $data = $weeks->map(function ($week) {
            $total = DB::table('attendances')
                ->whereBetween('created_at', [$week['start'], $week['end']])
                ->count();

            $present = DB::table('attendances')
                ->whereBetween('created_at', [$week['start'], $week['end']])
                ->where('status', 'present')
                ->count();

            return $total > 0 ? round(($present / $total) * 100, 1) : 0;
        });

        return [
            'datasets' => [
                [
                    'label' => 'Persentase Kehadiran',
                    'data' => $data,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.08)',
                    'borderColor' => '#10B981',
                    'borderWidth' => 3,
                    'tension' => 0.5,
                    'fill' => true,
                    'pointBackgroundColor' => '#10B981',
                    'pointRadius' => 5,
                    'pointHoverRadius' => 7,
                ],
            ],
            'labels' => $weeks->pluck('week'),
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
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'max' => 100,
                    'ticks' => [
                        'suffix' => '%',
                    ],
                    'grid' => [
                        'color' => '#E2E8F0',
                    ],
                ],
            ],
        ];
    }
}
