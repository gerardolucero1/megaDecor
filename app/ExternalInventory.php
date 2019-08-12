<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExternalInventory extends Model
{
    protected $fillable = [
        'budget_id',
        'servicio',
        'imagen',
        'precioUnitario',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }
}
