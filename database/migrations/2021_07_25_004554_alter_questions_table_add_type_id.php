<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterQuestionsTableAddTypeId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->bigInteger('question_type_id')->unsigned()->after('type')->nullable();
            $table->foreign('question_type_id')->references('id')->on('question_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign('questions_question_type_id_foreign');
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('question_type_id');
        });
    }
}
