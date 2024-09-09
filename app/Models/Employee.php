<?php

namespace App\Models;

use App\Models\Scopes\BarbershopScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[ScopedBy([BarbershopScope::class])]
class Employee extends Model
{
    use HasFactory;
    public function barbershop(): BelongsTo
    {
        return $this->belongsTo(Barbershop::class);
    }
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
