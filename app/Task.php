<?php

namespace App;

use App\TaskComment;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'vendedor_id',
        'categoria',
        'cliente_id',
        'fecha',
        'notas',
        'completa'

    ];

    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }
}
