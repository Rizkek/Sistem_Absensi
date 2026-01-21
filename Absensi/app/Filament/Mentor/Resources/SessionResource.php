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
use Carbon\Carbon;

class SessionResource extends Resource
{
    protected static ?string $model = Session::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Input Laporan';
    protected static ?string $pluralModelLabel = 'Laporan Mentoring';
    protected static ?string $modelLabel = 'Laporan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // === SECTION 1: Informasi Dasar ===
                Forms\Components\Section::make('Informasi Dasar')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\DatePicker::make('date')
                                ->required()
                                ->label('Tanggal')
                                ->default(now())
                                ->native(false)
                                ->displayFormat('d/m/Y'),

                            Forms\Components\TimePicker::make('start_time')
                                ->label('Waktu')
                                ->required()
                                ->native(false),

                            Forms\Components\Select::make('month')
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
                                ->default(now()->month)
                                ->placeholder('Pilih Bulan')
                                ->dehydrated(false), // Tidak disimpan ke database, hanya untuk display

                            Forms\Components\Select::make('week')
                                ->label('Pekan')
                                ->options([
                                    1 => 'Minggu 1',
                                    2 => 'Minggu 2',
                                    3 => 'Minggu 3',
                                    4 => 'Minggu 4',
                                    5 => 'Minggu 5',
                                ])
                                ->placeholder('Pilih Pekan')
                                ->dehydrated(false), // Tidak disimpan ke database

                            Forms\Components\Select::make('group_id')
                                ->label('Kode Grup')
                                ->options(fn() => \App\Models\Group::where('mentor_id', Auth::id())->pluck('name', 'id'))
                                ->default(fn() => \App\Models\Group::where('mentor_id', Auth::id())->first()?->id)
                                ->required()
                                ->searchable()
                                ->preload()
                                ->placeholder('Contoh: UPA-A1'),

                            Forms\Components\Select::make('mentor_presence')
                                ->label('Kehadiran Pembimbing')
                                ->options([
                                    'present' => 'Hadir',
                                    'permit' => 'Izin',
                                    'sick' => 'Sakit',
                                    'absent' => 'Alpha',
                                ])
                                ->default('present')
                                ->required()
                                ->placeholder('Pilih Status'),

