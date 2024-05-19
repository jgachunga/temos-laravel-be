<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SubCustomer;
use Faker\Generator as Faker;

$factory->define(SubCustomer::class, function (Faker $faker) {

    return [
        'user_id' => $faker->word,
        'rep_id' => $faker->randomDigitNotNull,
        'reg_by_rep_id' => $faker->randomDigitNotNull,
        'name' => $faker->word,
        'phone_number' => $faker->word,
        'email' => $faker->word,
        'first_name' => $faker->word,
        'last_name' => $faker->word,
        'channel_id' => $faker->randomDigitNotNull,
        'mocked' => $faker->word,
        'gpstimestamp' => $faker->word,
        'description' => $faker->word,
        'lat' => $faker->word,
        'lng' => $faker->word,
        'accuracy' => $faker->word,
        'speed' => $faker->word,
        'heading' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
