<?php

use App\AboutCategory;
use Faker\Generator as Faker;

$factory->define(AboutCategory::class, function (Faker $faker) {
    return [
        'nombre' => $faker->sentence(1),
    ];
});
