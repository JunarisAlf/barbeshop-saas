<?php

namespace App\Models;

use App\Models\Scopes\BarbershopScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ScopedBy([BarbershopScope::class])]
class Seat extends Model
{
    use HasFactory;
    public function barbershop(): BelongsTo
    {
        return $this->belongsTo(Barbershop::class);
    }
}
