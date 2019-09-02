<?php

namespace App;

use App\MoralPerson;
use Illuminate\Database\Eloquent\Model;

class MoralCategory extends Model
{
    protected $fillable = [
        'nombre',
    ];

    public function moralPersons()
    {
        return $this->hasMany(MoralPerson::class);
    }
}
