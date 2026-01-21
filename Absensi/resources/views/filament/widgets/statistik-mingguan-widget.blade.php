<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Statistik Mingguan
        </x-slot>

        <x-slot name="headerEnd">
            <select wire:model.live="selectedMonth"
                class="fi-select-input block w-40 rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                @foreach($this->getMonthOptions() as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($this->getWeeklyStats() as $stat)
                <div class="rounded-xl p-4 text-white"
                    style="background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);">
                    <h3 class="text-lg font-semibold mb-3">Minggu {{ $stat['week'] }}</h3>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm opacity-80">Total Pertemuan</span>
                            <span class="text-xl font-bold">{{ $stat['total_pertemuan'] }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm opacity-80">Kehadiran</span>
                            <span class="text-xl font-bold">{{ $stat['kehadiran'] }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm opacity-80">Persentase</span>
                            <span class="text-xl font-bold">{{ $stat['persentase'] }}%</span>
                        </div>

                        <div class="flex justify-between items-center text-xs mt-2 pt-2 border-t border-white/20">
                            <span>Online: {{ $stat['online'] }}</span>
                            <span>Offline: {{ $stat['offline'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>