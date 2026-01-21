<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SessionResource\Pages;
use App\Models\Session;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Mentor\Resources\SessionResource as MentorSessionResource; // Reuse form logic if possible

class SessionResource extends Resource
{
    protected static ?string $model = Session::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Data Laporan';
    protected static ?string $pluralModelLabel = 'Data Laporan';
    protected static ?string $navigationGroup = 'Manajemen Data';

    public static function form(Form $form): Form
    {
        // Reuse form schema from Mentor Resource but fully re-defined here for clarity in Admin context
        return MentorSessionResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date('d/m/Y')
                    ->sortable()
                    ->label('Tanggal'),

                Tables\Columns\TextColumn::make('week')
                    ->label('Pekan')
                    ->getStateUsing(function (Session $record): string {
                        $weekOfMonth = ceil($record->date->day / 7);
                        return 'Minggu ' . $weekOfMonth;
                    }),

                Tables\Columns\TextColumn::make('group.name')
                    ->label('Grup')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('group.mentor.name')
                    ->label('Pembimbing')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'scheduled' => 'gray',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group_id')
                    ->relationship('group', 'name')
                    ->label('Grup'),
                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('until')->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($query, $date) => $query->whereDate('date', '>=', $date))
                            ->when($data['until'], fn($query, $date) => $query->whereDate('date', '<=', $date));
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make('detail') // Ganti Action biasa ke ViewAction
                    ->label('Detail')
                    ->modalHeading(fn(Session $record) => "Detail Laporan: {$record->group->name} - " . ceil($record->date->day / 7))
                    ->modalContent(fn(Session $record) => view('filament.resources.session.detail-modal', ['record' => $record]))
                    ->modalWidth('4xl')
                    ->color('primary')
                    ->icon('heroicon-m-eye'),

                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSessions::route('/'),
            'create' => Pages\CreateSession::route('/create'),
            'edit' => Pages\EditSession::route('/{record}/edit'),
        ];
    }
}
