<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = 'information';

    protected $fillable = [
        'address',
        'email',
        'phone',
        'linkedin',
        'youtube',
        'instagram',
        'facebook',
        'tiktok',
    ];
}
