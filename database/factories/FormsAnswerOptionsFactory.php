<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\FormsAnswerOptions;
use Faker\Generator as Faker;

$factory->define(FormsAnswerOptions::class, function (Faker $faker) {

    return [
        'form_answer_id' => $faker->word,
        'question_id' => $faker->randomDigitNotNull,
        'question_type' => $faker->word,
        'question_option_id' => $faker->randomDigitNotNull,
        'answer' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
