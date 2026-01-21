<?php

namespace App\Filament\Widgets;

use App\Models\Session;
use App\Models\Group;
use App\Models\Attendance;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class KehadiranPerGrupChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Kehadiran per Grup';

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    public ?string $filter = null;

    protected function getFilters(): ?array
    {
        return [
            null => 'Semua Bulan',
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
    }

    protected function getData(): array
    {
        $groups = Group::with(['sessions.attendances'])->get();

        $labels = [];
        $data = [];

        foreach ($groups as $group) {
            $sessions = $group->sessions;

            // Filter by month if selected
            if ($this->filter) {
                $sessions = $sessions->filter(function ($session) {
                    return $session->date->month == $this->filter;
                });
            }

            $totalAttendances = 0;
            $presentAttendances = 0;

            foreach ($sessions as $session) {
                $totalAttendances += $session->attendances->count();
                $presentAttendances += $session->attendances->where('status', 'present')->count();
            }

            $percentage = $totalAttendances > 0
                ? round(($presentAttendances / $totalAttendances) * 100, 1)
                : 0;

            $labels[] = $group->name;
            $data[] = $percentage;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Persentase Kehadiran (%)',
                    'data' => $data,
                    'backgroundColor' => '#818cf8',
                    'borderColor' => '#6366f1',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'max' => 100,
                    'ticks' => [
                        'callback' => "function(value) { return value + '%'; }",
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
        ];
    }
}
