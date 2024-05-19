<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Teams;
use Faker\Generator as Faker;

$factory->define(Teams::class, function (Faker $faker) {

    return [
        'supervisor_id' => $faker->word,
        'name' => $faker->word,
        'structure_id' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
