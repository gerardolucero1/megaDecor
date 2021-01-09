<?php

namespace App;

use App\Telephone;
use App\Celebrated;
use App\MoralPerson;
use App\BudgetVersion;
use App\PhysicalPerson;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'clave',
        'tipoPersona',
        'nombreCliente',
        'vetado',
        'motivo',
    ];

    public function telephones(){
        return $this->hasMany(Telephone::class);
    }

    public function moralPersons()
    {
        return $this->hasMany(MoralPerson::class);
    }

    public function physicalPersons()
    {
        return $this->hasMany(PhysicalPerson::class);
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    public function budgetsVersions()
    {
        return $this->hasMany(BudgetVersion::class);
    }

    public function celebrateds()
    {
        return $this->hasMany(Celebrated::class);
    }

}
