<?php

namespace App\Filament\Widgets;

use App\Models\Session;
use Filament\Widgets\ChartWidget;

class ModeDistribusiChart extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Mode Pelaksanaan';

    protected static ?int $sort = 4;

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
        $query = Session::query();

        // Filter by month
        if ($this->filter) {
            $query->whereMonth('date', $this->filter);
        }

        $onlineCount = (clone $query)->where('mode', 'online')->count();
        $offlineCount = (clone $query)->where('mode', 'offline')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Mode',
                    'data' => [$onlineCount, $offlineCount],
                    'backgroundColor' => [
                        '#818cf8', // Indigo - Online
                        '#c084fc', // Purple - Offline
                    ],
                    'borderColor' => [
                        '#6366f1',
                        '#a855f7',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => ['Online', 'Offline'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
            ],
            'cutout' => '60%',
        ];
    }
}
