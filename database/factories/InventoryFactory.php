<?php

use App\Inventory;
use Faker\Generator as Faker;

$factory->define(Inventory::class, function (Faker $faker) {
    return [
        'nombre' => $faker->sentence(1),
        'cantidad' => rand(1, 20),
        'medida' => $faker->sentence(1),
    ];
});
