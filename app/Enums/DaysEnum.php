<?php

namespace App\Enums;

use App\Trait\EnumToArray;

enum DaysEnum: string
{
    use EnumToArray;
    case SUNDAY     = 'Minggu';
    case MONDAY     = 'Senin';
    case TUESDAY    = 'Selasa';
    case WEDNESDAY  = 'Rabu';
    case THURSDAY   = 'Kamis';
    case FRIDAY     = 'Jumat';
    case SATURDAY   = 'Sabtu';

}
