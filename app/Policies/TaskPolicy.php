<?php

namespace App\Policies;

use App\Task;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function destroy(?User $user, Task $task)
    {
        return (int) optional($user)->id === (int) $task->created_by_id;
    }
}
