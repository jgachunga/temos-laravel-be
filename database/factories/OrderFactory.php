<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {

    return [
        'structure_id' => $faker->randomDigitNotNull,
        'order_ref' => $faker->randomDigitNotNull,
        'pax' => $faker->word,
        'total_amount' => $faker->word,
        'discount' => $faker->word,
        'amount_payable' => $faker->word,
        'customer_id' => $faker->randomDigitNotNull,
        'opened_by' => $faker->randomDigitNotNull,
        'closed_by' => $faker->randomDigitNotNull,
        'closed_at' => $faker->date('Y-m-d H:i:s'),
        'terminal_id' => $faker->randomDigitNotNull,
        'shift_id' => $faker->randomDigitNotNull,
        'is_printed' => $faker->word,
        'is_active' => $faker->word,
        'is_shown' => $faker->word,
        'is_closed' => $faker->word,
        'is_void' => $faker->word,
        'display_name' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
