<?php

namespace App\Enums;

enum BarbershopStatusEnum: string {
    case ACTIVE  = 'active';
    case PENDING = 'pending';
    case EXPIRED = 'expired';

    public function getColor(): string {
        return  match ($this) {
            self::ACTIVE    => 'success',
            self::PENDING   => 'gray',
            self::EXPIRED   => 'danger',
            default         => 'black'
        };
    }
}