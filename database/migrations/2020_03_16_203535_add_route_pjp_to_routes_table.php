<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoutePjpToRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->bigInteger('route_pjp')->after('desc')->unsigned()->nullable();
            $table->foreign('route_pjp')->references('id')->on('route_pjps');

            $table->bigInteger('user_id')->after('desc')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->dropForeign('routes_region_pjp_foreign');
            $table->dropColumn('routes_pjp');
            $table->dropForeign('routes_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
}
