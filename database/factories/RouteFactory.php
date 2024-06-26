<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Route;
use Faker\Generator as Faker;

$factory->define(Route::class, function (Faker $faker) {

    return [
        'region_id' => $faker->word,
        'name' => $faker->word,
        'desc' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
