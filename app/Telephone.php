<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telephone extends Model
{
    protected $fillable = [
        'cliente_id',
        'tipo',
        'numero',
        'ext',
    ];
}
