<?php

namespace App\Filament\Mentor\Resources\SessionResource\Pages;

use App\Filament\Mentor\Resources\SessionResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateSession extends CreateRecord
{
    protected static string $resource = SessionResource::class;



    protected function afterCreate(): void
    {
        $session = $this->record;

        // Auto-generate attendance records for all students in the group
        if ($session->group) {
            foreach ($session->group->students as $student) {
                \App\Models\Attendance::firstOrCreate([
                    'session_id' => $session->id,
                    'student_id' => $student->id,
                ], [
                    'status' => 'absent',
                ]);
            }
        }
    }
}
