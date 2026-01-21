@php
    $user = auth()->user();
    $myGroup = \App\Models\Group::where('mentor_id', $user->id)->first();
    $totalStudents = $myGroup ? $myGroup->students()->count() : 0;
    $totalSessions = $myGroup ? $myGroup->sessions()->count() : 0;
    $todayAttendance = $myGroup ? \App\Models\Attendance::whereDate('created_at', now())
        ->whereIn('student_id', $myGroup->students()->pluck('id'))
        ->count() : 0;
@endphp

<div class="space-y-8 pb-8">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="flex items-center justify-between px-6 py-6 bg-white rounded-lg shadow-sm border border-gray-200">
            <div>
                <p class="text-sm font-medium text-gray-600">Siswa Saya</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalStudents }}</p>
            </div>
            <div class="p-3 bg-emerald-100 rounded-lg">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM15 20H9m6 0h6M9 20H3"></path>
                </svg>
            </div>
        </div>

        <div class="flex items-center justify-between px-6 py-6 bg-white rounded-lg shadow-sm border border-gray-200">
            <div>
                <p class="text-sm font-medium text-gray-600">Sesi Saya</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalSessions }}</p>
            </div>
            <div class="p-3 bg-teal-100 rounded-lg">
                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>

        <div class="flex items-center justify-between px-6 py-6 bg-white rounded-lg shadow-sm border border-gray-200">
            <div>
                <p class="text-sm font-medium text-gray-600">Kehadiran Hari Ini</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $todayAttendance }}</p>
            </div>
            <div class="p-3 bg-cyan-100 rounded-lg">
                <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Selamat Datang, {{ $user->name }}! 👋</h3>
        <p class="text-gray-600 mb-4">Anda login sebagai Mentor/Pembimbing di Portal Pembimbing BKAP.</p>
        @if($myGroup)
            <p class="text-sm text-gray-600"><strong>Grup Anda:</strong> {{ $myGroup->name }}</p>
        @else
            <p class="text-sm text-amber-600"><strong>⚠️ Info:</strong> Anda belum memiliki grup yang ditugaskan.</p>
        @endif
    </div>
</div>
