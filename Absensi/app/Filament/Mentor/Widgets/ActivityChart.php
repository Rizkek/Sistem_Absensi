<?php

namespace App\Filament\Mentor\Widgets;

use Filament\Widgets\ChartWidget;

class ActivityChart extends ChartWidget
{
    protected static ?string $heading = 'Aktivitas BKAP';
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';

    // Warna chart custom sesuai gambar
    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => false,
            ],
            'tooltip' => [
                'enabled' => true,
            ]
        ],
        'scales' => [
            'y' => [
                'beginAtZero' => true,
                'border' => [
                    'display' => false,
                ],
                'grid' => [
                    'color' => '#f3f4f6', // Light gray grid
                ],
            ],
            'x' => [
                'grid' => [
                    'display' => false,
                ],
            ],
        ],
        'borderRadius' => 6, // Rounded bars
        'barPercentage' => 0.6, // Slimmer bars
    ];

    protected function getData(): array
    {
        // Query real data grouped by Topic
        $mentorId = \Illuminate\Support\Facades\Auth::id();

        $data = \App\Models\Session::whereHas('group', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })
            ->withCount([
                'attendances as present_count' => function ($q) {
                    $q->where('status', 'present');
                }
            ])
            ->get()
            ->groupBy('topic')
            ->map(function ($sessions) {
                return $sessions->sum('present_count');
            });

        $labels = $data->keys()->toArray();
        $counts = $data->values()->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Aktivitas',
                    'data' => $counts,
                    'backgroundColor' => [
                        '#60a5fa',
                        '#4ade80',
                        '#c084fc',
                        '#fb923c',
                        '#f472b6',
                        '#818cf8',
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
