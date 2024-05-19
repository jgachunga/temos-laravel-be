<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\QuestionOption;
use Faker\Generator as Faker;

$factory->define(QuestionOption::class, function (Faker $faker) {

    return [
        'label' => $faker->word,
        'value' => $faker->word,
        'selected' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
