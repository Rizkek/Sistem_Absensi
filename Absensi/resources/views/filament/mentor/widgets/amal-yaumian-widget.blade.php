<x-filament::section>
    <div class="space-y-4">
        <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
            <span class="material-symbols-outlined text-orange-500">check_box</span>
            Amal Yaumian Pekanan (BKAP)
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($activities as $activity)
                <div
                    class="bg-emerald-50/50 border border-emerald-100 rounded-xl p-4 relative overflow-hidden group hover:shadow-md transition-all">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-semibold text-gray-800">{{ $activity['title'] }}</h3>
                        <span class="px-2 py-0.5 bg-emerald-600 text-white text-xs font-bold rounded">
                            YA
                        </span>
                    </div>

                    <!-- Main Number -->
                    <div class="mb-4">
                        <div class="text-2xl font-bold text-emerald-700">
                            {{ $activity['count'] }} <span class="text-sm font-medium text-gray-500">anggota</span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-1">
                        <span>Persentase:</span>
                        <span class="font-bold text-purple-600">{{ $activity['percentage'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-emerald-500 h-2.5 rounded-full" style="width: {{ $activity['percentage'] }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-filament::section>