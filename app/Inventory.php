<?php

namespace App;

use App\BudgetPack;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'servicio',
        'cantidad',
        'imagen',
        'precioUnitario',
    ];
}