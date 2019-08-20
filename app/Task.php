<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'vendedor_id',
        'categoria',
        'cliente_id',
        'fecha',
        'notas'

    ];
}