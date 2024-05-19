<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFormAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('form_answered_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->string('question_type')->nullable();
            $table->string('answer')->nullable();
            $table->string('target')->nullable();
            $table->string('diff')->nullable();
            $table->timestamp('answer_timestamp')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('form_answered_id')->references('id')->on('forms_answered');
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
        Schema::dropIfExists('form_answers');
    }
}
