<?php

use App\Faltantes;
use Faker\Generator as Faker;

$factory->define(Faltantes::class, function (Faker $faker) {
    $cantidad = rand(10,89);
    $cantidad2 = rand(10,150);
    $cantidad3 = rand(10,200);
    $cantidad4 = rand(10,20);
    return [
        'nombre_de_persona'         => $faker->sentence(1),
        'contrato'                  => $cantidad,
        'fecha'                     => $cantidad2,
        'descripcion'               => $faker->sentence(3),
        'cantidad_que_falta'        => $cantidad3,
        'dias_desde_no_regreso'     => $cantidad,
        'id_article'                => $cantidad4,
    ];
});
