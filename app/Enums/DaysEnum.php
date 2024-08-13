<?php

namespace App\Enums;

use App\Trait\EnumHelper;

enum DaysEnum: string
{
    use EnumHelper;
    case SUNDAY     = 'Minggu';
    case MONDAY     = 'Senin';
    case TUESDAY    = 'Selasa';
    case WEDNESDAY  = 'Rabu';
    case THURSDAY   = 'Kamis';
    case FRIDAY     = 'Jumat';
    case SATURDAY   = 'Sabtu';

}
