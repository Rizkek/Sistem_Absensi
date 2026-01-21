<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Statistik extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Statistik';
    protected static ?string $title = 'Statistik';
    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.statistik';

    public function getHeading(): string
    {
        return 'Statistik';
    }

    public function getSubheading(): ?string
    {
        return 'Visualisasi data laporan mentoring';
    }

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\KehadiranPerGrupChart::class,
            \App\Filament\Widgets\StatistikMingguanWidget::class,
            \App\Filament\Widgets\AktivitasBkapChart::class,
            \App\Filament\Widgets\ModeDistribusiChart::class,
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return $this->getWidgets();
    }
}
