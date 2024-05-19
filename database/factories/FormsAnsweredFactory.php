<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\FormsAnswered;
use Faker\Generator as Faker;

$factory->define(FormsAnswered::class, function (Faker $faker) {

    return [
        'form_id' => $faker->randomDigitNotNull,
        'user_id' => $faker->word,
        'customer_id' => $faker->randomDigitNotNull,
        'status_id' => $faker->word,
        'status' => $faker->word,
        'reason' => $faker->word,
        'other_reasons' => $faker->word,
        'has_answers' => $faker->word,
        'start' => $faker->date('Y-m-d H:i:s'),
        'end' => $faker->date('Y-m-d H:i:s'),
        'duration' => $faker->date('Y-m-d H:i:s'),
        'lat' => $faker->word,
        'long' => $faker->word,
        'accuracy' => $faker->word,
        'latitude' => $faker->word,
        'mocked' => $faker->word,
        'geotimestamp' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
