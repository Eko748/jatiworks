<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';
    protected $guarded = [];
    protected $casts = [
        'status' => OrderStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function katalog()
    {
        return $this->belongsTo(Katalog::class, 'id_katalog');
    }
}
