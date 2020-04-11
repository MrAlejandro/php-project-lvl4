<?php

namespace App\Policies;

use App\User;
use App\Label;
use Illuminate\Auth\Access\HandlesAuthorization;

class LabelPolicy
{
    use HandlesAuthorization;

    public function destroy(?User $user, Label $label)
    {
        if (empty($user)) {
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
