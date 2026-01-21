<?php

namespace App\Filament\Widgets;

use App\Models\Session;
use App\Models\Group;
use App\Models\Attendance;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class AdminLaporanTableWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Daftar Laporan';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Session::query()
                    ->with(['group', 'group.mentor', 'attendances'])
                    ->orderBy('date', 'desc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('week')
                    ->label('Pekan')
                    ->getStateUsing(function (Session $record): string {
                        $weekOfMonth = ceil($record->date->day / 7);
                        return 'Minggu ' . $weekOfMonth;
                    }),

                Tables\Columns\TextColumn::make('group.name')
                    ->label('Kode Grup')
                    ->color('primary')
                    ->weight('bold')
                    ->searchable(),

                Tables\Columns\TextColumn::make('group.mentor.name')
                    ->label('Pembimbing'),

                Tables\Columns\TextColumn::make('attendance_ratio')
                    ->label('Kehadiran')
                    ->getStateUsing(function (Session $record): string {
                        $total = $record->attendances->count();
                        $present = $record->attendances->where('status', 'present')->count();
                        return $total > 0 ? "{$present}/{$total}" : '0/0';
                    })
                    ->badge()
                    ->color(function (Session $record): string {
                        $total = $record->attendances->count();
                        $present = $record->attendances->where('status', 'present')->count();
                        $percentage = $total > 0 ? ($present / $total) * 100 : 0;

                        if ($percentage >= 80)
                            return 'success';
                        if ($percentage >= 60)
                            return 'warning';
                        return 'danger';
                    }),

                Tables\Columns\TextColumn::make('mode')
                    ->label('Mode')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'online' => 'Online',
                        'offline' => 'Offline',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'online' => 'info',
                        'offline' => 'gray',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('month')
                    ->label('Bulan')
                    ->options([
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
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'],
                            fn(Builder $query, $value): Builder => $query->whereMonth('date', $value)
                        );
                    }),

                Tables\Filters\SelectFilter::make('week')
                    ->label('Pekan')
                    ->options([
                        1 => 'Minggu 1',
                        2 => 'Minggu 2',
                        3 => 'Minggu 3',
                        4 => 'Minggu 4',
                        5 => 'Minggu 5',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'],
                            fn(Builder $query, $value): Builder => $query->whereRaw('CEIL(EXTRACT(DAY FROM date) / 7) = ?', [$value])
                        );
                    }),

                Tables\Filters\SelectFilter::make('group_id')
                    ->label('Grup')
                    ->relationship('group', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make('detail')
                    ->label('Detail')
                    ->modalHeading(fn(Session $record) => "Detail Laporan: {$record->group->name} - " . ceil($record->date->day / 7))
                    ->modalContent(fn(Session $record) => view('filament.resources.session.detail-modal', ['record' => $record]))
                    ->modalWidth('4xl')
                    ->color('primary')
                    ->icon('heroicon-m-eye'),
            ])
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(5);
    }
}
