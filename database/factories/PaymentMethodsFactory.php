<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PaymentMethods;
use Faker\Generator as Faker;

$factory->define(PaymentMethods::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'img_url' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
