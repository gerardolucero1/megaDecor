<?php

use App\MoralCategory;
use Faker\Generator as Faker;

$factory->define(MoralCategory::class, function (Faker $faker) {
    return [
        'nombre' => $faker->sentence(1),
    ];
});
