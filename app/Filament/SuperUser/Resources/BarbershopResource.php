<?php

namespace App\Filament\SuperUser\Resources;

use App\Enums\BarbershopStatusEnum;
use App\Filament\SuperUser\Resources\BarbershopResource\Pages;
use App\Models\Barbershop;
use App\Models\Payment;
use Exception;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Infolists;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class BarbershopResource extends Resource
{
    protected static ?string $model = Barbershop::class;

    protected static ?string $navigationIcon = 'heroicon-s-scissors';


    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->orderBy('created_at', 'DESC'))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\IconColumn::make('open_gmap')
                    ->label('Gmap')
                    ->getStateUsing(fn(Barbershop $barbershop): bool => $barbershop->gmaps_url !== null)
                    ->icon('heroicon-o-map-pin')->color('info')->alignCenter()
                    ->url(fn (Barbershop $barbershop): string => $barbershop->gmaps_url)->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('coordinate')
                    ->label('Coordinate')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('expired_date')
                    ->label('Valid Until')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('countDown'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state): string => BarbershopStatusEnum::getEnumFromName($state)->getColor()),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()->native(false),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->color('warning')
                        ->form([
                            Forms\Components\TextInput::make('name'),
                            Forms\Components\TextInput::make('address'),
                            Forms\Components\TextInput::make('gmaps_url')->label('Google Map URL'),
                        ]),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                    Tables\Actions\Action::make('add_payment')
                        ->label('Add Payment')->icon('heroicon-o-currency-dollar')->color('info')
                        ->form([
                            Forms\Components\Grid::make()
                                ->schema([
                                    Forms\Components\TextInput::make('payer_name')
                                        ->required()
                                        ->columnSpan(1),
                                    Forms\Components\TextInput::make('amount')
                                        ->required()
                                        ->columns(2)
                                        ->prefix('Rp.')
                                        ->mask(RawJs::make(<<<'JS'
                                            $money($input, ',', '.')
                                        JS))
                                        ->stripCharacters('.')
                                ]),
                            Forms\Components\Grid::make()
                                ->schema([
                                    Forms\Components\TextInput::make('days_added')->required()->numeric(),
                                    Forms\Components\TextInput::make('note'),
                                ]),
                            Forms\Components\FileUpload::make('payment_image')
                                ->image()
                                ->maxSize(1024)
                                ->visibility('private')
                                ->disk('local')
                                ->directory('payment_image'),
                        ])
                        ->action(function(Barbershop $barbershop, array $data){
                            try{
                                $data['user_id'] = Auth::user()->id;
                                $barbershop->payments()->create($data);
                                Notification::make()->title('Saved successfully')->success()->send();
                            }catch(Exception $e){
                                Notification::make()->title('Save Failed! ' . $e->getMessage())->danger()->send();
                            }
                        }),
                    Tables\Actions\Action::make('see_payments')
                        ->label('Payment Histories')->icon('heroicon-m-list-bullet')->color('success')
                        ->slideOver()->modalWidth(MaxWidth::SevenExtraLarge)
                        ->infolist([
                            Infolists\Components\RepeatableEntry::make('payments')
                                ->state(fn(Barbershop $barbershop) => $barbershop->payments()->with('user')->orderBy('created_at', 'DESC')->get())
                                ->hiddenLabel(true)
                                ->schema([
                                    Infolists\Components\Grid::make([
                                        'default' => 1, 'sm' => 2, 'md' => 3, 'lg' => 4, 'xl' => 6,
                                    ])
                                    ->schema([
                                        Infolists\Components\TextEntry::make('payer_name')
                                            ->label('Payer Name'),
                                        Infolists\Components\TextEntry::make('amount')
                                            ->label('Amount (Rp.)')
                                            ->state(fn(Payment $payment) => number_format($payment->amount, 0, ',', '.')),
                                        Infolists\Components\TextEntry::make('days_added')
                                            ->label('Days Added'),
                                        Infolists\Components\TextEntry::make('user')
                                            ->state(fn(Payment $payment) => $payment->user->name),
                                        Infolists\Components\TextEntry::make('note'),
                                        Infolists\Components\TextEntry::make('created_at')
                                            ->label('Created At')
                                            ->state(fn(Payment $payment) => $payment->created_at->format('d/m/Y H:i:s')),
                                    ])
                                ])
                            
                        ])
                        ->modalSubmitAction(false)

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
