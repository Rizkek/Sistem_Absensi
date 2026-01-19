<?php

namespace App\Filament\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Support\Enums\Alignment;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Blade;

class AdminLogin extends BaseLogin
{
    protected static string $view = 'filament.auth.admin-login';

    // Menggunakan layout custom jika diperlukan, tapi kita inject styling lewat PanelProvider saja
    // untuk mempermudah maintenance tanpa override view full.

    public function getHeading(): string|Htmlable
    {
        return 'Portal BKAP';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Silakan login untuk masuk ke panel administrasi akademik.';
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

        if ($user->role !== 'admin') {
            \Illuminate\Support\Facades\Auth::logout();
            $this->addError('email', 'Akun Anda tidak memiliki akses Admin.');
            return null;
        }

        session()->regenerate();

        return app(\Filament\Http\Responses\Auth\Contracts\LoginResponse::class);
    }
}
