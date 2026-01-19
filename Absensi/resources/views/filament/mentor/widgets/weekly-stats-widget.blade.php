<x-filament::section>
    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-bold text-gray-800">Statistik Mingguan</h2>
            <div class="bg-white border rounded-lg px-3 py-1 text-sm text-gray-600 shadow-sm">
                Semua Bulan ▼
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($weeks as $week)
                <!-- Kartu Gradient Ungu -->
                <div class="rounded-2xl p-6 text-white relative overflow-hidden shadow-lg 
                                    bg-linear-to-br from-indigo-500 to-purple-600">

                    <!-- Decorative Circles (Optional) -->
                    <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl">
                    </div>
                    <div class="absolute bottom-0 left-0 -ml-4 -mb-4 w-20 h-20 bg-white opacity-10 rounded-full blur-xl">
                    </div>

                    <!-- Header -->
                    <h3 class="text-xl font-bold mb-6">{{ $week['label'] }}</h3>

                    <!-- Stats Row 1 -->
                    <div class="flex justify-between items-center mb-2 text-indigo-100 text-sm">
                        <span>Total Pertemuan</span>
                        <span class="font-bold text-white text-lg">{{ $week['total_sessions'] }}</span>
                    </div>

                    <!-- Stats Row 2 -->
                    <div class="flex justify-between items-center mb-2 text-indigo-100 text-sm">
                        <span>Kehadiran</span>
                        <span
                            class="font-bold text-white text-lg">{{ $week['attendance_sum'] }}/{{ $week['attendance_total'] }}</span>
                    </div>

                    <!-- Percentage (Big) -->
                    <div class="flex justify-between items-center mb-6 border-b border-indigo-400/30 pb-4">
                        <span class="text-indigo-100 text-sm">Persentase</span>
                        <span class="font-extrabold text-3xl">{{ $week['percentage'] }}%</span>
                    </div>

                    <!-- Footer -->
                    <div class="flex justify-between text-xs font-medium text-indigo-200">
                        <span>Online: {{ $week['online'] }}</span>
                        <span>Offline: {{ $week['offline'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-filament::section>