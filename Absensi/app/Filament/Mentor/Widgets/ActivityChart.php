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
        return [
            'datasets' => [
                [
                    'label' => 'Aktivitas',
                    'data' => [48, 42, 29, 53, 58, 38], // Dummy data sesuai gambar
                    'backgroundColor' => [
                        '#60a5fa', // Biru (Shalat Berjamaah)
                        '#4ade80', // Hijau (Shalat Dhuha)
                        '#c084fc', // Ungu (Qiyamul Lail)
                        '#fb923c', // Orange (Tilawah)
                        '#f472b6', // Pink (Dzikir)
                        '#818cf8', // Indigo (Olahraga)
                    ],
                ],
            ],
            'labels' => [
                'Shalat Berjamaah',
                'Shalat Dhuha',
                'Qiyamul Lail',
                'Tilawah',
                'Dzikir',
                'Olahraga'
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
