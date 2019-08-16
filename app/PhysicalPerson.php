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

        //Facturacion

        'nombreFacturacion',
        'direccionFacturacion',
        'coloniaFacturacion',
        'numeroFacturacion',
        'rfcFacturacion',
        'emailFacturacion',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
}
