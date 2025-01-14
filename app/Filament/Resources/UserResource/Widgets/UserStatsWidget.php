<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class UserStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Admin', User::where('role', User::ADMIN)->count()),
            Stat::make('Editor', User::where('role', User::EDITOR)->count()),
            Stat::make('User', User::where('role', User::DEFAULT_ROLE)->count()),
            Stat::make('Total Users', User::count())
        ];
    }
}
