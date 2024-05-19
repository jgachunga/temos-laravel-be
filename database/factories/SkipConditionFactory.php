<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SkipCondition;
use Faker\Generator as Faker;

$factory->define(SkipCondition::class, function (Faker $faker) {

    return [
        'question_id' => $faker->randomDigitNotNull,
        'label' => $faker->word,
        'value' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
