<?php

namespace App;

use App\BudgetPack;
use App\Missing;
use App\Budget;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $guarded = [
        'id'
    ];

    public function missings()
    {
        return $this->hasMany(Missing::class, 'inventory_id');
    }

}
