<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OutletVisit;
use Faker\Generator as Faker;

$factory->define(OutletVisit::class, function (Faker $faker) {

    return [
        'user_id' => $faker->word,
        'form_id' => $faker->randomDigitNotNull,
        'customer_id' => $faker->randomDigitNotNull,
        'current_status_id' => $faker->word,
        'status_id' => $faker->word,
        'status' => $faker->word,
        'reason' => $faker->word,
        'other_reasons' => $faker->word,
        'has_answers' => $faker->word,
        'timestamp' => $faker->date('Y-m-d H:i:s'),
        'started_timestamp' => $faker->date('Y-m-d H:i:s'),
        'lat' => $faker->word,
        'long' => $faker->word,
        'accuracy' => $faker->word,
        'mocked' => $faker->word,
        'geotimestamp' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
