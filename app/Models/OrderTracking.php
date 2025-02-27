<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderTracking extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_tracking';

    protected $fillable = [
        'id_order',
        'id_tracking_step',
        'status',
        'notes',
        'file_name',
        'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order');
    }

    public function trackingStep()
    {
        return $this->belongsTo(TrackingStep::class, 'id_tracking_step');
    }
}
