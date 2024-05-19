<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerSurveyDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_survey_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('customer_id')->unsigned()->nullable();
            $table->dateTime('started')->nullable();
            $table->dateTime('ended')->nullable();
            $table->dateTime('activeDate')->nullable();
            $table->string('category')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_survey_details', function (Blueprint $table) {
            $table->dropForeign('customer_survey_details_user_id_foreign');
            $table->dropForeign('customer_survey_details_customer_id_foreign');
        });
        Schema::dropIfExists('customer_survey_details');
    }
}
