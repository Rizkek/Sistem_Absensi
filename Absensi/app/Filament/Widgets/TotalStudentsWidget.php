<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalStudentsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalStudents = Student::count();
        $activeGroups = \App\Models\Group::count();

        return [
            Stat::make('Total Siswa', $totalStudents)
                ->description('Siswa terdaftar')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info')
                ->icon('heroicon-o-user-group'),
            Stat::make('Total Grup', $activeGroups)
                ->description('Grup aktif')
                ->descriptionIcon('heroicon-m-rectangle-group')
                ->color('success')
                ->icon('heroicon-o-rectangle-group'),
        ];
    }
}
