<?php

namespace App\Enums;

use App\Trait\EnumHelper;

enum BarbershopStatusEnum: string
{
    use EnumHelper;
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
