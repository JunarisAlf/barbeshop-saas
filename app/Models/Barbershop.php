<?php

namespace App\Models;

use App\Observers\BarbershopObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string|null $gmaps_url
 * @property string $expired_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $coordinate
 * @property-read mixed $count_down
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\BarbershopFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Barbershop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Barbershop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Barbershop onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Barbershop query()
 * @method static \Illuminate\Database\Eloquent\Builder|Barbershop whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barbershop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barbershop whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barbershop whereExpiredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barbershop whereGmapsUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barbershop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barbershop whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barbershop whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barbershop whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barbershop withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Barbershop withoutTrashed()
 * @mixin \Eloquent
 */
#[ObservedBy([BarbershopObserver::class])]
class Barbershop extends Model
{
    use SoftDeletes;
    use HasFactory;

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
    protected function coordinate(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                if ($this->latitude == null || $this->longtitude == null) {
                    return '-';
                }
                return "$this->latitude, $this->longtitude";
            }
        );
    }
    protected function countDown(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->expired_date)->diffForHumans()
        );
    }
}
