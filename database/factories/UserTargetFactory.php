<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserTarget;
use Faker\Generator as Faker;

$factory->define(UserTarget::class, function (Faker $faker) {

    return [
        'user_id' => $faker->word,
        'start_date' => $faker->word,
        'end_date' => $faker->word,
        'active' => $faker->word,
        'create_by' => $faker->word,
        'structure_id' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
