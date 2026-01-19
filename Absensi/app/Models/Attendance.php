<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Attendance - Record Kehadiran Santri per Sesi
 * Status: present, absent, late, permit
 */
class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'student_id', 'status', 'notes'];

    /** Relasi: Kehadiran terkait dengan satu Sesi */
    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    /** Relasi: Kehadiran terkait dengan satu Santri */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
