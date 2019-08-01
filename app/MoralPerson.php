<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoralPerson extends Model
{
    protected $fillable = [
        'cliente_id',
        'categoria',
        'about_id',
        'nombre',
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
        return $this->hasOne(App\Client::class);
    }
}
