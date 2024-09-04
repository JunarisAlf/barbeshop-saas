<?php

namespace App\Enums;

use App\Trait\EnumHelper;

enum EmployeeTypeEnum: string
{
    use EnumHelper;
    case BARBER     = 'Barber';
    case CASHIER    = 'Kasir';
}
