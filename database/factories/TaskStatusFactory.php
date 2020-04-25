<?php

use App\TaskStatus;
use Faker\Generator as Faker;

$factory->define(TaskStatus::class, function (Faker $faker) {
    return [
        'name' => $faker->word . $faker->unique()->randomNumber,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
