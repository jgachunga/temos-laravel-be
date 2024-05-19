<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Invoice;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {

    return [
        'ref' => $faker->word,
        'business_code' => $faker->word,
        'sub_total' => $faker->word,
        'discount' => $faker->word,
        'total_tax' => $faker->word,
        'grand_total' => $faker->word,
        'date_due' => $faker->date('Y-m-d H:i:s'),
        'is_approved' => $faker->word,
        'created_by' => $faker->word,
        'customer_id' => $faker->randomDigitNotNull,
        'approved_by' => $faker->word,
        'updated_by' => $faker->word,
        'payment_details' => $faker->text,
        'terms' => $faker->text,
        'footer' => $faker->text,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'structure_id' => $faker->randomDigitNotNull
    ];
});
