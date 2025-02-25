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
            self::WaitingForPayment => 'Waiting for Payment',
            self::NotCompleted => 'Not Completed',
            self::PaymentCompleted => 'Payment Completed',
        };
    }
}
