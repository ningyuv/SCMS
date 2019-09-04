<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Building;
use Faker\Generator as Faker;

$factory->define(Building::class, function (Faker $faker) {
    return [
        'name' => $faker->lastName.'Building'
    ];
});
