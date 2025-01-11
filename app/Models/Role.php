<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ROLE_ADMINISTRADOR = 1;
    const ROLE_EQUIPE_VENDAS = 2;
    const ROLE_CLIENTE = 3;


    protected $fillable = [
        'name'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
