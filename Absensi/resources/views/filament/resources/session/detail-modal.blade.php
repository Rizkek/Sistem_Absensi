@php
    $attendanceCount = $record->attendances->count();
    $presentCount = $record->attendances->where('status', 'present')->count();
    $absentCount = $attendanceCount - $presentCount;

    // Get absentees names and reasons
    $absentees = $record->attendances
        ->where('status', '!=', 'present')
        ->map(fn($attendance) => [
            'name' => $attendance->student->name ?? 'Unknown',
            'status' => $attendance->status,
            'reason' => $attendance->reason ?? '-'
        ]);

    $activities = [
        [
            'label' => 'Shalat Berjamaah',
            'count' => $record->activity_shalat_berjamaah,
            'color' => 'bg-emerald-500',
            'bar_color' => 'bg-emerald-500' // green
        ],
        [
            'label' => 'Shalat Dhuha',
            'count' => $record->activity_shalat_dhuha,
            'color' => 'bg-emerald-500',
            'bar_color' => 'bg-emerald-500' // green
        ],
        [
            'label' => 'Qiyamul Lail',
            'count' => $record->activity_qiyamul_lail,
            'color' => 'bg-emerald-500',
            'bar_color' => 'bg-emerald-500' // green
        ],
        [
            'label' => 'Tilawah Al-Qur\'an',
            'count' => $record->activity_tilawah,
            'color' => 'bg-emerald-500',
            'bar_color' => 'bg-emerald-500'
        ],
        [
            'label' => 'Dzikir Pagi & Petang',
            'count' => $record->activity_dzikir,
            'color' => 'bg-emerald-500',
            'bar_color' => 'bg-emerald-500'
        ],
        [
            'label' => 'Olahraga',
            'count' => $record->activity_olahraga,
            'color' => 'bg-emerald-500',
            'bar_color' => 'bg-emerald-500'
        ]
    ];
@endphp

<div class="space-y-6">
    {{-- Header Custom Style is handled by Modal Heading, but we can add sub-info here --}}

    {{-- Informasi Dasar --}}
    <div class="space-y-3">
        <h3 class="flex items-center gap-2 text-lg font-semibold text-gray-800">
            <x-heroicon-o-information-circle class="w-5 h-5 text-primary-600" />
            Informasi Dasar
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Waktu</span>
                <p class="mt-1 text-sm font-bold text-gray-900">
                    {{ $record->date->translatedFormat('l, d F Y') }} |
                    {{ \Carbon\Carbon::parse($record->start_time)->format('H:i') }}
                </p>
            </div>

            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Bulan</span>
                <p class="mt-1 text-sm font-bold text-gray-900">
                    {{ $record->date->translatedFormat('F') }}
                </p>
            </div>

            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Grup</span>
                <p class="mt-1 text-sm font-bold text-primary-600">
                    {{ $record->group->name ?? '-' }}
                </p>
            </div>

            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Pembimbing</span>
                <p class="mt-1 text-sm font-bold text-gray-900">
                    {{ $record->group->mentor->name ?? '-' }}
                </p>
            </div>

            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Kehadiran Pembimbing</span>
                <p class="mt-1 text-sm font-bold text-green-600">
                    {{ ucfirst($record->mentor_presence) }}
                </p>
            </div>

            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Mode Pelaksanaan</span>
                <p class="mt-1 text-sm font-bold text-gray-900">
                    {{ ucfirst($record->mode) }}
                </p>
            </div>
        </div>
    </div>

    {{-- Data Kehadiran --}}
    <div class="space-y-3">
        <h3 class="flex items-center gap-2 text-lg font-semibold text-gray-800">
            <x-heroicon-o-user-group class="w-5 h-5 text-green-600" />
            Data Kehadiran
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Total --}}
            <div class="p-4 bg-blue-50/50 rounded-xl border border-blue-100">
                <span class="text-xs font-medium text-blue-600">Total Anggota</span>
                <p class="mt-1 text-3xl font-bold text-blue-700">{{ $attendanceCount }}</p>
            </div>

            {{-- Hadir --}}
            <div class="p-4 bg-green-50/50 rounded-xl border border-green-100">
                <span class="text-xs font-medium text-green-600">Jumlah Hadir</span>
                <p class="mt-1 text-3xl font-bold text-green-700">{{ $presentCount }}</p>
            </div>

            {{-- Tidak Hadir --}}
            <div class="p-4 bg-red-50/50 rounded-xl border border-red-100">
                <span class="text-xs font-medium text-red-600">Tidak Hadir</span>
                <p class="mt-1 text-3xl font-bold text-red-700">{{ $absentCount }}</p>
            </div>
        </div>

        @if($absentees->count() > 0)
            <div class="p-4 bg-red-50 rounded-xl border border-red-100 mt-2">
                <div class="mb-2">
                    <span class="text-xs font-bold text-red-800 block">Daftar Tidak Hadir:</span>
                    <p class="text-sm text-red-700">{{ $absentees->pluck('name')->join(', ') }}</p>
                </div>
                <div>
                    <span class="text-xs font-bold text-red-800 block">Alasan:</span>
                    <p class="text-sm text-red-700">
                        {{ $absentees->map(fn($a) => $a['status'] . ': ' . $a['reason'])->join(', ') }}</p>
                </div>
            </div>
        @endif
    </div>

    {{-- Materi & Program --}}
    <div class="space-y-3">
        <h3 class="flex items-center gap-2 text-lg font-semibold text-gray-800">
            <x-heroicon-o-book-open class="w-5 h-5 text-purple-600" />
            Materi & Program
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Materi / Topik</span>
                <p class="mt-1 text-sm font-bold text-gray-900">{{ $record->topic }}</p>
            </div>

            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Program Khusus</span>
                <p class="mt-1 text-sm font-bold text-gray-900">
                    {{ $record->is_program_special ? ($record->program_description ?? 'Ada') : 'Tidak ada' }}
                </p>
            </div>

            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tema Arahan Sesuai</span>
                <p class="mt-1 text-sm font-bold text-green-600">{{ $record->is_theme_suitable ? 'Ya' : 'Tidak' }}</p>
            </div>

            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Materi Sesuai Indikator</span>
                <p class="mt-1 text-sm font-bold text-green-600">{{ $record->is_material_suitable ? 'Ya' : 'Tidak' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Amal Yaumian --}}
    <div class="space-y-3">
        <h3 class="flex items-center gap-2 text-lg font-semibold text-gray-800">
            <x-heroicon-o-check-circle class="w-5 h-5 text-orange-600" />
            Amal Yaumian Pekanan (BKAP)
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($activities as $activity)
                @php
                    $percentage = $attendanceCount > 0 ? round(($activity['count'] / $attendanceCount) * 100, 1) : 0;
                @endphp
                <div class="p-4 rounded-xl border border-green-100 bg-green-50/30 relative overflow-hidden">
                    <div class="flex justify-between items-start mb-2">
                        <span class="font-semibold text-gray-800 text-sm">{{ $activity['label'] }}</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold text-white bg-green-600">YA</span>
                    </div>

                    <p class="text-2xl font-bold text-green-600 mb-2">
                        {{ $activity['count'] }} <span class="text-sm font-medium text-gray-600">anggota</span>
                    </p>

                    <div class="flex items-center justify-between text-xs text-gray-500 mb-1">
                        <span>Persentase:</span>
                        <span>{{ $percentage }}%</span>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Close Button Layout (Optional, Modal usually has close X) --}}
</div>