<?php

namespace App\Enums;

use App\Trait\EnumToArray;

enum BarbershopStatusEnum: string
{
    use EnumToArray;
    case ACTIVE  = 'active';
    case PENDING = 'pending';
    case EXPIRED = 'expired';

    public function getColor(): string
    {
        return  match ($this) {
            self::ACTIVE    => 'success',
            self::PENDING   => 'gray',
            self::EXPIRED   => 'danger',
            default         => 'black'
        };
    }
    
}
