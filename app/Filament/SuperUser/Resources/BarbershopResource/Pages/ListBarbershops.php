<?php

namespace App\Filament\SuperUser\Resources\BarbershopResource\Pages;

use App\Filament\SuperUser\Resources\BarbershopResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBarbershops extends ListRecords
{
    protected static string $resource = BarbershopResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
