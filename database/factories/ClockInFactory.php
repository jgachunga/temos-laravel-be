<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ClockIn;
use Faker\Generator as Faker;

$factory->define(ClockIn::class, function (Faker $faker) {

    return [
        'user_id' => $faker->word,
        'clock_type' => $faker->word,
        'img_url' => $faker->word,
        'clock_in' => $faker->date('Y-m-d H:i:s'),
        'clock_out' => $faker->date('Y-m-d H:i:s'),
        'lat' => $faker->word,
        'long' => $faker->word,
        'accuracy' => $faker->word,
        'mocked' => $faker->word,
        'geotimestamp' => $faker->date('Y-m-d H:i:s'),
        'address' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
