<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSaleUnitTargets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_unit_targets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('structure_id')->unsigned()->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->double('target');
            $table->boolean('active');
            $table->bigInteger('create_by')->unsigned()->nullable();
            $table->foreign('structure_id')->references('id')->on('sale_structures');
            $table->foreign('create_by')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_unit_targets', function (Blueprint $table) {
            $table->dropForeign('sale_unit_targets_structure_id_foreign');
            $table->dropForeign('sale_unit_targets_create_by_foreign');
        });
        Schema::dropIfExists('sale_unit_targets');
    }
}
