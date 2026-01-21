<?php

namespace App\Filament\Admin\Resources;

use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationGroup;

/**
 * Admin Navigation Builder
 */
class AdminNavigation
{
    public static function getDashboard(): NavigationItem
    {
        return NavigationItem::make('Dashboard')
            ->icon('heroicon-o-home')
            ->label('Dashboard')
            ->url('/admin')
            ->isActiveWhen(fn () => request()->is('admin'))
            ->sort(0);
    }

    public static function getAnalyticsGroup(): NavigationGroup
    {
        return NavigationGroup::make()
            ->label('Analytics')
            ->items([
                NavigationItem::make('User Analytics')
                    ->icon('heroicon-o-chart-bar')
                    ->url('/admin/analytics/users'),

                NavigationItem::make('Attendance Reports')
                    ->icon('heroicon-o-document-text')
                    ->url('/admin/analytics/attendance'),
            ])
            ->icon('heroicon-o-chart-pie');
    }

    public static function getSystemGroup(): NavigationGroup
    {
        return NavigationGroup::make()
            ->label('System')
            ->items([
                NavigationItem::make('Users')
                    ->icon('heroicon-o-user-group')
                    ->url('/admin/users'),

                NavigationItem::make('Settings')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->url('/admin/settings'),

                NavigationItem::make('Logs')
                    ->icon('heroicon-o-document-duplicate')
                    ->url('/admin/logs'),
            ])
            ->collapsible()
            ->icon('heroicon-o-cog-6-tooth');
    }
}
