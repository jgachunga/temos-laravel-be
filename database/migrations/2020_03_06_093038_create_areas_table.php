<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('region_id');
            $table->string('name', 45);
            $table->string('desc', 75)->nullable();
            $table->integer('structure_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('region_id')->references('id')->on('regions');
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
        Schema::table('areas', function (Blueprint $table) {
            $table->dropForeign('areas_region_id_foreign');
            $table->dropForeign('areas_structure_id_foreign');

        });
        Schema::dropIfExists('areas');
    }
}
