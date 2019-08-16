<?php

use App\MoralPerson;
use Faker\Generator as Faker;

$factory->define(MoralPerson::class, function (Faker $faker) {
    static $cliente_id = 10;
    return [
        'client_id' => $cliente_id++,
        'categoria_id' => rand(1, 6),
        'about_id' => rand(1, 5),
        'nombre' => $faker->name,
        'nombreFacturacion' => $faker->name,
        'direccionFActuracion' => $faker->streetName,
        'coloniaFacturacion' => $faker->secondaryAddress,
        'numeroFacturacion' => $faker->postcode,
        'rfcFacturacion' => $faker->swiftBicNumber,
        'emailFacturacion' => $faker->email,
        'tipoCredito' => $faker->randomElement(['SIN CREDITO', 'ORDINARIO', 'LABORAL']),
    ];
});
