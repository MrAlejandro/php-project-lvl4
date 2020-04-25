<?php

namespace App\Policies;

use App\Task;
use App\User;

class TaskPolicy extends BasePolicy
{
    public function create(?User $user)
    {
        return $this->isAuthenticatedUser($user);
    }

    public function store(?User $user)
    {
        return $this->isAuthenticatedUser($user);
    }

    public function edit(?User $user)
    {
        return $this->isAuthenticatedUser($user);
    }

    public function update(?User $user)
    {
        return $this->isAuthenticatedUser($user);
    }

    public function delete(?User $user, Task $task)
    {
        return optional($user)->id == $task->created_by_id;
    }
}
