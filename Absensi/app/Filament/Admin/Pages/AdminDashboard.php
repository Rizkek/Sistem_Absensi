<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;
use Filament\Widgets;

/**
 * Admin Dashboard
 * System-wide analytics and management
 *
 * Features:
 * - Real-time system stats
 * - Attendance analytics
 * - User management quick access
 * - AI Prompt configuration
 * - Activity monitoring
 */
class AdminDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?int $navigationSort = 0;
    protected static string $view = 'filament.admin.pages.admin-dashboard';
    protected static ?string $title = 'Admin Dashboard';

    public function getHeading(): string
    {
        return 'Dashboard Administrasi';
    }

    public function getSubheading(): ?string
    {
        return 'Pantau sistem, kelola pengguna, dan optimalkan performa';
    }

    /**
     * Get dashboard widgets
     */
    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\AccountWidget::class,
        ];
    }
}
