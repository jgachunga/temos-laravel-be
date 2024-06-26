<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SkipOption;
use Faker\Generator as Faker;

$factory->define(SkipOption::class, function (Faker $faker) {

    return [
        'condition' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
