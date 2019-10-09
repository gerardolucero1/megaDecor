<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamilyGroup extends Model
{
    protected $fillable = [
        'nombre',
        'informacion',
    ];
}
