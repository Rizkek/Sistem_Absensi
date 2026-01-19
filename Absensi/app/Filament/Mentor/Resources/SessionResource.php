<?php

namespace App\Filament\Mentor\Resources;

use App\Filament\Mentor\Resources\SessionResource\Pages;
use App\Filament\Mentor\Resources\SessionResource\RelationManagers;
use App\Models\Session;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class SessionResource extends Resource
{
    protected static ?string $model = Session::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Jadwal / Sesi';
    protected static ?string $pluralModelLabel = 'Sesi Pertemuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar')->schema([
                    Forms\Components\DatePicker::make('date')
                        ->required()
                        ->label('Tanggal'),
                    Forms\Components\TimePicker::make('start_time')
                        ->label('Waktu Mulai')
                        ->required(),
                    Forms\Components\TextInput::make('topic')
                        ->label('Materi / Program')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('status')
                        ->options([
                            'scheduled' => 'Terjadwal',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                        ])
                        ->default('scheduled')
                        ->required(),
                    // Hidden field for group_id will be handled in CreatePage or via relationship
                    Forms\Components\Hidden::make('group_id')
                        ->default(fn() => \App\Models\Group::where('mentor_id', Auth::id())->value('id')),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date('d M Y')
                    ->sortable()
                    ->label('Tanggal'),
                Tables\Columns\TextColumn::make('start_time')
                    ->time('H:i')
                    ->label('Waktu'),
                Tables\Columns\TextColumn::make('topic')
                    ->searchable()
                    ->label('Materi'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'scheduled' => 'gray',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                    })
                    ->label('Status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AttendancesRelationManager::class,
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

    // Ensure only viewing own group's sessions
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->whereHas('group', function ($query) {
            $query->where('mentor_id', Auth::id());
        });
    }
}
