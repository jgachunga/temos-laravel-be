<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserClient;
use Faker\Generator as Faker;

$factory->define(UserClient::class, function (Faker $faker) {

    return [
        'user_id' => $faker->word,
        'structure_id' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
