<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Group - Kelompok/Halaqah Belajar
 * Satu grup dipimpin oleh satu mentor, berisi banyak santri
 */
class Group extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'mentor_id'];

    // Default eager loading untuk optimize queries
    protected $with = ['mentor'];

    /** Relasi: Grup dimiliki oleh satu Mentor */
    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    /** Relasi: Grup memiliki banyak Santri */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /** Relasi: Grup memiliki banyak Sesi Pertemuan */
    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }
}
