<?php

namespace App\Enums;

enum OrderStatus: string
{
    case WaitingForPayment = 'WP';
    case NotCompleted = 'NC';
    case PaymentCompleted = 'PC';

    public function label(): string
    {
        return match ($this) {
            self::WaitingForPayment => 'Waiting For Payment',
            self::NotCompleted => 'Partial Payment',
            self::PaymentCompleted => 'Payment Completed',
        };
    }
}
