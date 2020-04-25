<?php

namespace App\Policies;

use App\User;

class BasePolicy
{
    protected function isAuthenticatedUser(?User $user)
    {
        return !empty($user);
    }
}
