<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Student - Data Santri/Siswa
 * Setiap santri tergabung dalam satu grup/halaqah
 */
class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'nis', 'group_id'];

    // Default eager loading untuk optimize queries
    protected $with = ['group'];

    /** Relasi: Santri tergabung dalam satu Grup */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /** Relasi: Santri memiliki banyak record Kehadiran */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
