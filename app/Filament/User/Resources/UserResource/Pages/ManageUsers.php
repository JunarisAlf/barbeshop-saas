<?php

namespace App\Filament\User\Resources\UserResource\Pages;

use App\Filament\User\Resources\UserResource;
use App\Models\Barbershop;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\ManageRecords;

class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->form([
                    Forms\Components\TextInput::make('name')->required(),
                    Forms\Components\TextInput::make('email')
                        ->required()
                        ->email()
                        ->unique(),
                    Forms\Components\TextInput::make('wa_number')
                        ->label('WA')
                        ->required()
                        ->prefix('+628')
                        ->dehydrateStateUsing(fn (string $state): string => "628" . $state),
                    Forms\Components\TextInput::make('password')
                        ->label('Password')
                        ->required()
                        ->minLength(6)
                        ->password()->revealable()
                        ->rules(['confirmed']),
                    Forms\Components\TextInput::make('password_confirmation')
                        ->label('Password Confirmation')
                        ->required()
                        ->password()->revealable()
                        ->minLength(6),
                ])
                ->using(function (array $data, string $model) {
                    unset($data['password_confirmation']);
                    return $model::create($data);
                }),
        ];
    }
}
