<?php

namespace App\Filament\Mentor\Widgets;

use App\Filament\Mentor\Resources\SessionResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestSessions extends BaseWidget
{
    protected static ?int $sort = 4; // Pindah ke bawah

    // Atau disable kalau tidak mau tampil
    public static function canView(): bool
    {
        return false;
    }
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                SessionResource::getEloquentQuery()->latest('date')->take(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date('d M Y')
                    ->label('Tanggal'),
                Tables\Columns\TextColumn::make('topic')
                    ->label('Materi'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'scheduled' => 'gray',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                    }),
            ]);
    }
}
