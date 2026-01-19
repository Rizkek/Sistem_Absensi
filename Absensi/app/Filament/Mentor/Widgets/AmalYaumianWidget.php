<?php

namespace App\Filament\Mentor\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class AmalYaumianWidget extends Widget
{
    // Load view custom
    protected static string $view = 'filament.mentor.widgets.amal-yaumian-widget';

    // Urutan posisi di dashboard
    protected static ?int $sort = 1;

    // Supaya widget ini full width atau sesuai grid
    protected int|string|array $columnSpan = 'full';

    // Data dummy untuk tampilan (nanti bisa diganti query DB real)
    public function getViewData(): array
    {
        return [
            'activities' => $this->getStats(),
        ];
    }

    protected function getStats(): array
    {
        $mentorId = Auth::id();

        // Group sessions by topic and aggregate stats
        // We look at the LATEST session for each topic to see "current status" 
        // OR we can average them. Based on "8 anggota" text, it looks like a snapshot of the latest session? 
        // Let's assume average or total for this month? 
        // The screenshot implies "Pekanan" (Weekly). So let's take this week's sessions for these topics.

        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

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

        // If no sessions this week, maybe return empty or look at all time?
        // Let's group by topic.

        $grouped = $sessions->groupBy('topic');
        $results = [];

        foreach ($grouped as $topic => $topicSessions) {
            // Aggregate
            $totalPresent = $topicSessions->sum('present_count');
            $totalPossible = $topicSessions->sum('attendances_count');
            $count = $totalPresent; // Approximate "N anggota"
            // Ensure we don't divide by zero
            $pct = $totalPossible > 0 ? round(($totalPresent / $totalPossible) * 100, 1) : 0;

            $results[] = [
                'title' => $topic,
                'count' => $totalPresent, // Total attendances count for this topic this week
                'total' => $totalPossible,
                'percentage' => $pct,
                'color' => $pct >= 80 ? 'success' : ($pct >= 50 ? 'warning' : 'danger'),
            ];
        }

        // If no data, maybe show defaults simply so UI isn't broken
        if (empty($results)) {
            return [
                ['title' => 'Belum ada data pekan ini', 'count' => 0, 'total' => 0, 'percentage' => 0, 'color' => 'gray']
            ];
        }

        return $results;
    }
}
