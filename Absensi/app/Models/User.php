<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model User - Pengguna Sistem (Admin & Mentor)
 * Menangani autentikasi dan otorisasi untuk kedua portal (BKAP & Pembimbing)
 */
class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    /**
     * Cek apakah user boleh akses panel tertentu
     * Admin hanya ke portal BKAP, Mentor hanya ke portal Pembimbing
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->role === 'admin';
        }

        if ($panel->getId() === 'mentor') {
            return $this->role === 'mentor' || $this->role === 'admin';
        }

        return false;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /** Helper: Cek apakah user adalah Admin/Direktur BKAP */
    public function isDirector(): bool
    {
        return $this->role === 'admin';
    }

    /** Helper: Cek apakah user adalah Mentor/Pembimbing */
    public function isMentor(): bool
    {
        return $this->role === 'mentor';
    }
}
