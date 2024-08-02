<?php

namespace App\Filament\User\Resources\UserResource\Pages;

use App\Filament\User\Resources\UserResource;
use App\Models\Barbershop;
use App\Models\Role;
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
                        ->default(null)
                        ->email()
                        ->unique(),
                    Forms\Components\TextInput::make('wa_number')
                        ->label('WA')
                        ->default('1234567890')
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
                    Forms\Components\Select::make('roles')
                        ->label('Role')
                        ->native(false)
                        ->multiple()
                        ->options(Role::pluck('name', 'id'))
                ])
                ->using(function (array $data, string $model) {
                    $roles = $data['roles'];
                    unset($data['password_confirmation']);
                    unset($data['roles']);
                    return $model::create($data)->roles()->attach($roles);
                }),
        ];
    }
}
