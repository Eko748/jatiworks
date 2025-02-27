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

    public function file()
    {
        return $this->hasMany(File::class, 'id_order', 'id');
    }

    public function orderTracking()
    {
        return $this->hasMany(OrderTracking::class, 'id_order', 'id');
    }
}
