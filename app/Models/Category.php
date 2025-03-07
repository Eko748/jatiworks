<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';
    protected $guarded = [];

    public function katalog()
    {
        return $this->belongsToMany(Katalog::class, 'post_category', 'id_category', 'id_katalog');
    }
}
