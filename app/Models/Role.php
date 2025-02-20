<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $table = 'role';
    public $guarded = [];
    public $primaryKey = 'id';

    public function user()
    {
        return $this->hasMany(User::class, 'id_role');
    }

    public function role()
    {
        return $this->hasMany(Role::class, 'id_role');
    }
}
