<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Region;
use Faker\Generator as Faker;

$factory->define(Region::class, function (Faker $faker) {

    return [
        'country_id' => $faker->word,
        'name' => $faker->word,
        'desc' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
