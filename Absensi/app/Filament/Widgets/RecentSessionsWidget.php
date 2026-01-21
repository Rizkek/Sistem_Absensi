<?php

namespace App\Filament\Widgets;

use App\Models\Session;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentSessionsWidget extends BaseWidget
{
    protected static ?string $heading = 'Sesi Terbaru';
    protected static ?int $sort = 5;

    protected function getTableQuery(): Builder
    {
        return Session::query()
            ->with('group')
            ->latest('start_time')
            ->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('group.name')
                ->label('Grup')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('start_time')
                ->label('Waktu Mulai')
                ->dateTime('d M Y H:i')
                ->sortable(),
            Tables\Columns\BadgeColumn::make('status')
                ->label('Status')
                ->colors([
                    'success' => 'active',
                    'warning' => 'pending',
                    'danger' => 'ended',
                ])
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'active' => 'Aktif',
                    'pending' => 'Menunggu',
                    'ended' => 'Selesai',
                    default => $state,
                }),
            Tables\Columns\TextColumn::make('attendances_count')
                ->label('Kehadiran')
                ->counts('attendances'),
        ];
    }
}
