<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\LeaveRequest;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected ?string $poolingInterval = '60s';
    protected function getStats(): array
    {
        return [
            Stat::make('Total Employees', User::count())
                ->description('Active Employees in the system')
                ->descriptionIcon('heroicon-o-users')
                ->color('success'),
            Stat::make('Departments', Department::count())
                ->description('Active Department in the system')
                ->descriptionIcon('heroicon-o-building-office')
                ->color('info'),
            Stat::make('Pending Leave Request', LeaveRequest::where('status', 'pending')->count())                
                ->description('Awaiting approval')
                ->descriptionIcon('heroicon-o-calendar-days')
                ->color('warning'),
            Stat::make('Today\'s Attendance', Attendance::whereDate('date', today())->count())
                ->description('Checked in Today')
                ->descriptionIcon('heroicon-o-clock')
                ->color('primary')
        ];
    }
}
