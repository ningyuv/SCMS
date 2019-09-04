<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Student;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Student::class, function (Faker $faker) {
    return [
        'username' => $faker->unique()->firstName,
        'password' => '$2y$10$e09m/HOrwwQtK243oDu7Y.suOfU0jNrJd1rP38UiXjfK346we0ak.',
        'number' => $faker->randomNumber(8),
        'name' => $faker->name,
        'gender' => $faker->numberBetween(1,2),
        'enrollment_year' => $faker->year,
        'major_id' => random_item(\App\Major::class),
        'api_token' => Str::random(60),
    ];
});
