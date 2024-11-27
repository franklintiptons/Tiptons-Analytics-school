<?php

namespace App\Filament\Widgets;

use App\Models\School;
use App\Models\User; // Assuming active users are stored in the User model
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SuperadminWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            // Total Schools Stat
            Stat::make('Total Schools', School::count()) // Count of total schools
                ->description('Total number of schools in the system')
                ->descriptionIcon('heroicon-o-building-office-2')
                ->color('primary')
                ->chart([5, 8, 3, 6, 9, 4, 11]), // Optional chart data

            // Total Active Users Stat
            Stat::make('Total Active Users', User::where('status', 'active')->count()) // Count active users
                ->description('Total number of active users')
                ->descriptionIcon('heroicon-o-users')
                ->color('warning')
                ->chart([2, 4, 5, 3, 6, 8, 10]), // Optional chart data for active users
        ];
    }
}