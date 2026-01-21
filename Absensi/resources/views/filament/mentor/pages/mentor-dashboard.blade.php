@extends('filament.pages.page')

@section('content')
<div class="space-y-8">

    <!-- Personal Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        @livewire('mentor-personal-stats')
    </div>

    <!-- Main Dashboard -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left Column: Charts & Progress -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Student Progress Chart -->
            @livewire('mentor-student-progress')

            <!-- Attendance Overview -->
            @livewire('attendance-overview-chart')
        </div>

        <!-- Right Column: Task & Action Panel -->
        <div class="space-y-6">

            <!-- Today's Tasks -->
            <x-dashboard-card title="Tugas Hari Ini" description="Aksi yang perlu dilakukan">
                <div class="space-y-3">
                    <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="font-semibold text-red-900">Review Laporan</p>
                                <p class="text-sm text-red-800">3 laporan menunggu review</p>
                            </div>
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">3</span>
                        </div>
                    </div>

                    <div class="p-4 bg-amber-50 border-l-4 border-amber-500 rounded-lg">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="font-semibold text-amber-900">Feedback Santri</p>
                                <p class="text-sm text-amber-800">Berikan feedback untuk 5 santri</p>
                            </div>
                            <span class="bg-amber-500 text-white text-xs font-bold px-2 py-1 rounded">5</span>
                        </div>
                    </div>

                    <div class="p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="font-semibold text-blue-900">Sesi Besok</p>
                                <p class="text-sm text-blue-800">Siapkan materi untuk sesi esok</p>
                            </div>
                            <span class="bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded">2</span>
                        </div>
                    </div>
                </div>
            </x-dashboard-card>

            <!-- Quick Actions -->
            <x-dashboard-card title="Aksi Cepat" description="Navigasi langsung">
                <div class="space-y-2">
                    <a href="#" class="flex items-center gap-3 p-3 hover:bg-emerald-50 rounded-lg transition">
                        <span class="text-lg">📝</span>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Input Laporan</p>
                            <p class="text-xs text-gray-500">Sesi baru</p>
                        </div>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 hover:bg-emerald-50 rounded-lg transition">
                        <span class="text-lg">💬</span>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Generate Feedback</p>
                            <p class="text-xs text-gray-500">AI assistant</p>
                        </div>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 hover:bg-emerald-50 rounded-lg transition">
                        <span class="text-lg">👥</span>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Lihat Santri</p>
                            <p class="text-xs text-gray-500">Detail & progres</p>
                        </div>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 hover:bg-emerald-50 rounded-lg transition">
                        <span class="text-lg">📅</span>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Jadwal Sesi</p>
                            <p class="text-xs text-gray-500">Manajemen waktu</p>
                        </div>
                    </a>
                </div>
            </x-dashboard-card>

            <!-- AI Feedback Generator -->
            <x-dashboard-card title="AI Feedback" description="Bantuan pembuatan feedback">
                <div class="space-y-3">
                    <div class="p-3 bg-linear-to-r from-emerald-50 to-teal-50 rounded-lg border border-emerald-200">
                        <p class="text-sm font-semibold text-emerald-900 mb-2">✨ Smart Feedback</p>
                        <p class="text-xs text-emerald-800 mb-3">Gunakan AI untuk generate feedback otomatis berdasarkan data santri</p>
                        <button class="w-full px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium rounded transition">
                            Generate Feedback
                        </button>
                    </div>
                </div>
            </x-dashboard-card>

            <!-- Session Planning -->
            <x-dashboard-card title="Sesi Mendatang" description="3 hari ke depan">
                <div class="space-y-2">
                    <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="font-semibold text-sm text-gray-900">📅 Senin, 20 Januari</p>
                        <p class="text-xs text-gray-600 mt-1">Halaqah Al-Quran - 19:00</p>
                        <p class="text-xs text-emerald-600 font-medium">✓ Sudah direncanakan</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="font-semibold text-sm text-gray-900">📅 Selasa, 21 Januari</p>
                        <p class="text-xs text-gray-600 mt-1">Fiqih & Tajweed - 20:00</p>
                        <p class="text-xs text-amber-600 font-medium">⏳ Siap direncanakan</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="font-semibold text-sm text-gray-900">📅 Rabu, 22 Januari</p>
                        <p class="text-xs text-gray-600 mt-1">Hafalan & Review - 19:30</p>
                        <p class="text-xs text-amber-600 font-medium">⏳ Siap direncanakan</p>
                    </div>
                </div>
            </x-dashboard-card>
        </div>
    </div>

    <!-- Recent Reports Section -->
    <x-dashboard-card title="Laporan Terbaru" description="Aktivitas terakhir">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b border-gray-200">
                    <tr>
                        <th class="text-left py-3 px-4 font-semibold text-gray-900">Tanggal</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-900">Grup</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-900">Status</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">20 Jan 2026</td>
                        <td class="py-3 px-4 font-medium">Halaqah Al-Quran</td>
                        <td class="py-3 px-4"><span class="px-2 py-1 bg-emerald-100 text-emerald-800 text-xs font-medium rounded">Selesai</span></td>
                        <td class="py-3 px-4"><a href="#" class="text-emerald-600 hover:text-emerald-700">Lihat</a></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">19 Jan 2026</td>
                        <td class="py-3 px-4 font-medium">Fiqih & Tajweed</td>
                        <td class="py-3 px-4"><span class="px-2 py-1 bg-emerald-100 text-emerald-800 text-xs font-medium rounded">Selesai</span></td>
                        <td class="py-3 px-4"><a href="#" class="text-emerald-600 hover:text-emerald-700">Lihat</a></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">18 Jan 2026</td>
                        <td class="py-3 px-4 font-medium">Hafalan Review</td>
                        <td class="py-3 px-4"><span class="px-2 py-1 bg-amber-100 text-amber-800 text-xs font-medium rounded">Pending Review</span></td>
                        <td class="py-3 px-4"><a href="#" class="text-emerald-600 hover:text-emerald-700">Review</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </x-dashboard-card>
</div>

<!-- AI Copilot Panel (Mentor version) -->
@livewire('ai-copilot-panel')
@endsection
