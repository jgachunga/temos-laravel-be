<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\TeamUser;
use Faker\Generator as Faker;

$factory->define(TeamUser::class, function (Faker $faker) {

    return [
        'team_id' => $faker->word,
        'user_id' => $faker->word,
        'active' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
