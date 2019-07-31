<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhysicalPerson extends Model
{
    protected $fillable = [
        'nombre',
        'apellidoPaterno',
        'apellidoMaterno',
        'email',

        //Facturacion

        'nombreFacturacion',
        'direccionFacturacion',
        'coloniaFacturacion',
        'numeroFacturacion',
        'rfcFacturacion',
        'emailFacturacion',
    ];
}
