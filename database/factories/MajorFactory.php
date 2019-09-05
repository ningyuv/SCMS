<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Major;
use Faker\Generator as Faker;

$factory->define(Major::class, function (Faker $faker) {
    return [
        'department_id' => random_item(\App\Department::class, true),
        'name' => $faker->unique()->lastName.'Major'
    ];
});
