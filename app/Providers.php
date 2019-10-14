<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Providers extends Model
{
    protected $fillable = [
        'nombre',
        'telefono',
        'correo',
        'direccion',
    ];
}

/*
                <td>{{ $provedor->id }}</td>
                <td>{{ $provedor->nombre }}</td>
                <td>{{ $provedor->telefono }}</td>
                <td>{{ $provedor->correo }}</td>
                <td>{{ $provedor->direccion }}</td>

*/