<?php

namespace App\Filament\SuperUser\Resources\BarbershopResource\Widgets;

use App\Enums\BarbershopStatusEnum;
use App\Models\Barbershop;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BarbershopStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $pollingInterval = null;
    protected function getStats(): array
    {
        return [
            Stat::make('Total', Barbershop::count())
                ->description(
                    Barbershop::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count()
                    . " This Month"
                )
                ->color('success'),
            Stat::make('Active', Barbershop::where('status', BarbershopStatusEnum::ACTIVE)->count() )
                ->color('success'),
            Stat::make('Expired', Barbershop::where('status', BarbershopStatusEnum::EXPIRED)->count() )
                ->color('danger'),
            Stat::make('Pending', Barbershop::where('status', BarbershopStatusEnum::PENDING)->count() )
                ->color('gray'),
        ];
    }
 
}
