<?php

use App\Label;
use Faker\Generator as Faker;

$factory->define(Label::class, function (Faker $faker) {
    return [
        'name' => $faker->word . $faker->unique()->randomNumber,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
