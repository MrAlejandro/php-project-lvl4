<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Task;

class Label extends Model
{
    protected $fillable = ['name'];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_label');
    }
}
