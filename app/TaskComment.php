<?php

namespace App;

use App\Task;
use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{
    protected $fillable = [
        'task_id',
        'comment',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
