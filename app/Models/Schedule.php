<?php

namespace App\Models;

use App\Models\Scopes\BarbershopScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([BarbershopScope::class])]
class Schedule extends Model
{
    use HasFactory;
    protected function open(): Attribute
    {
        return Attribute::make(
            get: fn(string $open) => Carbon::parse($open)->format('H:i')
        );
    }
    protected function close(): Attribute
    {
        return Attribute::make(
            get: fn(string $close) => Carbon::parse($close)->format('H:i')
        );
    }
}
