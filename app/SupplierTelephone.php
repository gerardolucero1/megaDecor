<?php

namespace App;

use App\Supplier;
use Illuminate\Database\Eloquent\Model;

class SupplierTelephone extends Model
{
    protected $guarded = [];

    public function proveedor()
    {
        return $this->belongsTo(Supplier::class, 'proveedor_id');
    }
}
