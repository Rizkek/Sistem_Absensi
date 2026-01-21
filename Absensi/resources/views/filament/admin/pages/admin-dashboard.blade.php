@extends('filament.pages.page')

@section('content')
<div class="space-y-8">

    <!-- Header Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        @livewire('admin-stats-overview')
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left Column: Charts -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Attendance Trend -->
            @livewire('admin-attendance-trend-chart')

            <!-- Activity Distribution -->
            @livewire('admin-activity-distribution-chart')
        </div>

        <!-- Right Column: Quick Actions & Config -->
        <div class="space-y-6">

            <!-- System Status -->
            <x-dashboard-card title="Status Sistem" description="Monitoring real-time">
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-lg">
                        <div>
                            <p class="text-xs text-emerald-700 font-medium">Database</p>
                            <p class="text-lg font-semibold text-emerald-900">✅ Normal</p>
                        </div>
                        <div class="text-2xl">🗄️</div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <div>
                            <p class="text-xs text-blue-700 font-medium">Cache</p>
                            <p class="text-lg font-semibold text-blue-900">✅ Aktif</p>
                        </div>
                        <div class="text-2xl">⚡</div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                        <div>
                            <p class="text-xs text-purple-700 font-medium">API Server</p>
                            <p class="text-lg font-semibold text-purple-900">✅ Online</p>
                        </div>
                        <div class="text-2xl">🌐</div>
                    </div>
                </div>
            </x-dashboard-card>

            <!-- Quick Admin Actions -->
            <x-dashboard-card title="Tindakan Cepat" description="Manajemen admin">
                <div class="space-y-2">
                    <a href="/admin/users" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                        <span class="text-lg">👥</span>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Kelola Pengguna</p>
                            <p class="text-xs text-gray-500">User & roles</p>
                        </div>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                        <span class="text-lg">⚙️</span>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Konfigurasi AI</p>
                            <p class="text-xs text-gray-500">Prompt & rules</p>
                        </div>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                        <span class="text-lg">📋</span>
                        <div>
                            <p class="text-sm font-medium text-gray-900">System Logs</p>
                            <p class="text-xs text-gray-500">Aktivitas & audit</p>
                        </div>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                        <span class="text-lg">📊</span>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Export Reports</p>
                            <p class="text-xs text-gray-500">Laporan bulanan</p>
                        </div>
                    </a>
                </div>
            </x-dashboard-card>

            <!-- AI Prompt Configuration -->
            <x-dashboard-card title="Konfigurasi AI" description="Pengaturan prompt">
                <div class="space-y-3">
                    <div class="p-3 bg-amber-50 rounded-lg border border-amber-200">
                        <p class="text-xs font-semibold text-amber-900 mb-2">📝 Feedback Prompt</p>
                        <p class="text-xs text-amber-800">Instruksi untuk AI memberikan feedback santri...</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-lg border border-blue-200">
                        <p class="text-xs font-semibold text-blue-900 mb-2">📊 Analytics Prompt</p>
                        <p class="text-xs text-blue-800">Analisis tren kehadiran dan performa...</p>
                    </div>
                </div>
                <button class="w-full mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                    Edit Prompts
                </button>
            </x-dashboard-card>
        </div>
    </div>

    <!-- Activity Log Section -->
    <x-dashboard-card title="Aktivitas Sistem" description="Terakhir 24 jam">
        <div class="space-y-3 divide-y">
            <div class="flex items-start gap-3 py-3 first:pt-0 last:pb-0">
                <div class="w-2 h-2 bg-green-500 rounded-full mt-2 shrink-0"></div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">Mentor login</p>
                    <p class="text-xs text-gray-500">Ahmad Khoiruddin masuk ke sistem</p>
                    <p class="text-xs text-gray-400">20 menit lalu</p>
                </div>
            </div>
            <div class="flex items-start gap-3 py-3">
                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 shrink-0"></div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">Laporan disubmit</p>
                    <p class="text-xs text-gray-500">Sesi halaqah Al-Quran dilaporkan</p>
                    <p class="text-xs text-gray-400">1 jam lalu</p>
                </div>
            </div>
            <div class="flex items-start gap-3 py-3">
                <div class="w-2 h-2 bg-purple-500 rounded-full mt-2 shrink-0"></div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">Santri baru terdaftar</p>
                    <p class="text-xs text-gray-500">Fatimah Az-Zahra ditambahkan ke grup</p>
                    <p class="text-xs text-gray-400">3 jam lalu</p>
                </div>
            </div>
        </div>
    </x-dashboard-card>
</div>

<!-- AI Copilot Panel (Admin version) -->
@livewire('ai-copilot-panel')
@endsection
