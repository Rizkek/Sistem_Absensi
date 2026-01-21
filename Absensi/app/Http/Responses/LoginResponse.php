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
        // Redirect ke URL default panel (Dashboard)
        // Ini memastikan Admin -> /admin/dashboard
        // Dan Mentor -> /mentor/dashboard

        return redirect()->to(Filament::getCurrentPanel()->getUrl());
    }
}
