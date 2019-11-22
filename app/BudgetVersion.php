<?php

namespace App;

use App\Client;
use Illuminate\Database\Eloquent\Model;

class BudgetVersion extends Model
{
    protected $fillable = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

