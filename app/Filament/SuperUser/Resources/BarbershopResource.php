<?php

namespace App\Filament\SuperUser\Resources;

use App\Enums\BarbershopStatusEnum;
use App\Filament\SuperUser\Resources\BarbershopResource\Pages;
use App\Filament\SuperUser\Resources\BarbershopResource\RelationManagers;
use App\Models\Barbershop;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Component;

class BarbershopResource extends Resource
{
    protected static ?string $model = Barbershop::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('gmaps_url')
                    ->maxLength(255),
                Forms\Components\TextInput::make('latitude')
                    ->numeric(),
                Forms\Components\TextInput::make('longitude')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('expired_date')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\IconColumn::make('open_gmap')
                    ->label('Gmap')
                    ->getStateUsing(fn(Barbershop $barbershop): bool => $barbershop->gmaps_url !== null ? true : false)
                    ->icon('heroicon-o-map-pin')->color('info')->alignCenter()
                    ->url(fn (Barbershop $barbershop): string => $barbershop->gmaps_url)->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('coordinate')
                    ->label('Coordinate')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('expired_date')
                    ->label('Valid Until')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('countDown'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state): string => BarbershopStatusEnum::from($state)->getColor()),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()->native(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form([
                        Forms\Components\TextInput::make('name'),
                        Forms\Components\TextInput::make('address'),
                        Forms\Components\TextInput::make('gmaps_url')->label('Google Map URL'),
                        Forms\Components\TextInput::make('geo_location')
                            ->label('Current Location')
                            ->suffixAction(
                                Forms\Components\Actions\Action::make('get_current_location')
                                    ->label('Get Current Location')
                                    ->badge()
                                    ->action(function (Component $livewire) {
                                        $livewire->js('console.log("action clicked")');
                                    })
                            ),
                        Forms\Components\Hidden::make('latitude'),
                        Forms\Components\Hidden::make('longtitude'),
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


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarbershops::route('/'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
