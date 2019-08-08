<?php

use App\User;
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

$factory->define(User::class, function (Faker $faker) {
    return [
        'contrato' => $faker->unique()->safeEmail,
        'cliente' => $faker->name,
        'fecha' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'vendedor' => $faker->name,
        'lugar' => $faker->state,
        'version' => $faker->creditCardExpirationDate,
        'created_at' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'updated_at' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'opciones' => $faker->sentence,
        
    ];
});
