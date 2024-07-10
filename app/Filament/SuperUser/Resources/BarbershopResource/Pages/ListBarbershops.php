<?php

namespace App\Filament\SuperUser\Resources\BarbershopResource\Pages;

use App\Enums\BarbershopStatusEnum;
use App\Filament\SuperUser\Resources\BarbershopResource;
use App\Models\Barbershop;
use Filament\Actions;
use Filament\Resources;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListBarbershops extends ListRecords
{
    protected static string $resource = BarbershopResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        return [
            'all'   => Resources\Components\Tab::make('All Barbershop')
                ->badge(Barbershop::query()->count()),
            'active'    => Resources\Components\Tab::make('Active')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', BarbershopStatusEnum::ACTIVE))
                ->badge(Barbershop::query()->where('status', BarbershopStatusEnum::ACTIVE)->count()),
            'expired'   => Resources\Components\Tab::make('Expired')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', BarbershopStatusEnum::EXPIRED))
                ->badge(Barbershop::query()->where('status', BarbershopStatusEnum::EXPIRED)->count()),
            'pending'   => Resources\Components\Tab::make('Pending')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', BarbershopStatusEnum::PENDING))
                ->badge(Barbershop::query()->where('status', BarbershopStatusEnum::PENDING)->count())
        ];
    }
}