                            Forms\Components\Select::make('mode')
                                ->label('Mode Pelaksanaan')
                                ->options([
                                    'offline' => 'Offline (Tatap Muka)',
                                    'online' => 'Online (Daring)',
                                ])
                                ->default('offline')
                                ->required()
                                ->placeholder('Pilih Mode'),
                        ]),
                    ]),

                // === SECTION 2: Data Kehadiran ===
                Forms\Components\Section::make('Data Kehadiran')
                    ->icon('heroicon-o-user-group')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('total_anggota')
                                ->label('Total Anggota')
                                ->numeric()
                                ->default(0)
                                ->dehydrated(false),

                            Forms\Components\TextInput::make('jumlah_hadir')
                                ->label('Jumlah Hadir')
                                ->numeric()
                                ->default(0)
                                ->dehydrated(false),

                            Forms\Components\Textarea::make('nama_tidak_hadir')
                                ->label('Nama Tidak Hadir')
                                ->placeholder('Pisahkan dengan koma')
                                ->rows(2)
                                ->dehydrated(false),

                            Forms\Components\Textarea::make('alasan_tidak_hadir')
                                ->label('Alasan Tidak Hadir')
                                ->placeholder('Pisahkan dengan koma')
                                ->rows(2)
                                ->dehydrated(false),
                        ]),
                    ]),

                // === SECTION 3: Materi & Program ===
                Forms\Components\Section::make('Materi & Program')
                    ->icon('heroicon-o-book-open')
                    ->schema([
                        Forms\Components\TextInput::make('topic')
                            ->label('Materi / Judul Pembahasan')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Radio::make('is_program_special')
                                ->label('Apakah ada program khusus dari UPA?')
                                ->boolean()
                                ->default(false)
                                ->reactive()
                                ->inline(),

                            Forms\Components\TextInput::make('program_description')
                                ->label('Deskripsi Program')
                                ->placeholder('Jelaskan program khusus')
                                ->visible(fn(Forms\Get $get) => $get('is_program_special')),

                            Forms\Components\Select::make('is_theme_suitable')
                                ->label('Tema Sesuai Arahan?')
                                ->options([true => 'Ya', false => 'Tidak'])
                                ->default(true),

                            Forms\Components\Select::make('is_material_suitable')
                                ->label('Materi Sesuai Indikator?')
                                ->options([true => 'Ya', false => 'Tidak'])
                                ->default(true),
                        ]),
                    ]),

                // === SECTION 4: Amal Yaumian Pekanan (BKAP) ===
                Forms\Components\Section::make('Amal Yaumian Pekanan (BKAP)')
                    ->icon('heroicon-o-check-badge')
                    ->description('Centang jika aktivitas dilakukan, lalu isi jumlah anggota yang melaksanakan')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            // Shalat Berjamaah
                            Forms\Components\Fieldset::make('Shalat Berjamaah')->schema([
                                Forms\Components\TextInput::make('activity_shalat_berjamaah')
                                    ->label('Jumlah anggota')
                                    ->numeric()
                                    ->default(0)
                                    ->placeholder('Jumlah anggota'),
                            ])->columns(1),

                            // Shalat Dhuha
                            Forms\Components\Fieldset::make('Shalat Dhuha')->schema([
                                Forms\Components\TextInput::make('activity_shalat_dhuha')
                                    ->label('Jumlah anggota')
                                    ->numeric()
                                    ->default(0)
                                    ->placeholder('Jumlah anggota'),
                            ])->columns(1),

                            // Qiyamul Lail
                            Forms\Components\Fieldset::make('Qiyamul Lail')->schema([
                                Forms\Components\TextInput::make('activity_qiyamul_lail')
                                    ->label('Jumlah anggota')
                                    ->numeric()
                                    ->default(0)
                                    ->placeholder('Jumlah anggota'),
                            ])->columns(1),

                            // Tilawah
                            Forms\Components\Fieldset::make("Tilawah Al-Qur'an")->schema([
                                Forms\Components\TextInput::make('activity_tilawah')
                                    ->label('Jumlah anggota')
                                    ->numeric()
                                    ->default(0)
                                    ->placeholder('Jumlah anggota'),
                            ])->columns(1),

                            // Dzikir
                            Forms\Components\Fieldset::make('Dzikir Pagi & Petang')->schema([
                                Forms\Components\TextInput::make('activity_dzikir')
                                    ->label('Jumlah anggota')
                                    ->numeric()
                                    ->default(0)
                                    ->placeholder('Jumlah anggota'),
                            ])->columns(1),

                            // Olahraga
                            Forms\Components\Fieldset::make('Olahraga')->schema([
                                Forms\Components\TextInput::make('activity_olahraga')
                                    ->label('Jumlah anggota')
                                    ->numeric()
                                    ->default(0)
                                    ->placeholder('Jumlah anggota'),
                            ])->columns(1),
                        ]),
                    ]),

                // === SECTION 5: Dokumentasi ===
                Forms\Components\Section::make('Dokumentasi')
                    ->icon('heroicon-o-camera')
                    ->schema([
                        Forms\Components\FileUpload::make('documentation')
                            ->label('Upload Foto Kegiatan')
                            ->image()
                            ->multiple()
                            ->maxFiles(5)
                            ->directory('session-documentation')
                            ->columnSpanFull(),
                    ]),

                // Hidden status field
                Forms\Components\Hidden::make('status')
                    ->default('completed'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date('d/m/Y')
                    ->sortable()
                    ->label('Tanggal'),

                Tables\Columns\TextColumn::make('week_number')
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

                Tables\Columns\TextColumn::make('attendance_count')
                    ->label('Kehadiran')
                    ->getStateUsing(function (Session $record): string {
                        $total = $record->attendances->count();
                        $present = $record->attendances->where('status', 'present')->count();
                        return "{$present}/{$total}";
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
                    ->query(
                        fn($query, array $data) =>
                        $data['value'] ? $query->whereMonth('date', $data['value']) : $query
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make('detail')
                    ->label('Detail')
                    ->modalHeading(fn(Session $record) => "Detail Laporan: {$record->group->name} - " . ceil($record->date->day / 7))
                    ->modalContent(fn(Session $record) => view('filament.resources.session.detail-modal', ['record' => $record]))
                    ->modalWidth('4xl')
                    ->color('info')
                    ->icon('heroicon-m-eye'),

                Tables\Actions\EditAction::make()
                    ->color('warning')
                    ->icon('heroicon-m-pencil-square'),
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
        return parent::getEloquentQuery()
            ->with(['attendances', 'group.mentor'])
            ->whereHas('group', function ($query) {
                $query->where('mentor_id', Auth::id());
            });
    }
}
