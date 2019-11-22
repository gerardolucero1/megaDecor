<?php

namespace App;

use App\SupplierTelephone;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $guarded = [];

    public function telefonos()
    {
        return $this->hasMany(SupplierTelephone::class, 'proveedor_id');
    }
}
