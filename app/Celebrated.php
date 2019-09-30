<?php

namespace App;

use App\Budget;
use App\Client;
use Illuminate\Database\Eloquent\Model;

class Celebrated extends Model
{
    protected $fillable = [
        'budget_id',
        'client_id',
        'nombre',
        'edad',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
