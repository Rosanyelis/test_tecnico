<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Agenda;
use Faker\Generator as Faker;

$factory->define(Agenda::class, function (Faker $faker) {
    return [
        'nombre_materia' => $faker->word,
        'docente' => $faker->name,
        'tipo_materia' => $faker->randomElement(['Cualitativa', 'Cuantitativa']),
    ];
});
