<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Version;
use Faker\Generator as Faker;

$factory->define(Version::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'code' => $faker->word,
        'active' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
