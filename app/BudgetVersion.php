<?php

namespace App;

use App\Client;
use Illuminate\Database\Eloquent\Model;

class BudgetVersion extends Model
{
    //
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

