<?php

namespace App\Filament\User\Resources\EmployeeResource\Pages;

use App\Enums\GenderEnum;
use App\Filament\User\Resources\EmployeeResource;
use Exception;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManageEmployees extends ManageRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->form([
                    Forms\Components\TextInput::make('fullname')->required()->label('Nama Lengkap'),
                    Forms\Components\TextInput::make('wa_number')
                        ->prefix('+628'),
                    Forms\Components\TextInput::make('address'),
                    Forms\Components\Select::make('gender')
                        ->options(GenderEnum::array())
                        ->native(false)->required(),
                ])
                ->using(function (array $data, string $model) {
                    $data['wa_number']      = $data['wa_number'] !== null ? '628' .  $data['wa_number'] : null;
                    $data['barbershop_id']  = Auth::user()->barbershop_id;
                    DB::beginTransaction();
                    try {
                        $model::create($data);
                        DB::commit();
                        Notification::make()->title('Member berhasil dibuat!')->success()->send();
                    } catch (Exception $e) {
                        DB::rollBack();
                        Notification::make()->title('Member Gagal dibuat: ' . $e->getMessage())->danger()->send();
                    }
                })
                ->successNotification(null)->failureNotification(null),
        ];
    }
}
