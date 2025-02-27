<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrackingStep extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tracking_step';

    protected $fillable = [
        'step_name',
        'step_order'
    ];

    public function orderTrackings()
    {
        return $this->hasMany(OrderTracking::class, 'id_tracking_step');
    }
}