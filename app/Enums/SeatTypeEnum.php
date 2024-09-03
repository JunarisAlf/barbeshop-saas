<?php

namespace App\Enums;

use App\Trait\EnumHelper;

enum SeatTypeEnum: string
{
    use EnumHelper;
    case ADULT      = 'Dewasa';
    case KID        = 'Anak-Anak';
}
