<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;
use App\Models\Session;

/**
 * Distribution Chart - Activity by Mentor
 */
class AdminActivityDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Aktivitas per Mentor';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $mentors = User::where('role', 'mentor')
            ->withCount('groups')
            ->orderBy('groups_count', 'desc')
            ->limit(8)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Grup',
                    'data' => $mentors->pluck('groups_count'),
                    'backgroundColor' => [
                        '#10B981', '#3B82F6', '#F59E0B', '#EF4444',
                        '#8B5CF6', '#EC4899', '#06B6D4', '#14B8A6',
                    ],
                    'borderRadius' => 6,
                    'borderSkipped' => false,
                ],
            ],
            'labels' => $mentors->pluck('name'),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => '#E2E8F0',
                    ],
                ],
            ],
        ];
    }
}
