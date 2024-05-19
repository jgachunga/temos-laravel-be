<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {

    return [
        'user_id' => $faker->randomDigitNotNull,
        'rep_id' => $faker->randomDigitNotNull,
        'reg_by_rep_id' => $faker->randomDigitNotNull,
        'name' => $faker->word,
        'phone' => $faker->word,
        'description' => $faker->word,
        'lat' => $faker->word,
        'lng' => $faker->word,
        'accuracy' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
