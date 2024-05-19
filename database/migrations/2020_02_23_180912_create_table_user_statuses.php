<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 45);
            $table->string('desc')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('user_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->integer('form_id')->unsigned()->nullable();
            $table->integer('customer_id')->unsigned()->nullable();
            $table->bigInteger('current_status_id')->unsigned()->nullable();
            $table->timestamp('last_seen')->nullable();
            $table->decimal('lat', 8, 2)->nullable();
            $table->decimal('long', 8, 2)->nullable();
            $table->decimal('accuracy', 8, 2)->nullable();
            $table->boolean('mocked')->default(false);
            $table->timestamp('geotimestamp')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('form_id')->references('id')->on('forms');
            $table->foreign('current_status_id')->references('id')->on('current_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_statuses');
        Schema::dropIfExists('current_statuses');
    }
}
