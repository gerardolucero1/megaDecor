<?php

namespace App;

use App\Inventory;
use Illuminate\Database\Eloquent\Model;

class Missing extends Model
{
    protected $fillable = [
        'inventory_id',
        'servicio',
        'saliente',
        'faltante',
        'total',
        'reportado',
        'aprobado',
        'informe',
        'imagen',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }
}
