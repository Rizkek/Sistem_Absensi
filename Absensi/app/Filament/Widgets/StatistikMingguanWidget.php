<?php

namespace App\Filament\Widgets;

use App\Models\Session;
use App\Models\Attendance;
use Filament\Widgets\Widget;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;

class StatistikMingguanWidget extends Widget
{
    protected static string $view = 'filament.widgets.statistik-mingguan-widget';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public ?string $selectedMonth = null;

    public function mount(): void
    {
        $this->selectedMonth = (string) Carbon::now()->month;
    }

    public function getWeeklyStats(): array
    {
        $weeks = [];

        for ($week = 1; $week <= 4; $week++) {
            $query = Session::with('attendances');

            // Filter by month
            if ($this->selectedMonth) {
                $query->whereMonth('date', $this->selectedMonth);
            }

            // Filter by week
            $query->whereRaw('CEIL(EXTRACT(DAY FROM date) / 7) = ?', [$week]);

            $sessions = $query->get();

            $totalPertemuan = $sessions->count();
            $totalAttendances = 0;
            $presentAttendances = 0;
            $onlineCount = 0;
            $offlineCount = 0;

            foreach ($sessions as $session) {
                $totalAttendances += $session->attendances->count();
                $presentAttendances += $session->attendances->where('status', 'present')->count();

                if ($session->mode === 'online') {
                    $onlineCount++;
                } else {
                    $offlineCount++;
                }
            }

            $percentage = $totalAttendances > 0
                ? round(($presentAttendances / $totalAttendances) * 100, 1)
                : 0;

            $weeks[] = [
                'week' => $week,
                'total_pertemuan' => $totalPertemuan,
                'kehadiran' => "{$presentAttendances}/{$totalAttendances}",
                'persentase' => $percentage,
                'online' => $onlineCount,
                'offline' => $offlineCount,
            ];
        }

        return $weeks;
    }

    public function getMonthOptions(): array
    {
        return [
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
        ];
    }
}
