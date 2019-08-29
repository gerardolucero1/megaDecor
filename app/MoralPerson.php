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

    public function moralCategory()
    {
        return $this->belongsTo(MoralCategory::class);
    }
}
