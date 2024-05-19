<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\QuestionImages;
use Faker\Generator as Faker;

$factory->define(QuestionImages::class, function (Faker $faker) {

    return [
        'question_id' => $faker->randomDigitNotNull,
        'label' => $faker->word,
        'value' => $faker->word,
        'selected' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
