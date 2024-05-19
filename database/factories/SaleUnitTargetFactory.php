<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SaleUnitTarget;
use Faker\Generator as Faker;

$factory->define(SaleUnitTarget::class, function (Faker $faker) {

    return [
        'structure_id' => $faker->randomDigitNotNull,
        'start_date' => $faker->word,
        'end_date' => $faker->word,
        'active' => $faker->word,
        'create_by' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
