<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('towns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('route_id')->nullable();
            $table->string('name', 45);
            $table->string('desc', 75)->nullable();
            $table->integer('structure_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('route_id')->references('id')->on('routes');
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
        Schema::table('towns', function (Blueprint $table) {
            $table->dropForeign('towns_route_id_foreign');
            $table->dropForeign('towns_structure_id_foreign');
        });
        Schema::dropIfExists('towns');
    }
}
