<?php

namespace App;

use App\Client;
use Illuminate\Database\Eloquent\Model;

class PhysicalPerson extends Model
{
    protected $fillable = [
        'client_id',
        'about_id',
        'nombre',
        'apellidoPaterno',
        'apellidoMaterno',
        'email',
        'telefono',

        //Facturacion

        'nombreFacturacion',
        'direccionFacturacion',
        'coloniaFacturacion',
        'numeroFacturacion',
        'rfcFacturacion',
        'emailFacturacion',
        'tipoCredito',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
}
