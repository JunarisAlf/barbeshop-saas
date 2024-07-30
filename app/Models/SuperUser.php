<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $wa_number
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|SuperUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuperUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuperUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|SuperUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperUser whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperUser whereWaNumber($value)
 * @mixin \Eloquent
 */
class SuperUser extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
