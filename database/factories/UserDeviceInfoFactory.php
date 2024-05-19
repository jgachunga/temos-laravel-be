<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserDeviceInfo;
use Faker\Generator as Faker;

$factory->define(UserDeviceInfo::class, function (Faker $faker) {

    return [
        'user_id' => $faker->word,
        'make' => $faker->word,
        'android_id' => $faker->word,
        'available_location_providers' => $faker->word,
        'battery_level' => $faker->word,
        'api_level' => $faker->word,
        'brand' => $faker->word,
        'is_camera_present' => $faker->word,
        'device_id' => $faker->word,
        'version' => $faker->word,
        'active' => $faker->word,
        'location_enabled' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
