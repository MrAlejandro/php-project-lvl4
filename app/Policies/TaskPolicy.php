<?php

namespace App\Policies;

use App\Task;
use App\User;

class TaskPolicy
{
    public function destroy(?User $user, Task $task)
    {
        return (int) optional($user)->id === (int) $task->created_by_id;
    }
}
