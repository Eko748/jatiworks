<?php

namespace App\Enums;

enum OrderStatus: string
{
    case NotCompleted = 'NC';
    case PaymentCompleted = 'PC';

    public function label(): string
    {
        return match ($this) {
            self::NotCompleted => 'Not Completed',
            self::PaymentCompleted => 'Payment Completed',
        };
    }
}
