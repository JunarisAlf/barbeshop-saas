<?php

namespace App\Filament\User\Pages;

use App\Enums\DaysEnum;
use App\Enums\EmployeeTypeEnum;
use App\Enums\SeatTypeEnum;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Seat;
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
use Illuminate\Support\Facades\Auth;

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
                'schedules' => Schedule::all(),
                'seats'     => Seat::all(),
                'employees' => Employee::all(),
            ])
            ->schema([
                Infolists\Components\Grid::make([
                    'md' => 3,
                    'lg' => 6,
                    'xl' => 9,
                ])
                    ->schema([
                        // Schedule
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
                                                    Infolists\Components\Actions\Action::make('edit_schedule')
                                                        ->visible(function (Infolists\Components\Actions\Action $action) {
                                                            $schedule = $action->getComponent()->getRecord();
                                                            return Auth::user()->can('update', $schedule);
                                                        })
                                                        ->iconButton()
                                                        ->icon('heroicon-s-pencil-square')
                                                        ->form([
                                                            Forms\Components\Select::make('day')
                                                                ->options(DaysEnum::array())
                                                                ->native(false)
                                                                ->required()
                                                                ->label('Hari'),
                                                            Forms\Components\TimePicker::make('open')->required()->label('Buka'),
                                                            Forms\Components\TimePicker::make('close')->required()->label('Tutup'),
                                                        ])
                                                        ->label('Edit Jadwal')
                                                        ->fillForm(function (Infolists\Components\Actions\Action $action) {
                                                            $schedule = $action->getComponent()->getRecord();
                                                            return [
                                                                'day'   => $schedule->day,
                                                                'open'  => $schedule->open,
                                                                'close' => $schedule->close,
                                                            ];
                                                        })
                                                        ->action(function (Infolists\Components\Actions\Action $action, array $data) {
                                                            $schedule = $action->getComponent()->getRecord();
                                                            $schedule->fill($data);
                                                            if ($schedule->save()) {
                                                                Notification::make()->title('Update successfully')->success()->send();
                                                            } else {
                                                                Notification::make()->title('Update failed')->danger()->send();
                                                            }
                                                        }),
                                                    Infolists\Components\Actions\Action::make('delete_schedule')
                                                        ->visible(function (Infolists\Components\Actions\Action $action) {
                                                            $schedule = $action->getComponent()->getRecord();
                                                            return Auth::user()->can('delete', $schedule);
                                                        })
                                                        ->iconButton()
                                                        ->color('danger')
                                                        ->icon('heroicon-s-trash')
                                                        ->requiresConfirmation()
                                                        ->action(function (Infolists\Components\Actions\Action $action) {
                                                            $schedule = $action->getComponent()->getRecord();
                                                            if ($schedule->delete()) {
                                                                Notification::make()->title('Deleted successfully')->success()->send();
                                                            } else {
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
                                            Infolists\Components\Actions\Action::make('create_schedule')
                                                ->iconButton()
                                                ->color('info')
                                                ->size(ActionSize::ExtraLarge)
                                                ->icon('heroicon-c-plus-circle')
                                                ->form([
                                                    Forms\Components\Select::make('day')
                                                        ->options(DaysEnum::array())
                                                        ->native(false)
                                                        ->required()
                                                        ->label('Hari'),
                                                    Forms\Components\TimePicker::make('open')->required()->label('Buka'),
                                                    Forms\Components\TimePicker::make('close')->required()->label('Tutup'),
                                                ])
                                                ->label('Tambah Jadwal')
                                                ->action(function (array $data) {
                                                    $data['barbershop_id']  = Auth::user()->id;
                                                    $schedule = new Schedule($data);
                                                    if ($schedule->save()) {
                                                        Notification::make()->title('Create successfully')->success()->send();
                                                    } else {
                                                        Notification::make()->title('Create failed')->danger()->send();
                                                    }
                                                }),
                                        ])
                                            ->columnSpanFull()
                                            ->alignCenter()
                                    ])
                                    ->columnSpan(3)
                                    ->extraAttributes([
                                        'class' => 'dark:bg-white/5'
                                    ])
                                    ->visible(fn() => Auth::user()->can('create', Schedule::class))
                            ])
                            ->visible(fn() => Auth::user()->can('viewAny', Schedule::class))
                            ->columnSpan(3),
                        // Seat
                        Infolists\Components\Grid::make()
                            ->schema([
                                Infolists\Components\RepeatableEntry::make('seats')
                                    ->label('Kursi')
                                    ->schema([
                                        Infolists\Components\TextEntry::make('name')
                                            ->hiddenLabel(fn() => true),
                                        Infolists\Components\TextEntry::make('type')
                                            ->state(fn(Seat $seat) => SeatTypeEnum::getValueFromName($seat->type))
                                            ->hiddenLabel(fn() => true),
                                        Infolists\Components\TextEntry::make('est_duration')
                                            ->state(fn(Seat $seat) => $seat->est_duration . " Menit")
                                            ->hiddenLabel(fn() => true),
                                        Infolists\Components\Grid::make()
                                            ->columnSpan(1)
                                            ->schema([
                                                Infolists\Components\Actions::make([
                                                    Infolists\Components\Actions\Action::make('edit_seat')
                                                        ->visible(function (Infolists\Components\Actions\Action $action) {
                                                            $seat = $action->getComponent()->getRecord();
                                                            return Auth::user()->can('update', $seat);
                                                        })
                                                        ->iconButton()
                                                        ->icon('heroicon-s-pencil-square')
                                                        ->form([
                                                            Forms\Components\Select::make('type')
                                                                ->options(SeatTypeEnum::array())
                                                                ->native(false)
                                                                ->required()
                                                                ->label('Jenis'),
                                                            Forms\Components\TextInput::make('name')->required()->label('Nama'),
                                                            Forms\Components\TextInput::make('est_duration')->numeric()->required()->label('Estimasi Waktu Pengerjaan (Menit)'),
                                                        ])
                                                        ->label('Edit Kursi')
                                                        ->fillForm(function (Infolists\Components\Actions\Action $action) {
                                                            $seat = $action->getComponent()->getRecord();
                                                            return [
                                                                'name'          => $seat->name,
                                                                'est_duration'  => $seat->est_duration,
                                                                'type'          => $seat->type,
                                                            ];
                                                        })
                                                        ->action(function (Infolists\Components\Actions\Action $action, array $data) {
                                                            $seat = $action->getComponent()->getRecord();
                                                            $seat->fill($data);
                                                            if ($seat->save()) {
                                                                Notification::make()->title('Update successfully')->success()->send();
                                                            } else {
                                                                Notification::make()->title('Update failed')->danger()->send();
                                                            }
                                                        }),
                                                    Infolists\Components\Actions\Action::make('delete_seat')
                                                        ->visible(function (Infolists\Components\Actions\Action $action) {
                                                            $seat = $action->getComponent()->getRecord();
                                                            return Auth::user()->can('delete', $seat);
                                                        })
                                                        ->iconButton()
                                                        ->color('danger')
                                                        ->icon('heroicon-s-trash')
                                                        ->requiresConfirmation()
                                                        ->action(function (Infolists\Components\Actions\Action $action) {
                                                            $seat = $action->getComponent()->getRecord();
                                                            if ($seat->delete()) {
                                                                Notification::make()->title('Deleted successfully')->success()->send();
                                                            } else {
                                                                Notification::make()->title('Delete failed')->danger()->send();
                                                            }
                                                        }),
                                                ])
                                                    ->columnSpanFull()
                                                    ->alignEnd()
                                            ])
                                    ])
                                    ->columns(['default' => 4])
                                    ->columnSpanFull(),
                                Infolists\Components\Section::make()
                                    ->schema([
                                        Infolists\Components\Actions::make([
                                            Infolists\Components\Actions\Action::make('create_seat')
                                                ->iconButton()
                                                ->color('info')
                                                ->size(ActionSize::ExtraLarge)
                                                ->icon('heroicon-c-plus-circle')
                                                ->form([
                                                    Forms\Components\Select::make('type')
                                                        ->options(SeatTypeEnum::array())
                                                        ->native(false)
                                                        ->required()
                                                        ->label('Jenis'),
                                                    Forms\Components\TextInput::make('name')->required()->label('Nama'),
                                                    Forms\Components\TextInput::make('est_duration')->numeric()->required()->label('Estimasi Waktu Pengerjaan (Menit)'),
                                                ])
                                                ->label('Tambah Kursi')
                                                ->action(function (array $data) {
                                                    $data['barbershop_id']  = Auth::user()->id;
                                                    $seat = new Seat($data);
                                                    if ($seat->save()) {
                                                        Notification::make()->title('Create successfully')->success()->send();
                                                    } else {
                                                        Notification::make()->title('Create failed')->danger()->send();
                                                    }
                                                }),
                                        ])
                                            ->columnSpanFull()
                                            ->alignCenter()
                                    ])
                                    ->columnSpanFull()
                                    ->extraAttributes([
                                        'class' => 'dark:bg-white/5'
                                    ])
                                    ->visible(fn() => Auth::user()->can('create', Seat::class))
                            ])
                            ->visible(fn() => Auth::user()->can('viewAny', Seat::class))
                            ->columnSpan(4),
                    ])
            ]);
    }
}
