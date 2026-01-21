<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Mentor Student Progress Chart
 * Track student attendance and performance
 */
class MentorStudentProgressChart extends ChartWidget
{
    protected static ?string $heading = 'Progres Santri';
    protected static ?int $sort = 1;

    public function getDescription(): ?string
    {
        return 'Tingkat kehadiran santri Anda minggu ini';
    }

    protected function getData(): array
    {
        $mentor = auth()->user();
        $students = DB::table('students')
            ->whereIn('group_id', $mentor->groups()->pluck('id'))
            ->limit(8)
            ->get();

        $data = $students->map(function ($student) {
            $weekAttendance = DB::table('attendances')
                ->where('student_id', $student->id)
                ->whereDate('created_at', '>=', Carbon::now()->startOfWeek())
                ->whereDate('created_at', '<=', Carbon::now()->endOfWeek())
                ->where('status', 'present')
                ->count();

            $weekTotal = DB::table('attendances')
                ->where('student_id', $student->id)
                ->whereDate('created_at', '>=', Carbon::now()->startOfWeek())
                ->whereDate('created_at', '<=', Carbon::now()->endOfWeek())
                ->count();

            return $weekTotal > 0 ? round(($weekAttendance / $weekTotal) * 100, 0) : 0;
        });

        return [
            'datasets' => [
                [
                    'label' => 'Kehadiran %',
                    'data' => $data,
                    'backgroundColor' => [
                        '#10B981', '#3B82F6', '#F59E0B', '#EF4444',
                        '#8B5CF6', '#EC4899', '#06B6D4', '#14B8A6',
                    ],
                    'borderRadius' => 6,
                    'borderSkipped' => false,
                ],
            ],
            'labels' => $students->pluck('name'),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'max' => 100,
                    'grid' => [
                        'color' => '#E2E8F0',
                    ],
                ],
            ],
        ];
    }
}
