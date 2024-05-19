<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('town_id');
            $table->string('name', 45);
            $table->string('desc', 75)->nullable();
            $table->integer('structure_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('town_id')->references('id')->on('towns');
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
        Schema::table('stockists', function (Blueprint $table) {
            $table->dropForeign('stockists_town_id_foreign');
            $table->dropForeign('stockists_structure_id_foreign');
        });
        Schema::dropIfExists('stockists');
    }
}
