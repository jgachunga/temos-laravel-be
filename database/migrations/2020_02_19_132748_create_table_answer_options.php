<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAnswerOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_answer_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('form_answer_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->string('question_type')->nullable();
            $table->integer('question_option_id')->unsigned()->nullable();
            $table->string('answer')->nullable();
            $table->timestamps();

            $table->foreign('form_answer_id')->references('id')->on('form_answers');
            $table->foreign('question_id')->references('id')->on('questions');
            $table->foreign('question_option_id')->references('id')->on('question_options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_answer_options');
    }
}
