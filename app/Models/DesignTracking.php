<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DesignTracking extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'design_tracking';

    protected $fillable = [
        'id_custom_design',
        'id_tracking_step_design',
        'status',
        'notes',
        'file_name',
        'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime'
    ];

    public function custom()
    {
        return $this->belongsTo(CustomDesign::class, 'id_custom_design');
    }

    public function trackingStepDesign()
    {
        return $this->belongsTo(TrackingStepDesign::class, 'id_tracking_step_design');
    }
}
