<?php

namespace App\Enums;

enum OrderStatus: string
{
    case NotCompleted = 'NC';
    case PaymentCompleted = 'PC';

    public function label(): string
    {
        return match ($this) {
            self::NotCompleted => 'Partial Payment',
            self::PaymentCompleted => 'Payment Completed',
        };
    }
}
