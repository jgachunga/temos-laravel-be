<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CustomerDetail;
use Faker\Generator as Faker;

$factory->define(CustomerDetail::class, function (Faker $faker) {

    return [
        'user_id' => $faker->word,
        'customer_id' => $faker->randomDigitNotNull,
        'started' => $faker->date('Y-m-d H:i:s'),
        'ended' => $faker->date('Y-m-d H:i:s'),
        'activeDate' => $faker->date('Y-m-d H:i:s'),
        'category' => $faker->word,
        'status' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
