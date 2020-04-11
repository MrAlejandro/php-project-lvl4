<?php

use App\Label;
use Faker\Generator as Faker;

$factory->define(Label::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
