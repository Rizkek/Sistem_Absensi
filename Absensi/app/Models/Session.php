<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Session extends Model
{
    use HasFactory;

    protected $table = 'halaqah_sessions';

    protected $fillable = [
        'group_id',
        'date',
        'start_time',
        'topic',
        'status',
        'mode',
        'documentation', // Photos
        'mentor_presence',
        'is_program_special',
        'program_description',
        'is_theme_suitable',
        'is_material_suitable',
        'activity_shalat_berjamaah',
        'activity_shalat_dhuha',
        'activity_qiyamul_lail',
        'activity_tilawah',
        'activity_dzikir',
        'activity_olahraga',
    ];

    protected $casts = [
        'date' => 'date',
        'documentation' => 'array', // Cast JSON to array
        'is_program_special' => 'boolean',
        'is_theme_suitable' => 'boolean',
        'is_material_suitable' => 'boolean',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
