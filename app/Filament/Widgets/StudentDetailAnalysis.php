<?php

namespace App\Filament\Widgets;

use App\Models\StudentDetails;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StudentDetailAnalysis extends BaseWidget
{
    protected static bool $isLazy = false;
    protected int | string | array $columnSpan = 'full';
    protected function getStats(): array
    {
        return [
            Stat::make('Total Students',StudentDetails::count())
                ->chart([3, 5, 8, 1, 11, 7, 15])
                ->color('primary'),
            Stat::make('Hostellers',StudentDetails::where('accommodation', 'Hosteller')->count())
                ->chart([3, 5, 8, 1, 11, 7, 15])
                ->color('primary'),
            Stat::make('Day Scholars',StudentDetails::where('accommodation', 'Dayscholar')->count())
                ->chart([3, 5, 8, 1, 11, 7, 15])
                ->color('primary'),
            Stat::make('Active Students',StudentDetails::where('status', 'Active')->count())
                ->chart([3, 5, 8, 1, 11, 7, 15])
                ->color('primary'),
            Stat::make('Inactive Students',StudentDetails::where('status', 'Inactive')->count())
                ->chart([3, 5, 8, 1, 11, 7, 15])
                ->color('primary')
        ];
    }
    public static function canView(): bool
    {
        return auth()->user()->is_admin;
    }
}
