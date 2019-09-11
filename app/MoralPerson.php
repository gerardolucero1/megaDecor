<?php

namespace App;

use App\MoralCategory;
use Illuminate\Database\Eloquent\Model;

class MoralPerson extends Model
{
    protected $fillable = [
        'client_id',
        'categoria_id',
        'about_id',
        'nombre',
        'email',
        'direccionEmpresa',
        'coloniaEmpresa',
        'numeroEmpresa',

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

    public function moralCategory()
    {
        return $this->belongsTo(MoralCategory::class);
    }
}
