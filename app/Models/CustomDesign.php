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
}
