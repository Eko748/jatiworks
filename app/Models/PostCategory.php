<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    protected $table = 'post_category';
    protected $guarded = [];

    public function katalog()
    {
        return $this->belongsTo(Katalog::class, 'id_katalog');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }
}
