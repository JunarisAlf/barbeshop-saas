<?php

namespace App\Enums;

use App\Trait\EnumToArray;

enum DaysEnum
{
    use EnumToArray;
    case SUNDAY;
    case MONDAY;
    case TUESDAY;
    case WEDNESDAY;
    case THURSDAY;
    case FRIDAY;
    case SATURDAY;

    public static function getLabel(self $value): string {
        return match ($value) {
            Self::SUNDAY    => 'Minggu',
            Self::MONDAY    => 'Senin',
            Self::TUESDAY   => 'Selasa',
            Self::WEDNESDAY => 'Rabu',
            Self::THURSDAY  => 'Kamis',
            Self::FRIDAY    => 'Jumat',
            Self::SATURDAY  => 'Sabtu',

        };
    }

}
