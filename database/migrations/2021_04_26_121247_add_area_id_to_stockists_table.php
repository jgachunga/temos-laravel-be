<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAreaIdToStockistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stockists', function (Blueprint $table) {
            $table->unsignedBigInteger('area_id')->after('town_id')->nullable();
            $table->foreign('area_id')->references('id')->on('areas');
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
            $table->dropForeign('stockists_area_id_foreign');
        });
        Schema::table('stockists', function (Blueprint $table) {
            $table->dropColumn('area_id');
        });
    }
}
