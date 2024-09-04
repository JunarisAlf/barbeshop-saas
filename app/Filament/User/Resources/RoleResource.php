<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\RoleResource\Pages;
use App\Filament\User\Resources\RoleResource\RelationManagers;
use App\Models\Resource as ModelsResource;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';



    public static function table(Table $table): Table
    {   
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Role'),
                Tables\Columns\TextColumn::make('users_count')->counts('users')->label('Jumlah User'),
                Tables\Columns\TextColumn::make('users')
                    ->label('Daftar Pengguna')
                    ->badge()->color('info')
                    ->state(fn(Role $role) => $role->users->pluck('name')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
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
                                            ->options(ModelsResource::where('name', 'User')->first()->permissions->pluck('display', 'id'))
                                            ->bulkToggleable()
                                            ->formatStateUsing(fn (Role $role) => $role->permissions()->pluck('permission_id'))
                                    ])->columnSpan(2),
                                    Forms\Components\Section::make([
                                        Forms\Components\CheckboxList::make('permissions')->label('Role')
                                            ->options(ModelsResource::where('name', 'Role')->first()->permissions->pluck('display', 'id'))
                                            ->bulkToggleable()
                                            ->formatStateUsing(fn (Role $role) => $role->permissions()->pluck('permission_id'))
                                    ])->columnSpan(2),
                                    Forms\Components\Section::make([
                                        Forms\Components\CheckboxList::make('permissions')->label('Jadwal')
                                            ->options(ModelsResource::where('name', 'Schedule')->first()->permissions->pluck('display', 'id'))
                                            ->bulkToggleable()
                                            ->formatStateUsing(fn (Role $role) => $role->permissions()->pluck('permission_id'))
                                    ])->columnSpan(2),
                                    Forms\Components\Section::make([
                                        Forms\Components\CheckboxList::make('permissions')->label('Kursi')
                                            ->options(ModelsResource::where('name', 'Seat')->first()->permissions->pluck('display', 'id'))
                                            ->bulkToggleable()
                                            ->formatStateUsing(fn (Role $role) => $role->permissions()->pluck('permission_id'))
                                    ])->columnSpan(2),
                                    Forms\Components\Section::make([
                                        Forms\Components\CheckboxList::make('permissions')->label('Pegawai')
                                            ->options(ModelsResource::where('name', 'Employee')->first()->permissions->pluck('display', 'id'))
                                            ->bulkToggleable()
                                            ->formatStateUsing(fn (Role $role) => $role->permissions()->pluck('permission_id'))
                                    ])->columnSpan(2),
                                ])
                            
                        ]),
                    ])
                    ->using(function(Role $role, array $data){
                        $role->name     = $data['name'];
                        $role->save();
                        $role->permissions()->sync($data['permissions']);
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRoles::route('/'),
        ];
    }
}
