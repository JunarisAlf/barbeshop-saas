<?php

namespace App\Filament\SuperUser\Resources;

use App\Filament\SuperUser\Resources\UserResource\Pages;
use App\Filament\SuperUser\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-user-group';

    public static function table(Table $table): Table
    {
        return $table
            ->groups([Tables\Grouping\Group::make('barbershop.name')->collapsible()])
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('wa_number')->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()->native(false),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->color('warning')
                        ->form([
                            Forms\Components\TextInput::make('name')
                                ->required(),
                            Forms\Components\TextInput::make('email')
                                ->required()
                                ->email()
                                ->unique(ignoreRecord: true),
                            Forms\Components\TextInput::make('wa_number')
                                ->label('WA')
                                ->required()
                                ->prefix('+628')
                                ->afterStateHydrated(function (Forms\Components\TextInput $component, string $state) {
                                    $component->state(substr($state, 3));
                                })
                                ->dehydrateStateUsing(fn (string $state): string => "628" . $state),
                        ]),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    // Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
