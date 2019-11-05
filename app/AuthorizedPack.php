<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthorizedPack extends Model
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

    public function inventories()
    {
        return $this->hasMany(AuthorizedPackInventory::class, 'budget_pack_id');
    }

}
