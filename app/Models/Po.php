<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Po extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'po';
    protected $guarded = [];

    protected $casts = [
        'dp' => 'double',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'id_po');
    }
}