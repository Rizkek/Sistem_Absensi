<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * AI-Assisted Attendance Overview Chart
 * Shows attendance trends with clean, modern styling
 */
class AttendanceOverviewChart extends ChartWidget
{
    protected static ?string $heading = 'Kehadiran Minggu Ini';
    protected static ?int $sort = 1;

    public function getDescription(): ?string
    {
        return 'Ringkasan status kehadiran santri per hari';
    }

    protected function getData(): array
    {
        $days = collect(range(0, 6))->map(function ($day) {
            $date = Carbon::now()->startOfWeek()->addDays($day);
            return [
                'day' => $date->format('D'),
                'date' => $date->format('Y-m-d'),
            ];
        });

        $data = $days->map(function ($day) {
            $present = DB::table('attendances')
                ->whereDate('created_at', $day['date'])
                ->where('status', 'present')
                ->count();

            $absent = DB::table('attendances')
                ->whereDate('created_at', $day['date'])
                ->where('status', 'absent')
                ->count();

            return [
                'present' => $present,
                'absent' => $absent,
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Hadir',
                    'data' => $data->pluck('present'),
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'borderColor' => '#10B981',
                    'borderWidth' => 2,
                    'tension' => 0.4,
                    'fill' => true,
                    'pointBackgroundColor' => '#10B981',
                    'pointRadius' => 4,
                ],
                [
                    'label' => 'Tidak Hadir',
                    'data' => $data->pluck('absent'),
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                    'borderColor' => '#EF4444',
                    'borderWidth' => 2,
                    'tension' => 0.4,
                    'fill' => true,
                    'pointBackgroundColor' => '#EF4444',
                    'pointRadius' => 4,
                ],
            ],
            'labels' => $days->pluck('day'),
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
                    'display' => true,
                    'position' => 'top',
                    'labels' => [
                        'font' => [
                            'family' => 'Inter, system-ui, -apple-system',
                            'size' => 13,
                            'weight' => 500,
                        ],
                        'color' => '#64748B',
                        'padding' => 16,
                        'usePointStyle' => true,
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => '#E2E8F0',
                        'drawBorder' => false,
                    ],
                    'ticks' => [
                        'color' => '#94A3B8',
                        'font' => [
                            'size' => 12,
                        ],
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                    'ticks' => [
                        'color' => '#94A3B8',
                        'font' => [
                            'size' => 12,
                        ],
                    ],
                ],
            ],
        ];
    }
}
