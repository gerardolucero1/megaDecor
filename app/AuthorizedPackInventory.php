<?php

namespace App;

use App\AuthorizedPack;
use Illuminate\Database\Eloquent\Model;

class AuthorizedPackInventory extends Model
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

    public function pack()
    {
        return $this->belongsTo(AuthorizedPack::class, 'budget_pack_id');
    }
}
