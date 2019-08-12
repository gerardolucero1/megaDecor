<?php

namespace App;

use App\Client;
use Illuminate\Database\Eloquent\Model;

class Telephone extends Model
{
    protected $fillable = [
        'cliente_id',
        'tipo',
        'numero',
        'ext',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
