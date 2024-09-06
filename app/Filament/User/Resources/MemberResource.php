<?php

namespace App\Filament\User\Resources;

use App\Enums\GenderEnum;
use App\Filament\User\Resources\MemberResource\Pages;
use App\Filament\User\Resources\MemberResource\RelationManagers;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fullname')->label('Nama'),
                Tables\Columns\TextColumn::make('wa_number')->label('Nomor WA'),
                Tables\Columns\TextColumn::make('email')->label('Email'),
                Tables\Columns\TextColumn::make('address')->label('Alamat'),
                Tables\Columns\TextColumn::make('gender')
                    ->label('Gender')
                    ->badge()
                    ->color(fn(Member $member): string => GenderEnum::getEnumFromName($member->gender)->getColor())
                    ->state(fn(Member $member): string => GenderEnum::getValueFromName($member->gender)),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form([
                        Forms\Components\TextInput::make('fullname')->required()->label('Nama Lengkap'),
                        Forms\Components\TextInput::make('wa_number')
                            ->prefix('+628')
                            ->afterStateHydrated(function (Forms\Components\TextInput $component, string $state) {
                                $component->state(substr($state, 3));
                            })
                            ->dehydrateStateUsing(fn (string $state): string => "628" . $state),
                        Forms\Components\TextInput::make('email')->email(),
                        Forms\Components\TextInput::make('address'),
                        Forms\Components\Select::make('gender')
                            ->options(GenderEnum::array())
                            ->native(false)->required(),
                    ]),
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
            'index' => Pages\ManageMembers::route('/'),
        ];
    }
}
