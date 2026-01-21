<?php

namespace App\Filament\Widgets;

use App\Models\Session;
use App\Models\Group;
use Filament\Widgets\ChartWidget;

class AktivitasBkapChart extends ChartWidget
{
    protected static ?string $heading = 'Aktivitas BKAP';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public ?string $filter = null;
    public ?string $groupFilter = null;

    protected function getFilters(): ?array
    {
        $groups = Group::pluck('name', 'id')->toArray();

        return array_merge(
            [null => 'Semua Grup'],
            $groups
        );
    }

    protected function getData(): array
    {
        $query = Session::query();

        // Filter by group
        if ($this->filter) {
            $query->where('group_id', $this->filter);
        }

        $sessions = $query->get();

        // Sum all activities
        $shalatBerjamaah = $sessions->sum('activity_shalat_berjamaah');
        $shalatDhuha = $sessions->sum('activity_shalat_dhuha');
        $qiyamulLail = $sessions->sum('activity_qiyamul_lail');
        $tilawah = $sessions->sum('activity_tilawah');
        $dzikir = $sessions->sum('activity_dzikir');
        $olahraga = $sessions->sum('activity_olahraga');

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Peserta',
                    'data' => [
                        $shalatBerjamaah,
                        $shalatDhuha,
                        $qiyamulLail,
                        $tilawah,
                        $dzikir,
                        $olahraga,
                    ],
                    'backgroundColor' => [
                        '#3b82f6', // Blue - Shalat Berjamaah
                        '#22c55e', // Green - Shalat Dhuha
                        '#a855f7', // Purple - Qiyamul Lail
                        '#f97316', // Orange - Tilawah
                        '#ec4899', // Pink - Dzikir
                        '#6366f1', // Indigo - Olahraga
                    ],
                    'borderColor' => [
                        '#2563eb',
                        '#16a34a',
                        '#9333ea',
                        '#ea580c',
                        '#db2777',
                        '#4f46e5',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => [
                'Shalat Berjamaah',
                'Shalat Dhuha',
                'Qiyamul Lail',
                'Tilawah',
                'Dzikir',
                'Olahraga',
            ],
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
