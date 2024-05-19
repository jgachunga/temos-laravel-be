<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OrderDetail;
use Faker\Generator as Faker;

$factory->define(OrderDetail::class, function (Faker $faker) {

    return [
        'order_id' => $faker->word,
        'product_code' => $faker->word,
        'quantity' => $faker->word,
        'sku' => $faker->word,
        'price' => $faker->word,
        'price_from' => $faker->word,
        'total' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
