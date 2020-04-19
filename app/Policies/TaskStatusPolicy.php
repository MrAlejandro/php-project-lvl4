<?php

namespace App\Policies;

use App\User;
use App\TaskStatus;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskStatusPolicy extends BasePolicy
{
    use HandlesAuthorization;

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

    public function destroy(?User $user, TaskStatus $taskStatus)
    {
        if (!$this->isAuthenticatedUser($user)) {
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
