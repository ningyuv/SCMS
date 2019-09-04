<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Teacher;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Teacher::class, function (Faker $faker) {
    return [
        'username' => $faker->unique()->firstName,
        'password' => '$2y$10$e09m/HOrwwQtK243oDu7Y.suOfU0jNrJd1rP38UiXjfK346we0ak.',
        'api_token' => Str::random(60),
        'name' => $faker->name,
        'gender' => $faker->numberBetween(1,2),
        'number' => $faker->randomNumber(4)
    ];
});
