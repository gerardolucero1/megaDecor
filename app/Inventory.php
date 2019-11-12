<?php

namespace App;

use App\BudgetPack;
use App\Missing;
use App\Budget;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'servicio',
        'cantidad',
        'imagen',
        'precioUnitario',
        'precioVenta',
        'disponible',
        'proveedor1',
        'proveedor2',
        'tipoCambio',
        'exhibicion',
        'autorizado',
        'familia',
    ];

    public function missings()
    {
        return $this->hasMany(Missing::class, 'inventory_id');
    }

}
