<?php

use App\PhysicalPerson;
use Faker\Generator as Faker;

$factory->define(PhysicalPerson::class, function (Faker $faker) {
    static $cliente_id = 1;
    return [
        'cliente_id' => $cliente_id++,
        'about_id' => rand(1, 5),
        'nombre' => $faker->name,
        'apellidoPaterno' => $faker->lastName,
        'apellidoMaterno' => $faker->firstName,
        'email' => $faker->email,
        'nombreFacturacion' => $faker->name,
        'direccionFActuracion' => $faker->streetName,
        'coloniaFacturacion' => $faker->secondaryAddress,
        'numeroFacturacion' => $faker->postcode,
        'rfcFacturacion' => $faker->swiftBicNumber,
        'emailFacturacion' => $faker->email,
    ];
});
