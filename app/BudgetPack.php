<?php

namespace App;

use App\Inventory;
use Illuminate\Database\Eloquent\Model;

class BudgetPack extends Model
{
    protected $fillable = [
        'budget_id',
        'servicio',
        'cantidad',
        'precioUnitario',
        'precioFinal',
        'ahorro',
        'notas',
        'categoria',
        'guardarPaquete',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }
}
