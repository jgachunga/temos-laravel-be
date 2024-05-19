<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('rep_id')->unsigned()->nullable();
            $table->integer('reg_by_rep_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('sub_domain')->nullable();
            $table->string('business_email')->nullable();
            $table->string('business_phone_number')->nullable();
            $table->string('postal_address')->nullable();
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('channel_id')->unsigned()->nullable();
            $table->boolean('mocked')->default(false);
            $table->string('gpstimestamp')->nullable();
            $table->string('description')->nullable();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 10, 8)->nullable();
            $table->string('accuracy', 50)->nullable();
            $table->decimal('speed', 4, 4)->nullable();
            $table->string('heading', 30)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('rep_id')->references('id')->on('sales_reps');
            $table->foreign('reg_by_rep_id')->references('id')->on('sales_reps');
            $table->foreign('channel_id')->references('id')->on('channels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
