<?php

namespace App\Policies;

use App\User;
use App\Label;
use Illuminate\Auth\Access\HandlesAuthorization;

class LabelPolicy extends BasePolicy
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

    public function delete(?User $user, Label $label)
    {
        if (!$this->isAuthenticatedUser($user)) {
            return $this->deny(__('policy.label.destroy.not_authenticated'));
        }

        return $this->hasAssociatedTasks($label)
            ? $this->deny(__('policy.label.destroy.cannot_remove_assigned'))
            : $this->allow();
    }

    private function hasAssociatedTasks($label)
    {
        return $label->tasks()->count() > 0;
    }
}
