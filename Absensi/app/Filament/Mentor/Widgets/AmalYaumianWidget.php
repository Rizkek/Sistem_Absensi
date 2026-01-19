<?php

namespace App\Filament\Mentor\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class AmalYaumianWidget extends Widget
{
    // Load view custom
    protected static string $view = 'filament.mentor.widgets.amal-yaumian-widget';

    // Urutan posisi di dashboard
    protected static ?int $sort = 1;

    // Supaya widget ini full width atau sesuai grid
    protected int|string|array $columnSpan = 'full';

    // Data dummy untuk tampilan (nanti bisa diganti query DB real)
    public function getViewData(): array
    {
        return [
            'activities' => [
                [
                    'title' => 'Shalat Berjamaah',
                    'count' => 8,
                    'total' => 10,
                    'percentage' => 80,
                    'color' => 'success', // Hijau
                ],
                [
                    'title' => 'Shalat Dhuha',
                    'count' => 7,
                    'total' => 10,
                    'percentage' => 70,
                    'color' => 'success',
                ],
                [
                    'title' => 'Qiyamul Lail',
                    'count' => 5,
                    'total' => 10,
                    'percentage' => 50,
                    'color' => 'success',
                ],
                [
                    'title' => 'Tilawah Al-Qur\'an',
                    'count' => 9,
                    'total' => 10,
                    'percentage' => 90,
                    'color' => 'success',
                ],
                [
                    'title' => 'Dzikir Pagi & Petang',
                    'count' => 10,
                    'total' => 10,
                    'percentage' => 100,
                    'color' => 'success',
                ],
                [
                    'title' => 'Olahraga',
                    'count' => 6,
                    'total' => 10,
                    'percentage' => 60,
                    'color' => 'success',
                ],
            ],
        ];
    }
}
