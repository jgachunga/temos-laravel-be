<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('form_answer_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->string('question_type')->nullable();
            $table->string('img_url')->nullable();
            $table->timestamps();

            $table->foreign('form_answer_id')->references('id')->on('form_answers');
            $table->foreign('question_id')->references('id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_images');
    }
}
