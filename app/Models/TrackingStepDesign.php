<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrackingStepDesign extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tracking_step_design';

    protected $fillable = [
        'step_name',
        'step_order'
    ];

    public function designTracking()
    {
        return $this->hasMany(DesignTracking::class, 'id_tracking_step_design');
    }
}
