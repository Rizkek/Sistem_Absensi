<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceApiController extends Controller
{
    public function getSessions(Request $request)
    {
        $user = $request->user();

        // If mentor, return their group sessions
        if ($user->role === 'mentor') {
            $sessions = Session::whereHas('group', function ($q) use ($user) {
                $q->where('mentor_id', $user->id);
            })->with(['group', 'attendances.student'])->paginate(10);

            return response()->json($sessions);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }

    public function updateAttendance(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        // Validation logic here to ensure mentor owns this attendance record

        $attendance->update([
            'status' => $request->input('status'),
            'notes' => $request->input('notes'),
        ]);

        return response()->json($attendance);
    }
}
