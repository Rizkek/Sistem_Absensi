<?php

namespace App\Filament\Mentor\Widgets;

use Filament\Widgets\Widget;

class WeeklyStatsWidget extends Widget
{
    protected static string $view = 'filament.mentor.widgets.weekly-stats-widget';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        return [
            'weeks' => $this->getWeeklyStats(),
        ];
    }

    protected function getWeeklyStats(): array
    {
        $mentorId = \Illuminate\Support\Facades\Auth::id();
        // Calculate stats for the current month
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $stats = [];
        $currentDate = $startOfMonth->copy();
        $weekNumber = 1;

        while ($currentDate->lte($endOfMonth)) {
            $startOfWeek = $currentDate->copy()->startOfWeek();
            $endOfWeek = $currentDate->copy()->endOfWeek();

            // Adjust to month boundaries
            if ($startOfWeek->lt($startOfMonth))
                $startOfWeek = $startOfMonth->copy();
            if ($endOfWeek->gt($endOfMonth))
                $endOfWeek = $endOfMonth->copy();

            // Query Sessions for this week
            $sessions = \App\Models\Session::whereHas('group', function ($q) use ($mentorId) {
                $q->where('mentor_id', $mentorId);
            })
                ->whereBetween('date', [$startOfWeek, $endOfWeek])
                ->withCount([
                    'attendances as present_count' => function ($q) {
                        $q->where('status', 'present');
                    }
                ])
                ->withCount('attendances')
                ->get();

            $totalSessions = $sessions->count();
            $attendanceSum = $sessions->sum('present_count');
            $attendanceTotal = $sessions->sum('attendances_count');
            $percentage = $attendanceTotal > 0 ? round(($attendanceSum / $attendanceTotal) * 100, 1) : 0;

            $online = $sessions->where('mode', 'online')->count();
            $offline = $sessions->where('mode', 'offline')->count();

            // Only add if there are sessions or it's within the month flow
            if ($totalSessions >= 0) {
                $stats[] = [
                    'label' => 'Minggu ' . $weekNumber,
                    'total_sessions' => $totalSessions,
                    'attendance_sum' => $attendanceSum,
                    'attendance_total' => $attendanceTotal,
                    'percentage' => $percentage,
                    'online' => $online,
                    'offline' => $offline,
                ];
            }

            $currentDate->addWeek();
            $weekNumber++;
        }

        return $stats;
    }
}
