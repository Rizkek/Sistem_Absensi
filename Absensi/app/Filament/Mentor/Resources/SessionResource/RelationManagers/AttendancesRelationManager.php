<?php

namespace App\Filament\Mentor\Resources\SessionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AttendancesRelationManager extends RelationManager
{
    protected static string $relationship = 'attendances';
    protected static ?string $title = 'Presensi Santri';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'present' => 'Hadir',
                        'absent' => 'Tidak Hadir',
                        'late' => 'Terlambat',
                        'permit' => 'Izin',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('notes')
                    ->label('Catatan')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('student.name')
            ->columns([
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Nama Santri')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'present' => 'Hadir',
                        'absent' => 'Tidak Hadir',
                        'late' => 'Terlambat',
                        'permit' => 'Izin',
                    ])
                    ->label('Status Kehadiran')
                    ->selectablePlaceholder(false),
                Tables\Columns\TextInputColumn::make('notes')
                    ->label('Catatan'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
