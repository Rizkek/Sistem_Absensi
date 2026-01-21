<?php

namespace App\Filament\Mentor\Resources;

use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationGroup;

/**
 * Mentor Navigation Builder
 */
class MentorNavigation
{
    public static function getDashboard(): NavigationItem
    {
        return NavigationItem::make('Dashboard')
            ->icon('heroicon-o-home')
            ->label('Dashboard')
            ->url('/mentor')
            ->isActiveWhen(fn () => request()->is('mentor'))
            ->sort(0);
    }

    public static function getStudentGroup(): NavigationGroup
    {
        return NavigationGroup::make()
            ->label('Students')
            ->items([
                NavigationItem::make('My Students')
                    ->icon('heroicon-o-users')
                    ->url('/mentor/students'),

                NavigationItem::make('Student Progress')
                    ->icon('heroicon-o-arrow-trending-up')
                    ->url('/mentor/progress'),

                NavigationItem::make('Attendance')
                    ->icon('heroicon-o-check-circle')
                    ->url('/mentor/attendance'),
            ])
            ->icon('heroicon-o-users');
    }

    public static function getSessionGroup(): NavigationGroup
    {
        return NavigationGroup::make()
            ->label('Sessions')
            ->items([
                NavigationItem::make('My Sessions')
                    ->icon('heroicon-o-calendar-days')
                    ->url('/mentor/sessions'),

                NavigationItem::make('Reports')
                    ->icon('heroicon-o-document-text')
                    ->url('/mentor/reports'),

                NavigationItem::make('Feedback')
                    ->icon('heroicon-o-chat-bubble-left')
                    ->url('/mentor/feedback'),
            ])
            ->icon('heroicon-o-calendar');
    }

    public static function getToolsGroup(): NavigationGroup
    {
        return NavigationGroup::make()
            ->label('Tools')
            ->items([
                NavigationItem::make('AI Assistant')
                    ->icon('heroicon-o-sparkles')
                    ->url('/mentor/ai-assistant'),

                NavigationItem::make('Settings')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->url('/mentor/settings'),
            ])
            ->icon('heroicon-o-wrench-screwdriver')
            ->collapsible();
    }
}
