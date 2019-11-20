<?php

namespace App;

use App\BudgetPack;
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
        'guardarInventario'
    ];

    // public function budget()
    // {
    //     return $this->belongsTo(BudgetPack::class);
    // }

    public function budgetPack()
    {
        return $this->belongsTo(BudgetPack::class, 'budget_pack_id');
    }

    
}
