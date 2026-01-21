@php
    $totalStudents = \App\Models\Student::count();
    $totalSessions = \App\Models\Session::count();
    $todayAttendance = \App\Models\Attendance::whereDate('created_at', now())->count();
    $totalGroups = \App\Models\Group::count();
@endphp

<div class="space-y-8 pb-8">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
        <div class="flex items-center justify-between px-6 py-6 bg-white rounded-lg shadow-sm border border-gray-200">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Siswa</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalStudents }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM15 20H9m6 0h6M9 20H3"></path>
                </svg>
            </div>
        </div>

        <div class="flex items-center justify-between px-6 py-6 bg-white rounded-lg shadow-sm border border-gray-200">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Sesi</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalSessions }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-lg">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>

        <div class="flex items-center justify-between px-6 py-6 bg-white rounded-lg shadow-sm border border-gray-200">
            <div>
                <p class="text-sm font-medium text-gray-600">Kehadiran Hari Ini</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $todayAttendance }}</p>
            </div>
            <div class="p-3 bg-amber-100 rounded-lg">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
        </div>

        <div class="flex items-center justify-between px-6 py-6 bg-white rounded-lg shadow-sm border border-gray-200">
            <div>
                <p class="text-sm font-medium text-gray-600">Grup Aktif</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalGroups }}</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-lg">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2zm0 0h6v-2a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Selamat Datang di Portal BKAP</h3>
        <p class="text-gray-600">Gunakan menu di sidebar untuk mengakses fitur manajemen absensi, siswa, grup, dan sesi.</p>
    </div>
</div>
