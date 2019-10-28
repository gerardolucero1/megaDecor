<?php

use App\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    $caracteres = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-.#!';
        for($x = 0; $x < 10; $x++){
            $aleatoria = substr(str_shuffle($caracteres), 0, 10);
        }
    return [
        'clave' => $aleatoria,
        'nombreCliente' => $faker->sentence(1),
        'tipoCredito' => $faker->randomElement(['MORAL', 'FISICA']),

        /* 
        'tipoPersona',
        'nombreCliente', */
    ];
});
