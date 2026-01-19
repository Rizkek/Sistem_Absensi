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
                    Forms\Components\Select::make('group_id')
                        ->label('Kelompok / Halaqah')
                        ->options(fn() => \App\Models\Group::where('mentor_id', Auth::id())->pluck('name', 'id'))
                        ->default(fn() => \App\Models\Group::where('mentor_id', Auth::id())->first()?->id)
                        ->required()
                        ->searchable()
                        ->preload(),
                    Forms\Components\Select::make('mentor_presence')
                        ->label('Kehadiran Pembimbing')
                        ->options([
                            'present' => 'Hadir',
                            'permit' => 'Izin',
                            'sick' => 'Sakit',
                            'absent' => 'Alpha',
                        ])
                        ->default('present')
                        ->required(),
                    Forms\Components\Select::make('mode')
                        ->label('Mode Pelaksanaan')
                        ->options([
                            'offline' => 'Offline (Tatap Muka)',
                            'online' => 'Online (Daring)',
                        ])
                        ->default('offline')
                        ->required(),
                    Forms\Components\Select::make('status')
                        ->options([
                            'scheduled' => 'Terjadwal',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                        ])
                        ->default('completed') // As most likely creating a report
                        ->required(),
                ])->columns(2),

                Forms\Components\Section::make('Materi & Program')->schema([
                    Forms\Components\TextInput::make('topic')
                        ->label('Materi / Judul Pembahasan')
                        ->required()
                        ->columnSpanFull(),

                    Forms\Components\Radio::make('is_program_special')
                        ->label('Apakah ada program khusus dari UPA?')
                        ->boolean()
                        ->default(false)
                        ->reactive(),

                    Forms\Components\Textarea::make('program_description')
                        ->label('Deskripsi Program')
                        ->visible(fn(Forms\Get $get) => $get('is_program_special'))
                        ->columnSpanFull(),

                    Forms\Components\Select::make('is_theme_suitable')
                        ->label('Tema Sesuai Arahan?')
                        ->options([true => 'Ya', false => 'Tidak'])
                        ->default(true),

                    Forms\Components\Select::make('is_material_suitable')
                        ->label('Materi Sesuai Indikator?')
                        ->options([true => 'Ya', false => 'Tidak'])
                        ->default(true),
                ])->columns(2),

                Forms\Components\Section::make('Amal Yaumian Pekanan (BKAP)')
                    ->description('Centang kegiatan yang dilakukan dan isi jumlah anggota.')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            // Shalat Berjamaah
                            Forms\Components\Fieldset::make('Shalat Berjamaah')->schema([
                                Forms\Components\TextInput::make('activity_shalat_berjamaah')
                                    ->label('Jumlah Anggota')
                                    ->numeric()
                                    ->default(0),
                            ])->columns(1),

                            // Shalat Dhuha
                            Forms\Components\Fieldset::make('Shalat Dhuha')->schema([
                                Forms\Components\TextInput::make('activity_shalat_dhuha')
                                    ->label('Jumlah Anggota')
                                    ->numeric()
                                    ->default(0),
                            ])->columns(1),

                            // Qiyamul Lail
                            Forms\Components\Fieldset::make('Qiyamul Lail')->schema([
                                Forms\Components\TextInput::make('activity_qiyamul_lail')
                                    ->label('Jumlah Anggota')
                                    ->numeric()
                                    ->default(0),
                            ])->columns(1),

                            // Tilawah
                            Forms\Components\Fieldset::make('Tilawah Al-Qur\'an')->schema([
                                Forms\Components\TextInput::make('activity_tilawah')
                                    ->label('Jumlah Anggota')
                                    ->numeric()
                                    ->default(0),
                            ])->columns(1),

                            // Dzikir
                            Forms\Components\Fieldset::make('Dzikir Pagi & Petang')->schema([
                                Forms\Components\TextInput::make('activity_dzikir')
                                    ->label('Jumlah Anggota')
                                    ->numeric()
                                    ->default(0),
                            ])->columns(1),

                            // Olahraga
                            Forms\Components\Fieldset::make('Olahraga')->schema([
                                Forms\Components\TextInput::make('activity_olahraga')
                                    ->label('Jumlah Anggota')
                                    ->numeric()
                                    ->default(0),
                            ])->columns(1),
                        ]),
                    ]),

                Forms\Components\Section::make('Dokumentasi')
                    ->schema([
                        Forms\Components\FileUpload::make('documentation')
                            ->label('Upload Foto Kegiatan')
                            ->image()
                            ->multiple()
                            ->maxFiles(5)
                            ->directory('session-documentation')
                            ->columnSpanFull(),
                    ]),
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
