<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Katalog extends Model
{
    use HasFactory;

    protected $table = 'katalog';
    protected $guarded = [];

    public function category_list()
    {
        return $this->hasMany(User::class, 'id_katalog');
    }
}
