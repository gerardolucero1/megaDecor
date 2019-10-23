<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtherPayments extends Model
{
    protected $fillable = [
        'tipo',
        'cantidad',
        'motivo',
        'responsable',
        'resto',
        'descripcion',
        'metodo',
        'referencia',
        'banco',
        'contrato',
    ];
}
