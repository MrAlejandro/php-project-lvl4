<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\TaskStatusPolicy;
use App\Policies\TaskPolicy;
use App\Policies\LabelPolicy;
use App\TaskStatus;
use App\Task;
use App\Label;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Task::class => TaskPolicy::class,
        Label::class => LabelPolicy::class,
        TaskStatus::class => TaskStatusPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
