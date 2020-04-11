<?php

namespace App\Policies;

use App\User;
use App\TaskStatus;
use Illuminate\Auth\Access\Response;

class TaskStatusPolicy
{
    public function destroy(?User $user, TaskStatus $taskStatus)
    {
        if (empty($user)) {
            return Response::deny(__('policy.task_status.destroy.not_authenticated'));
        }

        return $this->hasAssociatedTasks($taskStatus)
            ? Response::deny(__('policy.task_status.destroy.cannot_remove_assigned'))
            : Response::allow();
    }

    private function hasAssociatedTasks($taskStatus)
    {
        return $taskStatus->tasks()->count() > 0;
    }
}
