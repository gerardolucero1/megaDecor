<?php

use App\Inventory;
use Faker\Generator as Faker;

$factory->define(Inventory::class, function (Faker $faker) {
    $cantidad = rand(10,89);
    return [
        'servicio' => $faker->sentence(1),
        'cantidad' => $cantidad,
        'disponible' => $cantidad,
        'imagen' => $faker->imageUrl($width = 1200, $height = 400),
        'precioUnitario' => rand(30, 800),
    ];
});
