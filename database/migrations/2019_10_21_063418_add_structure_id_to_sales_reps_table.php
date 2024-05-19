<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStructureIdToSalesRepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_reps', function (Blueprint $table) {
            $table->integer('structure_id')->after('description')->unsigned()->nullable();
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
        Schema::table('sales_reps', function (Blueprint $table) {
            //
        });
    }
}
