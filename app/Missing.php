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
    ];

    public function inventory()
    {
        return $this->blongsTo(Inventory::class, 'inventory_id');
    }
}
