<?php

namespace App\Models;

use App\Observers\PaymentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $barbershop_id
 * @property string $payer_name
 * @property int $amount
 * @property int $days_added
 * @property string|null $note
 * @property string|null $payment_image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SuperUser $user
 * @method static \Database\Factories\PaymentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereBarbershopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDaysAdded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePayerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUserId($value)
 * @mixin \Eloquent
 */
#[ObservedBy([PaymentObserver::class])]
class Payment extends Model
{
    use HasFactory;
    public function user(): BelongsTo{
        return $this->belongsTo(SuperUser::class, 'user_id', 'id');
    }
}
