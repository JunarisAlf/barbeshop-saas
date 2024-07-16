<?php

namespace App\Models;

use App\Observers\PaymentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([PaymentObserver::class])]
class Payment extends Model
{
    use HasFactory;
    public function user(): BelongsTo{
        return $this->belongsTo(SuperUser::class, 'user_id', 'id');
    }
}
