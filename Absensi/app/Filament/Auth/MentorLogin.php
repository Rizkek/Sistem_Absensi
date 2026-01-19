<?php

namespace App\Filament\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;

class MentorLogin extends BaseLogin
{
    protected static string $view = 'filament.auth.mentor-login';

    public function getHeading(): string|Htmlable
    {
        return 'Portal Pembimbing';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Masuk sebagai Mentor/Ustadz untuk mengelola halaqah.';
    }

    public function authenticate(): ?\Filament\Http\Responses\Auth\Contracts\LoginResponse
    {
        $data = $this->form->getState();

        if (
            !\Illuminate\Support\Facades\Auth::attempt([
                'email' => $data['email'],
                'password' => $data['password'],
            ], $data['remember'] ?? false)
        ) {
            $this->throwFailureValidationException();
        }

        $user = \Illuminate\Support\Facades\Auth::user();

        if ($user->role !== 'mentor' && $user->role !== 'admin') {
            \Illuminate\Support\Facades\Auth::logout();
            $this->addError('email', 'Akun Anda bukan akun Mentor.');
            return null;
        }

        session()->regenerate();

        return app(\Filament\Http\Responses\Auth\Contracts\LoginResponse::class);
    }
}
