<?php

namespace App;

use App\Budget;
use Illuminate\Database\Eloquent\Model;

class BudgetInventory extends Model
{
    protected $fillable = [
        'budget_id',
        'servicio',
        'imagen',
        'cantidad',
        'precioUnitario',
        'precioFinal',
        'precioVenta',
        'precioEspecial',
        'ahorro',
        'notas',
        'proveedor',
        'externo',
        'guardarInventario',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'budget_id');
    }
}
