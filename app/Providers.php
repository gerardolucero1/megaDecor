<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Providers extends Model
{
    //
    protected $fillable = [
        'nombre',
        'telefono',
        'correo',
        'direccion',
    ];
}