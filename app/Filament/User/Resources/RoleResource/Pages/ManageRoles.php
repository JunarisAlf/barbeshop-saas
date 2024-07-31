<?php

namespace App\Filament\User\Resources\RoleResource\Pages;

use App\Filament\User\Resources\RoleResource;
use App\Models\Resource;
use Auth;
use DB;
use Exception;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;

class ManageRoles extends ManageRecords
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
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
                            ->schema([
                                Forms\Components\Section::make([
                                    Forms\Components\CheckboxList::make('permissions')->label('Pengguna')
                                        ->options(Resource::where('name', 'User')->first()->permissions->pluck('display', 'id'))
                                        ->bulkToggleable()
                                ])->columnSpan(2),
                                Forms\Components\Section::make([
                                    Forms\Components\CheckboxList::make('permissions')->label('Role')
                                        ->options(Resource::where('name', 'Role')->first()->permissions->pluck('display', 'id'))
                                        ->bulkToggleable()
                                ])->columnSpan(2),
                            ])
                        
                    ]),
                ])
                ->using(function(array $data, string $model){
                    DB::beginTransaction();
                    try{
                        $role = $model::create(['name' => $data['name'], 'barbershop_id' => Auth::user()->barbershop_id]);
                        $role->permissions()->attach($data['permissions']);
                        DB::commit();
                        Notification::make()->title('Role berhasil dibuat!')->success()->send();
                    }catch(Exception $e){
                        DB::rollBack();
                        Notification::make()->title('Role Gagal dibuat: ' . $e->getMessage())->danger()->send();
                    }
                })
                ->successNotification(null),
        ];
    }
}
