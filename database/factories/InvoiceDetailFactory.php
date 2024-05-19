<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\InvoiceDetail;
use Faker\Generator as Faker;

$factory->define(InvoiceDetail::class, function (Faker $faker) {

    return [
        'invoice_id' => $faker->word,
        'product_id' => $faker->randomDigitNotNull,
        'product_code' => $faker->word,
        'price' => $faker->word,
        'quantity' => $faker->word,
        'taxes' => $faker->word,
        'total_amount' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
