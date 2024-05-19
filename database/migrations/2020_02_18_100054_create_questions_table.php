<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('form_id')->unsigned();
            $table->string('type');
            $table->boolean('required');
            $table->string('label');
            $table->string('desc')->nullable();
            $table->string('className')->nullable();
            $table->string('name')->nullable();
            $table->string('access')->nullable();
            $table->string('subtype')->nullable();
            $table->boolean('has_options')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('form_id')->references('id')->on('forms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('questions');
    }
}
