<?php

use App\Task;
use App\TaskStatus;
use App\User;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'description' => $faker->text,
        'status_id' => factory(TaskStatus::class),
        'created_by_id' => factory(User::class),
        'assigned_to_id' => null,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
