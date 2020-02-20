<?php

namespace App;

use App\Client;
use Illuminate\Database\Eloquent\Model;

class Telephone extends Model
{
    protected $fillable = [
        'client_id',
        'nombre',
        'email',
        'apellidoPaterno',
        'apellidoMaterno',
        'tipo',
        'numero',
        'ext',
        'departamento',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
