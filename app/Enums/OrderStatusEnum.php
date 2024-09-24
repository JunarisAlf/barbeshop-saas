<?php

namespace App\Enums;

use App\Trait\EnumHelper;

enum OrderStatusEnum: string
{
    use EnumHelper;
    case QUEUE      = 'Antri';
    case PROCESS    = 'Pengerjaan';
    case FINISHED   = 'Selesai';
    case CANCELLED  = 'Batal';

    public function getColor(): string
    {
        return  match ($this) {
            self::QUEUE     => 'warning',
            self::PROCESS   => 'primary',
            self::FINISHED  => 'success',
            self::CANCELLED => 'danger',
        };
    }
}
