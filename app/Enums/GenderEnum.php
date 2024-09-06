<?php

namespace App\Enums;

use App\Trait\EnumHelper;

enum GenderEnum: string
{
    use EnumHelper;
    case MALE     = 'Laki-Laki';
    case FEMALE   = 'Perempuan';

    public function getColor(): string
    {
        return  match ($this) {
            self::MALE    => 'success',
            self::FEMALE  => 'primary',
        };
    }
}
