<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Distributor;
use Faker\Generator as Faker;

$factory->define(Distributor::class, function (Faker $faker) {

    return [
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
