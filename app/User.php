<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Task;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'created_by_id');
    }

    public function assagnedTasks()
    {
        return $this->hasMany(User::class, 'assigned_to_id');
    }
}
