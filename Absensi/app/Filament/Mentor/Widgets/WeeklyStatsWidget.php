<?php

namespace App\Filament\Mentor\Widgets;

use Filament\Widgets\Widget;

class WeeklyStatsWidget extends Widget
{
    protected static string $view = 'filament.mentor.widgets.weekly-stats-widget';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        return [
            'weeks' => [
                [
                    'label' => 'Minggu 1',
                    'total_sessions' => 3,
                    'attendance_sum' => 31,
                    'attendance_total' => 34,
                    'percentage' => 91.2,
                    'online' => 2,
                    'offline' => 1,
                ],
                [
                    'label' => 'Minggu 2',
                    'total_sessions' => 3,
                    'attendance_sum' => 33,
                    'attendance_total' => 34,
                    'percentage' => 97.1,
                    'online' => 1,
                    'offline' => 2,
                ],
                [
                    'label' => 'Minggu 3',
                    'total_sessions' => 2,
                    'attendance_sum' => 20,
                    'attendance_total' => 22,
                    'percentage' => 90.9,
                    'online' => 2,
                    'offline' => 0,
                ],
            ]
        ];
    }
}
