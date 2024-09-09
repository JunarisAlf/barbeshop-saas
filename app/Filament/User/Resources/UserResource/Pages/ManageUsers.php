<?php

namespace App\Filament\User\Resources\UserResource\Pages;

use App\Filament\User\Resources\UserResource;
use App\Models\Barbershop;
use App\Models\Employee;
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
                        ->options(Role::pluck('name', 'id')),
                    Forms\Components\Select::make('employee_id')
                        ->label('Pegawai')
                        ->native(false)
                        ->options(Employee::doesntHave('user')->pluck('fullname', 'id'))
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
