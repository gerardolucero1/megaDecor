<?php

namespace App;

use App\Client;
use App\MoralPerson;
use Illuminate\Database\Eloquent\Model;

class AboutCategory extends Model
{
    protected $fillable = [
        'nombre',
    ];

    public function moralPersons()
    {
        return $this->hasMany(MoralPerson::class);
    }

    public function physicalPersons()
    {
        return $this->hasMany(PhysicalPerson::class);
    }
}
