<?php

namespace App\Policies;

use App\User;
use App\TaskStatus;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskStatusPolicy
{
    use HandlesAuthorization;

    public function destroy(?User $user, TaskStatus $taskStatus)
    {
        if (empty($user)) {
            return $this->deny(__('policy.task_status.destroy.not_authenticated'));
        }

        return $this->hasAssociatedTasks($taskStatus)
            ? $this->deny(__('policy.task_status.destroy.cannot_remove_assigned'))
            : $this->allow();
    }

    private function hasAssociatedTasks($taskStatus)
    {
        return $taskStatus->tasks()->count() > 0;
    }
}
