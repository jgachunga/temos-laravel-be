<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserDeviceImeis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_device_imeis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_device_info_id')->unsigned();
            $table->string('imei');
            $table->string('device_id')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_device_info_id')->references('id')->on('user_device_info');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_device_imeis', function (Blueprint $table) {
            $table->dropForeign('user_device_imeis_user_device_info_id_foreign');
        });
        Schema::dropIfExists('user_device_imeis');
    }
}
