<?php

namespace App\Filament\User\Resources\RoleResource\Pages;

use App\Filament\User\Resources\RoleResource;
use App\Models\Resource;
use Exception;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManageRoles extends ManageRecords
{
    protected static string $resource = RoleResource::class;
    public $resources;

  
    protected function getHeaderActions(): array
    {
        $checkBoxEntries = [];
        $resources = Resource::with('permissions')->whereNotIn('name', ['Payment'])->get();
        foreach ($resources as $resource) {
            array_push($checkBoxEntries, 
                Forms\Components\Section::make([
                    Forms\Components\CheckboxList::make('permissions')
                        ->label($resource->display)
                        ->options($resource->permissions->pluck('display', 'id'))
                        ->bulkToggleable()
                ])->columnSpan(2)
            );
        }
        return [
            Actions\CreateAction::make()
                ->form([
                    Forms\Components\TextInput::make('name')->required(),
                    Forms\Components\Section::make('Hak Akses')->schema([
                        Forms\Components\Grid::make()
                            ->columns([
                                'sm'    => 2,
                                'lg'    => 4,
                            ])
                            ->schema($checkBoxEntries)

                    ]),
                ])
                ->using(function (array $data, string $model) {
                    DB::beginTransaction();
                    try {
                        $role = $model::create(['name' => $data['name'], 'barbershop_id' => Auth::user()->barbershop_id]);
                        $role->permissions()->attach($data['permissions']);
                        DB::commit();
                        Notification::make()->title('Role berhasil dibuat!')->success()->send();
                    } catch (Exception $e) {
                        DB::rollBack();
                        Notification::make()->title('Role Gagal dibuat: ' . $e->getMessage())->danger()->send();
                    }
                })
                ->successNotification(null),
        ];
    }
}
