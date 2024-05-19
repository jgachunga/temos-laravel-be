<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDeviceInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_device_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('make')->nullable();
            $table->string('android_id')->nullable();
            $table->string('android_version')->nullable();
            $table->string('available_location_providers')->nullable();
            $table->string('battery_level')->nullable();
            $table->string('devicename')->nullable();
            $table->string('brand')->nullable();
            $table->string('apiLevel')->nullable();
            $table->string('appName')->nullable();
            $table->string('is_camera_present')->nullable();
            $table->string('device_id')->nullable();
            $table->string('appVersion')->nullable();
            $table->string('readable_version')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamp('timestamp')->nullable();
            $table->string('location_enabled')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_device_info', function (Blueprint $table) {
            $table->dropForeign('user_device_info_user_id_foreign');
        });
        Schema::dropIfExists('user_device_info');
    }
}
