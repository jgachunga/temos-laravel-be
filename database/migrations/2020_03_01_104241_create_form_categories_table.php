<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFormCategoriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('structure_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('structure_id')->references('id')->on('sale_structures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_categories', function (Blueprint $table) {
            $table->dropForeign('form_categories_structure_id_foreign');
        });
        Schema::drop('form_categories');
    }
}
