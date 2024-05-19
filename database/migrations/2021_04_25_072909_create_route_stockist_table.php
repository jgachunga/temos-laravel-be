<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouteStockistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_stockist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('route_id');
            $table->unsignedBigInteger('stockist_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('route_id')->references('id')->on('routes');
            $table->foreign('stockist_id')->references('id')->on('stockists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('route_stockist', function (Blueprint $table) {
            $table->dropForeign('route_stockist_route_id_foreign');
            $table->dropForeign('route_stockist_stockist_id_foreign');

        });
        Schema::dropIfExists('route_stockist');
    }
}
