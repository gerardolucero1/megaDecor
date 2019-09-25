<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetPackInventory extends Model
{
    protected $fillable = [
        'budget_pack_id',
        'servicio',
        'imagen',
        'cantidad',
        'precioUnitario',
        'precioFinal',
        'precioVenta',
        'precioEspecial',
        'proveedor',
        'externo',
    ];

    public function budget()
    {
        return $this->belongsTo(BudgetPack::class);
    }
}
