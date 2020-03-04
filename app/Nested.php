<?php

namespace App;

use App\Inventory;
use Illuminate\Database\Eloquent\Model;

class Nested extends Model
{
    protected $guarded = [
        'id',
    ];

    public function product()
    {       
        return $this->belongsTo(Inventory::class, 'inventory_id');
    } 
}
