<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_photos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('form_answered_id')->unsigned();
            $table->integer('question_id')->unsigned();
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
        Schema::dropIfExists('form_photos');
    }
}
