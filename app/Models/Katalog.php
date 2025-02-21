<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Katalog extends Model
{
    use HasFactory;

    protected $table = 'katalog';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsToMany(Category::class, 'post_category', 'id_katalog', 'id_category');
    }

    public function file()
    {
        return $this->hasMany(File::class, 'id_katalog', 'id');
    }
}
