<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;

class CustomDesign extends Model
{
    protected $table = 'custom_design';
    protected $guarded = [];
    protected $casts = [
        'status' => OrderStatus::class,
    ];

    public function file()
    {
        return $this->hasMany(File::class, 'id_custom', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function designTracking()
    {
        return $this->hasMany(DesignTracking::class, 'id_custom_design', 'id');
    }
}
