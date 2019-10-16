<?php

namespace App;

use App\Budget;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'budget_id',
        'method',
        'amount',
        'reference',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }
}
