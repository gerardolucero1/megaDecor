<?php

namespace App;

use App\Budget;
use App\Nested;
use App\Missing;
use App\BudgetPack;
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

    public function products()
    {
        return $this->hasMany(Nested::class);
    }

}
