<?php

namespace App\Enums;

use App\Trait\EnumHelper;

enum EmployeeTypeEnum: string
{
    use EnumHelper;
    case OWNER      = 'Pemilik';
    case BARBER     = 'Barber';
    case CASHIER    = 'Kasir';

    public function getColor(): string
    {
        return  match ($this) {
            self::OWNER     => 'danger',
            self::BARBER    => 'success',
            self::CASHIER   => 'primary',
        };
    }
}
