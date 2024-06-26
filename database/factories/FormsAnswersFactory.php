<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\FormsAnswers;
use Faker\Generator as Faker;

$factory->define(FormsAnswers::class, function (Faker $faker) {

    return [
        'form_answered_id' => $faker->word,
        'question_id' => $faker->randomDigitNotNull,
        'question_type' => $faker->word,
        'answer' => $faker->word,
        'target' => $faker->word,
        'diff' => $faker->word,
        'answer_timestamp' => $faker->date('Y-m-d H:i:s'),
        'image_url' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
