<?php

namespace App;

use App\User;
use App\Client;
use App\Celebrated;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = [
        'folio',
        'vendedor_id',
        'client_id',
        'tipoEvento',
        'tipoServicio',
        'categoriaEvento',
        'fechaEvento',
        'pendienteFecha',
        'horaEventoInicio',
        'horaEventoFin',
        'pendienteHora',
        'lugarEvento',
        'nombreLugar',
        'direccionLugar',
        'numeroLugar',
        'coloniaLugar',
        'CPLugar',
        'observacionesLugar',
        'numeroInvitados',
        'colorEvento',
        'temaEvento',
        'opcionPrecioUnitario',
        'opcionDescripcionPaquete',
        'opcionImagen',
        'opcionPrecio',
        'opcionDescuento',
        'opcionIVA',
        'tipo',
        'impresion',

        //Datos facturacion
        'horaInicio',
        'horaFin',
        'horaEntrega',
        'fechaRecoleccion',
        'notasFacturacion',
        'nombreFacturacion',
        'direccionFacturacion',
        'numeroFacturacion',
        'coloniaFacturacion',
        'emailFacturacion',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function celebrateds()
    {
        return $this->hasMany(Celebrated::class);
    }

    public function budgetPacks()
    {
        return $this->hasMany(BudgetPack::class);
    }
}
