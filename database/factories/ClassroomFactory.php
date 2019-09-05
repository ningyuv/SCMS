<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Classroom;
use Faker\Generator as Faker;

$factory->define(Classroom::class, function (Faker $faker) {
    return [
        'building_id' => random_item(\App\Building::class, true),
        'name' => $faker->lastName.'Classroom',
        'number' => $faker->randomNumber(3)
    ];
});
