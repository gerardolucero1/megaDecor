<?php

namespace App;

use App\Budget;
use Illuminate\Database\Eloquent\Model;

class Celebrated extends Model
{
    protected $fillable = [
        'budget_id',
        'nombre',
        'edad',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }
}
