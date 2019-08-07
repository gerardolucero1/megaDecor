<?php

use App\Telephone;
use Faker\Generator as Faker;

$factory->define(Telephone::class, function (Faker $faker) {
    return [
        'cliente_id' => rand(1, 16),
        'nombre' => $faker->name,
        'email' => $faker->email,
        'tipo' => $faker->randomElement(['CELULAR', 'CASA', 'OFICINA']),
        'numero' => $faker->tollFreePhoneNumber,
        'ext' => rand(100, 999),

    ];
});
