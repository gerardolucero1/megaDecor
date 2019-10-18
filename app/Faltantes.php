<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faltantes extends Model
{
    protected $fillable = [
        'id',
        'contrato',
        'fecha',
        'nombre_de_persona',
        'descripcion',
        'cantidad_que_falta',
        'dias_desde_no_regreso',
        'id_article',
    ];
}

/*
        'contrato',
        'fecha',
        'nombre_de_persona',
        'descripcion',
        'cantidad_que_falta',
        'dias_desde_no_regreso',

*/