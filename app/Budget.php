<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = [
        'folio',
        'vendedor_id',
        'cliente_id',
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
    ];
}
