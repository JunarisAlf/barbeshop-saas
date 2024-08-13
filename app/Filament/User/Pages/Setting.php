<?php

namespace App\Filament\User\Pages;

use App\Enums\DaysEnum;
use App\Models\Schedule;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists;
use Filament\Forms;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\FontWeight;

class Setting extends Page implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.user.pages.setting';

    public static function canAccess(): bool
    {
        return true;
    }


    public function schedulesList(Infolist $infolist): Infolist
    {
        return $infolist
            ->state([
                'schedules' => Schedule::all()
            ])
            ->schema([
                Infolists\Components\Grid::make([
                    'default' => 1,
                    'sm' => 2,
                    'md' => 3,
                    'lg' => 4,
                    'xl' => 6,
                    '2xl' => 8,
                ])
                    ->schema([
                        Infolists\Components\Grid::make()
                            ->schema([
                                Infolists\Components\RepeatableEntry::make('schedules')
                                    ->label('Jadwal')
                                    ->schema([
                                        Infolists\Components\TextEntry::make('day')
                                            ->state(fn(Schedule $schedule) => DaysEnum::getValueFromName($schedule->day))
                                            ->hiddenLabel(fn() => true),
                                        Infolists\Components\TextEntry::make('time')
                                            ->state(fn(Schedule $schedule) => "$schedule->open - $schedule->close")
                                            ->hiddenLabel(fn() => true),
                                        Infolists\Components\Grid::make()
                                            ->columnSpan(1)
                                            ->schema([
                                                Infolists\Components\Actions::make([
                                                    Infolists\Components\Actions\Action::make('Edit')
                                                        ->iconButton()
                                                        ->icon('heroicon-s-pencil-square')
                                                        ->form([
                                                            Forms\Components\Select::make('day')
                                                                ->options(DaysEnum::array())
                                                                ->required(),
                                                            Forms\Components\TimePicker::make('open')->required(),
                                                            Forms\Components\TimePicker::make('close')->required(),
                                                        ])
                                                        ->fillForm(function(Infolists\Components\Actions\Action $action){
                                                            $schedule = $action->getComponent()->getRecord();
                                                            return [
                                                                'day'   => $schedule->day,
                                                                'open'  => $schedule->open,
                                                                'close' => $schedule->close,
                                                            ];
                                                        })
                                                        ->action(function(Infolists\Components\Actions\Action $action, array $data){
                                                            $schedule = $action->getComponent()->getRecord();
                                                            $schedule->fill($data);
                                                            if($schedule->save()){
                                                                Notification::make()->title('Update successfully')->success()->send();
                                                            }else{
                                                                Notification::make()->title('Update failed')->danger()->send();
                                                            }
                                                        }),
                                                    Infolists\Components\Actions\Action::make('Delete')
                                                        ->iconButton()
                                                        ->color('danger')
                                                        ->icon('heroicon-s-trash')
                                                        ->requiresConfirmation()
                                                        ->action(function(Infolists\Components\Actions\Action $action){
                                                            $schedule = $action->getComponent()->getRecord();
                                                            if($schedule->delete()){
                                                                Notification::make()->title('Deleted successfully')->success()->send();
                                                            }else{
                                                                Notification::make()->title('Delete failed')->danger()->send();
                                                            }
                                                        })
                                                ])
                                                    ->columnSpanFull()
                                                    ->alignEnd()
                                            ])
                                    ])
                                    ->columns(['default' => 3])
                                    ->columnSpan(3),
                                Infolists\Components\Section::make()
                                    ->schema([
                                        Infolists\Components\Actions::make([
                                            Infolists\Components\Actions\Action::make('Create')
                                                ->iconButton()
                                                ->color('info')
                                                ->size(ActionSize::ExtraLarge)
                                                ->icon('heroicon-c-plus-circle'),
                                        ])
                                            ->columnSpanFull()
                                            ->alignCenter()
                                    ])
                                    ->columnSpan(3)
                                    ->extraAttributes([
                                        'class' => 'dark:bg-white/5'
                                    ])
                            ])
                            ->columnSpan(3),

                    ])
            ]);
    }
}
