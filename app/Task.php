<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TaskStatus;
use App\Label;
use App\User;

class Task extends Model
{
    protected $fillable = ['name', 'description', 'status_id', 'assigned_to_id'];

    public function status()
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class, 'task_label');
    }
}
