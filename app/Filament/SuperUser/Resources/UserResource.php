<?php

namespace App\Filament\SuperUser\Resources;

use App\Filament\SuperUser\Resources\UserResource\Pages;
use App\Models\User;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-s-user-group';

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->orderBy('created_at', 'DESC'))
            ->groups([Tables\Grouping\Group::make('barbershop.name')->collapsible()])
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('employee.wa_number')->searchable()->label('Nomor WA'),
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
                    Tables\Actions\Action::make('change_password')
                        ->label('Change Password')->icon('heroicon-s-key')->color('info')
                        ->form([
                            Forms\Components\TextInput::make('password')
                                ->label('New Password')
                                ->required()
                                ->minLength(6)
                                ->password()->revealable()
                                ->rules(['confirmed']),
                            Forms\Components\TextInput::make('password_confirmation')
                                ->label('Password Confirmation')
                                ->required()
                                ->password()->revealable()
                                ->minLength(6),
                        ])
                        ->action(function(User $user, array $data){
                            try{
                                $user->password         = $data['password'];
                                $user->remember_token   = NULL;
                                $user->save();
                                Notification::make()->title('Change Password successfully')->success()->send();
                            }catch(Exception $e){
                                Notification::make()->title('Change Password Failed! ' . $e->getMessage())->danger()->send();
                            }
                        }),
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
