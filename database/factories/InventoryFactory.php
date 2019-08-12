<?php

use App\Inventory;
use Faker\Generator as Faker;

$factory->define(Inventory::class, function (Faker $faker) {
    return [
        'servicio' => $faker->sentence(1),
        'cantidad' => rand(10, 89),
        'imagen' => $faker->imageUrl($width = 1200, $height = 400),
        'precioUnitario' => rand(30, 800),
    ];
});
