<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Course;
use Faker\Generator as Faker;

$factory->define(Course::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName.'Course',
        'number' => $faker->randomNumber(9),
        'credit' => $faker->numberBetween(1,4),
        'department_id' => random_item(\App\Department::class)
    ];
});
