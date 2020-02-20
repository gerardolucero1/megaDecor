<?php

namespace App;

use App\User;
use App\Budget;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    protected $fillable = [
        'budget_id',
        'user_id',
        'cantidad',
        'fechaCompra',
        'fechaIngreso',
        'proveedor',
        'factura',
        'motivo',
        'precio',
        'producto',
        'tipo',
        'antes',
        'antesExhibicion',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }
}
