<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CurrentStatuses;
use Faker\Generator as Faker;

$factory->define(CurrentStatuses::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'desc' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
