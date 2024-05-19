<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSkipConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('skip_conditions', function (Blueprint $table) {
            $table->bigInteger('skip_option_id')->unsigned()->after('question_id')->nullable();
            $table->integer('selected_question_id')->unsigned()->after('question_id')->nullable();
            $table->string('label')->nullable()->change();
            $table->string('value')->nullable()->change();
            $table->foreign('selected_question_id')->references('id')->on('questions');
            $table->foreign('skip_option_id')->references('id')->on('skip_options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('skip_conditions', function (Blueprint $table) {
            $table->dropForeign('skip_conditions_skip_option_id_foreign');
            $table->dropForeign('skip_conditions_selected_question_id_foreign');
        });
        Schema::table('skip_conditions', function (Blueprint $table) {
            $table->dropColumn('skip_option_id');
            $table->dropColumn('selected_question_id');
        });
    }
}
