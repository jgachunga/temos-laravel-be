<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserDeviceImei;
use Faker\Generator as Faker;

$factory->define(UserDeviceImei::class, function (Faker $faker) {

    return [
        'user_device_info_id' => $faker->word,
        'imei' => $faker->word,
        'device_id' => $faker->word,
        'active' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
