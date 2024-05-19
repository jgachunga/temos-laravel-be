<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CustomerSaleStructrure;
use Faker\Generator as Faker;

$factory->define(CustomerSaleStructrure::class, function (Faker $faker) {

    return [
        'cust_id' => $faker->randomDigitNotNull,
        'structure_id' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
