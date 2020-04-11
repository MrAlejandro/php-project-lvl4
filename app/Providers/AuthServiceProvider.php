<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\TaskPolicy;
use App\Task;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Task::class => TaskPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('authenticated-user', function ($user) {
            return !empty($user);
        });
    }
}
