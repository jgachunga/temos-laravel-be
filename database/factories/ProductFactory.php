<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'code' => $faker->word,
        'desc' => $faker->word,
        'cat_id' => $faker->randomDigitNotNull,
        'price' => $faker->randomDigitNotNull,
        'img_url' => $faker->word,
        'client_id' => $faker->randomDigitNotNull,
        'discount' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
