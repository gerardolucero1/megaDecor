<?php

namespace App;

use App\Telephone;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'clave',
    ];

    public function telephones(){
        return $this->hasMany(App\Telephone::class);
    }
}
