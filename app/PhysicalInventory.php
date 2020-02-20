<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhysicalInventory extends Model
{
    protected $fillable = [
        'idProducto',
        'antesBodega',
        'antesExhibicion',
        'fisicoBodega',
        'fisicoExhibicion',
        'diferencia',
    ];
}
