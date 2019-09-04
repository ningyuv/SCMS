<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Admin;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'username' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$e09m/HOrwwQtK243oDu7Y.suOfU0jNrJd1rP38UiXjfK346we0ak.', // password
        'api_token' => Str::random(60),
        'remember_token' => Str::random(10),
    ];
});
