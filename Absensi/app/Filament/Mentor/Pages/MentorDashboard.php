<?php

namespace App\Filament\Mentor\Pages;

use Filament\Pages\Page;
use App\Livewire\AiCopilotPanel;

/**
 * Mentor Dashboard
 * Professional, clean interface for mentors
 * Features:
 * - Real-time attendance overview
 * - AI Copilot assistant
 * - Quick actions
 * - Session management
 */
class MentorDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?int $navigationSort = 0;
    protected static string $view = 'filament.mentor.pages.dashboard';
    protected static ?string $title = 'Dashboard Pembimbing';

    public function getHeading(): string
    {
        return 'Selamat Datang, ' . auth()->user()->name;
    }

    public function getSubheading(): ?string
    {
        return 'Kelola halaqah dan monitoring santri dengan mudah';
    }
}
