<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        // Mendapatkan panel yang sedang aktif (admin atau mentor)
        $panelId = Filament::getCurrentPanel()->getId();

        // Redirect sesuai panel system
        if ($panelId === 'admin') {
            return redirect()->to('/admin');
        }

        if ($panelId === 'mentor') {
            return redirect()->to('/mentor');
        }

        // Default fallback ke dashboard panel tersebut
        return redirect()->to(Filament::getCurrentPanel()->getUrl());
    }
}
