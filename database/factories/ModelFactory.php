<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'firstName' => $faker->name,
        'lastName' => $faker->name,
        'email' => $faker->unique()->email,
        'number' => $faker->phoneNumber,
        'role' => random_int(0, 2),
        'password' => bcrypt('1234'),
    ];
});
